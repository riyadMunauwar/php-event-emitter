<?php

namespace Event;

class ListenerProvider
{
    protected $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function getListenersForEvent(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}