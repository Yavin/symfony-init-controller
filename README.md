# Symfony Init Controller extension
Add ability to call `init` method in controller before every action.
Based on [this answer](http://stackoverflow.com/a/11179521/1051297)


You must implement `Yavin\Symfony\Controller\InitControllerInterface` in controller that you want to have init method.
Then you can have your init method like this:
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

To add this functionality you must add service in symfony `app/config/config.yml`:
```
services:
    symfony.controller.init.subscriber:
        class: "Yavin\\Symfony\\Controller\\InitControllerSubscriber"
        tags:
            - { name: kernel.event_subscriber }
```

## TODO
* write tests

