<?php

namespace JobMetric\EventSystem\Support;

use Illuminate\Database\DatabaseManager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Events\Dispatcher as LaravelDispatcher;
use JobMetric\EventSystem\Contracts\DomainEvent;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Deliver safe domain outcomes after their owning database transaction commits.
 */
class CommittedEventDispatcher
{
    /**
     * Connect transaction scheduling, Laravel listeners and sanitized failure logging.
     *
     * @param DatabaseManager $database
     * @param Dispatcher $events
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function __construct(
        private DatabaseManager $database,
        private Dispatcher $events,
        private LoggerInterface $logger
    ) {
    }

    /**
     * Schedule an immutable, minimal outcome on the connection that owns its mutation.
     *
     * Callers must exclude secrets and suppress unchanged or unsuccessful operations.
     * Outside a transaction delivery is immediate. Rollback discards the callback.
     *
     * @param DomainEvent $event
     * @param string|null $connection
     *
     * @return void
     */
    public function dispatch(DomainEvent $event, ?string $connection = null): void
    {
        $database = $this->database->connection($connection);
        $deliver = function () use ($event): void {
            $this->deliver($event);
        };

        if ($database->transactionLevel() > 0) {
            $database->afterCommit($deliver);
        } else {
            $deliver();
        }
    }

    /**
     * Invoke each Laravel listener independently without exposing exception payloads.
     *
     * @param DomainEvent $event
     *
     * @return void
     */
    private function deliver(DomainEvent $event): void
    {
        try {
            if (! $this->events instanceof LaravelDispatcher) {
                $this->events->dispatch($event);

                return;
            }

            $listeners = $this->events->getListeners($event::class);
        } catch (Throwable $exception) {
            $this->logFailure($event, $exception);

            return;
        }

        foreach ($listeners as $listener) {
            try {
                $listener($event::class, [$event]);
            } catch (Throwable $exception) {
                $this->logFailure($event, $exception);
            }
        }
    }

    /**
     * Record only the event key and exception class, even when logging fails.
     *
     * @param DomainEvent $event
     * @param Throwable $exception
     *
     * @return void
     */
    private function logFailure(DomainEvent $event, Throwable $exception): void
    {
        try {
            $this->logger->error('Committed domain event listener failed.', [
                'event' => $event::key(),
                'exception_class' => $exception::class,
            ]);
        } catch (Throwable) {
            // Observability failures cannot invalidate a committed operation.
        }
    }
}
