<?php

namespace spec\Yavin\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use Yavin\Symfony\Controller\InitControllerInterface;

class SampleInitController implements InitControllerInterface
{
    public function init(Request $request)
    {

    }
}
