<?php

namespace LG\App\Controllers\User;

interface UserControllerInterface
{
    public function all(): void;

    public function create(): void;

    public function view(): void;
}
