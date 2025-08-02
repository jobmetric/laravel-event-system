[contributors-shield]: https://img.shields.io/github/contributors/jobmetric/laravel-event-system.svg?style=for-the-badge
[contributors-url]: https://github.com/jobmetric/laravel-event-system/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/jobmetric/laravel-event-system.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/jobmetric/laravel-event-system/network/members
[stars-shield]: https://img.shields.io/github/stars/jobmetric/laravel-event-system.svg?style=for-the-badge
[stars-url]: https://github.com/jobmetric/laravel-event-system/stargazers
[license-shield]: https://img.shields.io/github/license/jobmetric/laravel-event-system.svg?style=for-the-badge
[license-url]: https://github.com/jobmetric/laravel-event-system/blob/master/LICENCE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/majidmohammadian

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

# Laravel Event System

**Laravel Event System** is a flexible and elegant package designed to simplify dynamic event management. It provides a layer on top of Laravel’s native event system, allowing for the registration and removal of events at runtime — perfect for modular applications and plugin-based systems.

## 📦 Installation

Install the package via Composer:

```bash
composer require jobmetric/laravel-event-system
```

Then publish the migration and run it:

```bash
php artisan migrate
```

## ⚙️ Configuration

The default configuration can be published using:

```bash
php artisan vendor:publish --tag=event-system-config
```

### Config Options

```php
return [

    "cache_time" => env("EVENT_SYSTEM_CACHE_TIME", 60),

    "cache_key" => env("EVENT_SYSTEM_CACHE_KEY", "event_system_cache"),

    "tables" => [
        'event' => 'events',
    ],
];
```

## 🚀 Usage

You can dynamically register or remove events at runtime using the helper functions:

### Register an Event

```php
addEventSystem('user.created', App\Events\UserCreated::class, App\Listeners\SendWelcomeEmail::class, 'Triggered when a new user registers');
```

### Remove an Event

```php
removeEventSystem('user.created');
```

## 🎧 System Events

The package also emits its own events:

| Event                      | Description                                   |
|----------------------------|-----------------------------------------------|
| `EventSystemStoreEvent`    | Dispatched after an event has been registered |
| `EventSystemDeletingEvent` | Dispatched before an event is removed         |
| `EventSystemDeletedEvent`  | Dispatched after an event has been removed    |

## Contributing

Thank you for considering contributing to the Laravel Event System! The contribution guide can be found in the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-event-system/blob/master/CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [License File](https://github.com/jobmetric/laravel-event-system/blob/master/LICENCE.md) for more information.
