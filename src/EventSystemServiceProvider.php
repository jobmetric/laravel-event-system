<?php

namespace JobMetric\EventSystem;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;
use JobMetric\EventSystem\Support\EventBus;
use JobMetric\EventSystem\Support\EventRegistry;
use JobMetric\PackageCore\Enums\RegisterClassTypeEnum;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\RegisterClassTypeNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class EventSystemServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @param PackageCore $package
     *
     * @return void
     * @throws MigrationFolderNotFoundException
     * @throws RegisterClassTypeNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-event-system')
            ->hasConfig()
            ->hasMigration()
            ->hasTranslation()
            ->registerClass('EventSystem', EventSystem::class, RegisterClassTypeEnum::SINGLETON())
            ->registerClass('event', EventServiceProvider::class, RegisterClassTypeEnum::REGISTER())
            ->registerClass('EventRegistry', EventRegistry::class, RegisterClassTypeEnum::SINGLETON())
            ->registerClass('EventBus', function ($app) {
                return new EventBus($app->make(Dispatcher::class), $app->make(EventRegistry::class));
            }, RegisterClassTypeEnum::SINGLETON());
    }

    /**
     * after register package
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function afterRegisterPackage(): void
    {
        /** @var EventRegistry $registry */
        $registry = $this->app->make('EventRegistry');

        $registry->register(\JobMetric\EventSystem\Events\EventSystemDeletedEvent::class);
        $registry->register(\JobMetric\EventSystem\Events\EventSystemDeletingEvent::class);
        $registry->register(\JobMetric\EventSystem\Events\EventSystemStoredEvent::class);
    }
}
