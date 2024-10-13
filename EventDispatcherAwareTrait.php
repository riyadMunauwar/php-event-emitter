<?php

namespace Event;

trait EventDispatcherAwareTrait
{
    protected $eventDispatcher;

    public function setEventDispatcher(EventDispatcher $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEventDispatcher(): EventDispatcher
    {
        if (!$this->eventDispatcher) {
            $this->eventDispatcher = new EventDispatcher();
        }
        return $this->eventDispatcher;
    }

    protected function dispatch(Event $event): Event
    {
        return $this->getEventDispatcher()->dispatch($event);
    }
}