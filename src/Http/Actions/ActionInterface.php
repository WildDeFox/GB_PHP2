<?php

namespace Main\Component\Http\Actions;

use Main\Component\Http\Request;
use Main\Component\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}