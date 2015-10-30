<?php

namespace Yavin\Symfony\Controller;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InitControllerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Response
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
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

        if (empty($controller) || !is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }

        $controllerObject = $controller[0];
        if ($controllerObject instanceof InitControllerInterface) {
            $this->response = $controllerObject->init($event->getRequest());
            if ($this->response instanceof Response) {
                $event->setController([$this, 'responseAction']);
            }
        }
    }

    /**
     * This method act as a controller action that returns response from init method
     *
     * @return Response
     */
    public function responseAction()
    {
        return $this->response;
    }
}
