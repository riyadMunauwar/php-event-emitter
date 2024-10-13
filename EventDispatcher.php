<?php

namespace Event;

class EventDispatcher
{
    protected $listeners = [];

    public function addListener(string $eventName, callable $listener, int $priority = 0): void
    {
        $this->listeners[$eventName][$priority][] = $listener;
        ksort($this->listeners[$eventName]);
    }

    public function removeListener(string $eventName, callable $listener): void
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            $key = array_search($listener, $listeners, true);
            if ($key !== false) {
                unset($this->listeners[$eventName][$priority][$key]);
            }
        }
    }

    public function hasListeners(string $eventName): bool
    {
        return !empty($this->listeners[$eventName]);
    }

    public function dispatch(Event $event): Event
    {
        $eventName = $event->getName();

        if (!$this->hasListeners($eventName)) {
            return $event;
        }

        foreach ($this->listeners[$eventName] as $listeners) {
            foreach ($listeners as $listener) {
                $result = $listener($event);
                if ($result === false) {
                    break 2;
                }
            }
        }

        return $event;
    }

    public function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}