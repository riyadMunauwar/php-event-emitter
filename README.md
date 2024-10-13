# PHP Event and Listener System

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Core Components](#core-components)
4. [Usage](#usage)
5. [Best Practices](#best-practices)
6. [Advanced Topics](#advanced-topics)

## Introduction

This PHP Event and Listener System provides a flexible and robust solution for implementing event-driven architecture in your PHP applications. It allows you to decouple various parts of your application by using events and listeners, promoting a more maintainable and extensible codebase.

## Installation

To use this system in your project, simply include the provided PHP files in your project and use Composer's autoloading or require them manually.

```php
require_once 'path/to/EventSystem/Event.php';
require_once 'path/to/EventSystem/EventDispatcher.php';
require_once 'path/to/EventSystem/ListenerProvider.php';
require_once 'path/to/EventSystem/EventDispatcherAwareTrait.php';
```

## Core Components

### Event

The `Event` class represents an event in your system. It contains a name and optional data associated with the event.

```php
use EventSystem\Event;

$event = new Event('user.registered', ['user_id' => 123]);
```

### EventDispatcher

The `EventDispatcher` is responsible for managing listeners and dispatching events.

```php
use EventSystem\EventDispatcher;

$dispatcher = new EventDispatcher();
```

### ListenerProvider

The `ListenerProvider` is a simple class for registering and retrieving listeners for events.

```php
use EventSystem\ListenerProvider;

$provider = new ListenerProvider();
```

### EventDispatcherAwareTrait

This trait can be used in your classes to easily integrate event dispatching functionality.

```php
use EventSystem\EventDispatcherAwareTrait;

class YourClass
{
    use EventDispatcherAwareTrait;
}
```

## Usage

### Registering Listeners

You can register listeners for specific events using the `EventDispatcher`:

```php
$dispatcher->addListener('user.registered', function(Event $event) {
    // Handle the event
});
```

### Dispatching Events

To dispatch an event, create an `Event` object and use the `dispatch` method of the `EventDispatcher`:

```php
$event = new Event('user.registered', ['user_id' => 123]);
$dispatcher->dispatch($event);
```

### Using the EventDispatcherAwareTrait

Classes using this trait can easily dispatch events:

```php
class UserController
{
    use EventDispatcherAwareTrait;

    public function register($userData)
    {
        // Registration logic...

        $event = new Event('user.registered', $userData);
        $this->dispatch($event);
    }
}
```

## Best Practices

1. **Naming Conventions**: Use dot notation for event names (e.g., 'user.registered', 'order.completed') to organize events hierarchically.

2. **Event Objects**: Create specific event classes for complex events, extending the base `Event` class.

3. **Listener Organization**: Group related listeners into service classes for better organization.

4. **Avoid Heavy Processing**: Keep listeners lightweight. For heavy processing, consider using a queue system.

5. **Error Handling**: Implement try-catch blocks in listeners to prevent one failing listener from breaking the entire event chain.

## Advanced Topics

### Priority-based Listeners

The `EventDispatcher` supports priority-based listener execution:

```php
$dispatcher->addListener('event.name', $listener, 10); // Higher priority
$dispatcher->addListener('event.name', $anotherListener, 0); // Lower priority
```

### Stopping Event Propagation

Listeners can stop event propagation by returning `false`:

```php
$dispatcher->addListener('event.name', function(Event $event) {
    // Some condition
    if ($someCondition) {
        return false; // Stops further listeners from being called
    }
});
```

### Custom Event Classes

For complex events, create custom event classes:

```php
class UserRegisteredEvent extends Event
{
    public function __construct(User $user)
    {
        parent::__construct('user.registered', ['user' => $user]);
    }

    public function getUser(): User
    {
        return $this->getData()['user'];
    }
}
```

This event and listener system provides a solid foundation for implementing event-driven architecture in your PHP applications. It's designed to be flexible and can be easily extended or integrated into existing projects.