<?php

namespace Yavin\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;

interface InitControllerInterface
{
    public function init(Request $request);
}
