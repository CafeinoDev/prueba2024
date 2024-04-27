<?php

namespace LG\App\Controllers\User;

interface UserControllerInterface
{
    public function searchAll(): ?array;

    public function create(): void;

    public function view(): void;
}
