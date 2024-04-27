<?php

declare(strict_types=1);

namespace LG\Infrastructure\Event;

use LG\Domain\Shared\Event\DomainEvent;
use LG\Domain\Shared\Event\EventDispatcher;

/**
 * Implementación de un event dispatcher
 */
class SimpleEventDispatcher implements EventDispatcher
{
    private static ?EventDispatcher $instance    = null;
    private array                   $subscribers = [];

    /**
     * Ponemos el __construct clase en private para utilizar el patrón singleton
     */
    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Añade un suscriptor al dispatcher.
     *
     * @param object $subscriber
     * @return void
     */
    public function addSubscriber(object $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    /**
     * Despacha un evento a los suscriptores
     *
     * @param DomainEvent $event
     * @return void
     */
    public function dispatch(DomainEvent $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            $method = $this->getHandlerMethod($subscriber, $event);
            if (method_exists($subscriber, $method)) {
                $subscriber->$method($event);
            }
        }
    }

    /**
     * Obtiene el nombre del método de evento de un suscriptor
     *
     * @param object $subscriber
     * @param DomainEvent $event
     * @return string
     */
    private function getHandlerMethod(object $subscriber, DomainEvent $event): string
    {
        return 'handle' . (new \ReflectionClass($event))->getShortName();
    }
}