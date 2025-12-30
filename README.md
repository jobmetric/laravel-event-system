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

**Build Event-Driven Applications. Effortlessly.**

Laravel Event System simplifies dynamic event management in Laravel applications. Stop managing events statically in service providers and start building flexible, maintainable event-driven architectures that adapt to your needs. It provides a flexible layer on top of Laravel's native event system, allowing you to register and manage events at runtime—perfect for modular applications, plugin-based systems, and event-driven architectures. This is where powerful event management meets developer-friendly simplicity—giving you complete control over your event system without the complexity.

## Why Laravel Event System?

### Dynamic Event Registration

Unlike traditional Laravel event systems that require static registration in service providers, Laravel Event System allows you to register and manage events dynamically at runtime. This means you can add, remove, or modify event listeners without code changes—perfect for modular applications and plugin systems.

### Domain Event Architecture

The package provides a robust foundation for domain-driven design with its `DomainEvent` contract and `EventRegistry`. Create domain events with stable keys, rich metadata, and consistent structure across your application.

### Runtime Flexibility

Enable or disable event listeners on the fly. Change priorities, update configurations, and manage your entire event system through a simple API or database-driven configuration. No deployment needed for event management changes.

### Event Bus & Registry

Dispatch events by stable keys instead of hard-coding class names. The `EventBus` and `EventRegistry` provide a clean abstraction layer that decouples your code from concrete event classes, making your application more maintainable and testable.

## What is Event System Management?

Event system management is the process of dynamically registering, configuring, and managing event-listener bindings in your application. Traditional Laravel applications require you to register events statically in service providers, but Laravel Event System takes a different approach:

- **Database-Driven**: Event-listener bindings are stored in the database, making them manageable at runtime
- **Dynamic Registration**: Add or remove event listeners without code changes
- **Priority Control**: Control the execution order of listeners with priority values
- **Status Toggle**: Enable or disable listeners without removing them
- **Domain Events**: Use stable keys and rich metadata for domain events

Consider a plugin system that needs to register its own events. With Laravel Event System, you can register events with stable keys, dispatch them by key without hard-coding class names, build UI components that list available events with their metadata, enable or disable event handlers through an admin interface, and track event usage and analytics. The power of event system management lies not only in dynamic registration but also in making events easily manageable, configurable, and scalable throughout your application.

## What Awaits You?

By adopting Laravel Event System, you will:

- **Build flexible plugin systems** - Allow plugins to register their own events dynamically
- **Simplify event management** - No more static event registration in service providers
- **Improve maintainability** - Decouple your code from concrete event classes
- **Enable runtime configuration** - Manage events through UI or API without deployments
- **Scale effortlessly** - Handle complex event-driven architectures with ease
- **Maintain clean code** - Simple, intuitive API that follows Laravel conventions

## Quick Start

Install Laravel Event System via Composer:

```bash
composer require jobmetric/laravel-event-system
```

## Documentation

Ready to transform your Laravel applications? Our comprehensive documentation is your gateway to mastering Laravel Event System:

**[📚 Read Full Documentation →](https://jobmetric.github.io/packages/laravel-event-system/)**

The documentation includes:

- **Getting Started** - Quick introduction and installation guide
- **EventSystem Service** - Complete API reference for managing events
- **DomainEvent** - Implement domain events with stable keys and metadata
- **EventBus & EventRegistry** - Dispatch events by keys and manage event registration
- **Requests & Resources** - Validation and API response handling
- **Events** - Hook into event system lifecycle
- **Real-World Examples** - See how it works in practice

## Contributing

Thank you for participating in `laravel-event-system`. A contribution guide can be found [here](CONTRIBUTING.md).

## License

The `laravel-event-system` is open-sourced software licensed under the MIT license. See [License File](LICENCE.md) for more information.
