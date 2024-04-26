<?php

namespace LG\App\Services\User;

use LG\Domain\User\UserId;

interface UserServiceInterface
{
    public function create(): void;

    public function view(): void;
}
