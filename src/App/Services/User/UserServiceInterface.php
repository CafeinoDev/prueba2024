<?php

namespace LG\App\Services\User;

use LG\Domain\User\UserId;

interface UserServiceInterface
{
    public function create(): void;

    public function read(): void;

    public function update(): void;

    public function delete(): void;
}
