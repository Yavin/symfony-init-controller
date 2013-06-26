# Symfony Init Controller extension
Add ability to call `init` method in controller before every action. This is similar functionality that are in Zend Frameowrk.


You must implement `Yavin\Symfony\Controller\InitControllerInterface` in controller that you wont to have init method.
```php
namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yavin\Symfony\Controller\InitControllerInterface;

class SampleController extends Controller implements InitControllerInterface
{
    protected $page;

    public function init()
    {
        $request = $this->getRequest();
        $this->page = $request->get('page');
    }
    
    public function indexAction()
    {
        //...
    }
    
    public function otherAction()
    {
        //...
    }
}
```

To add this functionality you must add service in symfony config:
```
services:
    yavin.symfony.controller.init.subscriber:
        class: "Yavin\\Symfony\\Controller\\InitControllerSubscriber"
        tags:
            - { name: kernel.event_subscriber }
```

## TODO
* write tests

