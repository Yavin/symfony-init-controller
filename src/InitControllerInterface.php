<?php

namespace Yavin\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;

interface InitControllerInterface
{
    /**
     * @param Request $request
     * @return null|mixed
     */
    public function init(Request $request);
}
