# Symfony Init Controller extension
Add ability to execute `init` method in controller before every action.
Based on [this answer](http://stackoverflow.com/a/11179521/1051297)

## Instalation
1. Add library to composer.json
   ```json
   "yavin/symfony-init-controller": "dev-master"
   ```
   and run command
   ```
   composer update yavin/symfony-init-controller
   ```

2. Add service in your bundle services file `Resources/config/services.xml`:
   ```xml
   <service id="symfony.controller.subscriber.init" class="Yavin\Symfony\Controller\InitControllerSubscriber">
       <tag name="kernel.event_subscriber"/>
   </service>
   ```

   or if you have `services.yml`:
   ```yml
   services:
       symfony.controller.subscriber.init:
           class: Yavin\Symfony\Controller\InitControllerSubscriber
           tags:
               - { name: kernel.event_subscriber }
   ```

3. Then implement `InitControllerInterface` in controller that you want to have init method.
   ```php
   namespace Acme\DemoBundle\Controller;

   use Symfony\Bundle\FrameworkBundle\Controller\Controller;
   use Symfony\Component\HttpFoundation\Request;
   use Yavin\Symfony\Controller\InitControllerInterface;

   class SampleController extends Controller implements InitControllerInterface
   {
       protected $page;

       public function init(Request $request)
       {
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

### TODO
* write tests

