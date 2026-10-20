<?php

namespace JobMetric\EventSystem\Tests\Feature;

use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseTransactionsManager;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Testing\Fakes\EventFake;
use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\CommittedEventDispatcher;
use JobMetric\EventSystem\Support\DomainEventDefinition;
use PDO;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CommittedEventDispatcherTest extends TestCase
{
    private SQLiteConnection $connection;
    private Dispatcher $events;
    private CommittedEventDispatcher $bus;
    private array $received;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = new SQLiteConnection(new PDO('sqlite::memory:'), ':memory:', '', ['name' => 'testing']);
        $this->connection->setTransactionManager(new DatabaseTransactionsManager());
        $database = $this->createStub(DatabaseManager::class);
        $database->method('connection')->willReturn($this->connection);
        $this->events = new Dispatcher(new Container());
        $this->bus = new CommittedEventDispatcher($database, $this->events, $this->createStub(LoggerInterface::class));
        $this->received = [];
        $this->events->listen(CommittedOutcome::class, function (CommittedOutcome $event): void {
            $this->received[] = $event->id;
        });
    }

    public function test_nested_commit_delivers_once_only_after_outer_commit(): void
    {
        $this->connection->beginTransaction();
        $this->connection->beginTransaction();
        $this->bus->dispatch(new CommittedOutcome(12));
        $this->connection->commit();
        self::assertSame([], $this->received);
        $this->connection->commit();
        self::assertSame([12], $this->received);
    }

    public function test_outer_rollback_discards_events_from_committed_inner_transaction(): void
    {
        $this->connection->beginTransaction();
        $this->connection->beginTransaction();
        $this->bus->dispatch(new CommittedOutcome(12));
        $this->connection->commit();
        $this->connection->rollBack();
        $this->connection->transaction(fn () => null);
        self::assertSame([], $this->received);
    }

    public function test_inner_rollback_preserves_only_outer_outcome(): void
    {
        $this->connection->beginTransaction();
        $this->bus->dispatch(new CommittedOutcome(1));
        $this->connection->beginTransaction();
        $this->bus->dispatch(new CommittedOutcome(2));
        $this->connection->rollBack();
        $this->connection->commit();
        self::assertSame([1], $this->received);
    }

    public function test_listener_and_logger_failures_do_not_escape_or_skip_later_listeners(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())->method('error')->with(
            'Committed domain event listener failed.',
            ['event' => CommittedOutcome::key(), 'exception_class' => RuntimeException::class]
        )->willThrowException(new RuntimeException('logging unavailable'));
        $database = $this->createStub(DatabaseManager::class);
        $database->method('connection')->willReturn($this->connection);
        $this->events->listen(CommittedOutcome::class, fn () => throw new RuntimeException('sensitive data'));
        $this->events->listen(CommittedOutcome::class, function (): void {
            $this->received[] = 99;
        });
        $bus = new CommittedEventDispatcher($database, $this->events, $logger);
        $this->connection->transaction(fn () => $bus->dispatch(new CommittedOutcome(3)));
        self::assertSame([3, 99], $this->received);
        self::assertSame(0, $this->connection->transactionLevel());
    }

    public function test_delivery_outside_transaction_supports_wildcard_and_interface_listeners(): void
    {
        $this->events->listen(DomainEvent::class, function (): void {
            $this->received[] = 8;
        });
        $this->events->listen('*CommittedOutcome', function (string $name, array $payload): void {
            self::assertSame(CommittedOutcome::class, $name);
            self::assertSame(7, $payload[0]->id);
            $this->received[] = 9;
        });
        $this->bus->dispatch(new CommittedOutcome(7));
        self::assertSame([7, 9, 8], $this->received);
    }

    public function test_explicit_connection_owns_the_commit_callback(): void
    {
        $database = $this->createMock(DatabaseManager::class);
        $database->expects(self::once())->method('connection')->with('content')->willReturn($this->connection);
        $bus = new CommittedEventDispatcher($database, $this->events, $this->createStub(LoggerInterface::class));
        $this->connection->beginTransaction();
        $bus->dispatch(new CommittedOutcome(4), 'content');
        self::assertSame([], $this->received);
        $this->connection->commit();
        self::assertSame([4], $this->received);
    }

    public function test_laravel_event_fake_records_committed_outcomes(): void
    {
        $fake = new EventFake($this->events);
        $database = $this->createStub(DatabaseManager::class);
        $database->method('connection')->willReturn($this->connection);
        $bus = new CommittedEventDispatcher($database, $fake, $this->createStub(LoggerInterface::class));
        $this->connection->beginTransaction();
        $bus->dispatch(new CommittedOutcome(5));
        $fake->assertNotDispatched(CommittedOutcome::class);
        $this->connection->commit();
        $fake->assertDispatchedTimes(CommittedOutcome::class, 1);
    }
}

class CommittedOutcome implements DomainEvent
{
    public function __construct(public int $id) {}

    public static function key(): string
    {
        return 'testing.outcome';
    }

    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'testing', 'testing', 'testing');
    }
}
