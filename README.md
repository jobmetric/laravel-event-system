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

# Event System for laravel

The EventSystem package provides an easy-to-use system for managing custom events and their listeners in Laravel. It allows you to  manage the status of events within your application. This package is highly flexible and integrates seamlessly with Laravel's built-in event system.

## Install via composer

Run the following command to pull in the latest version:

```bash
composer require jobmetric/laravel-event-system
```

## Documentation

>#### Before doing anything, you must migrate after installing the package by composer.

```bash
php artisan migrate
```

## How is it used?

Some programs need to add listeners to the system when they are installed, and these listeners are lost when they are removed. Using the following methods, we can add and subtract these tasks in the system.

### Add Event

```php
addEventSystem('event name', event_class::class, listener_class::class, 'optional description');
```

> The `event name` is the name of the event that you want to add to the system and must be unique.
> 
> The `event_class` and `listener_class` must be the full path of the class.
> 
> The `optional description` is optional and is used to describe the event.

### Remove Event

```php
removeEventSystem('event name');
```

> The `event name` is the name of the event that you want to remove from the system.

## Events

This package contains several events for which you can write a listener as follows

| Event                    | Description                                           |
|--------------------------|-------------------------------------------------------|
| `EventSystemStoreEvent`  | This event is called after storing the event system.  |
| `EventSystemDeleteEvent` | This event is called after deleting the event system. |

## Contributing

Thank you for considering contributing to the Laravel Event System! The contribution guide can be found in the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-event-system/blob/master/CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [License File](https://github.com/jobmetric/laravel-event-system/blob/master/LICENCE.md) for more information.
