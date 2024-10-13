<?php

// Example usage:
class UserRegisteredEvent extends Event
{
    public function __construct(array $userData)
    {
        parent::__construct('user.registered', $userData);
    }
}

class EmailNotifier
{
    public function sendWelcomeEmail(UserRegisteredEvent $event): void
    {
        $userData = $event->getData();
        echo "Sending welcome email to {$userData['email']}\n";
    }
}

class UserController
{
    use EventDispatcherAwareTrait;

    public function register(array $userData): void
    {
        // Perform registration logic...

        $event = new UserRegisteredEvent($userData);
        $this->dispatch($event);
    }
}

// Set up the event system
$dispatcher = new EventDispatcher();
$emailNotifier = new EmailNotifier();

$dispatcher->addListener('user.registered', [$emailNotifier, 'sendWelcomeEmail']);

$userController = new UserController();
$userController->setEventDispatcher($dispatcher);

// Simulate user registration
$userController->register(['name' => 'John Doe', 'email' => 'john@example.com']);