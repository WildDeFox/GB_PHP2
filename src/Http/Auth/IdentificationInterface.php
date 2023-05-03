<?php

namespace Main\Component\Http\Auth;

use Main\Component\Blog\User;
use Main\Component\Http\Request;

interface IdentificationInterface
{
    public function user(Request $request): User;
}