<?php

namespace Yavin\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class InitControllerSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'kernel.controller' => 'onKernelController',
        );
    }

    /**
     * call controller init method if controller implements InitControllerInterface
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }

        $controllerObject = $controller[0];
        if ($controllerObject instanceof InitControllerInterface) {
            $controllerObject->init();
        }
    }
}

