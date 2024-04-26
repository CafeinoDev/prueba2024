<?php

declare(strict_types=1);

namespace LG\App\Controllers;

use http\Exception\InvalidArgumentException;
use LG\App\Services\User\UserService;
use LG\App\Services\User\UserServiceInterface;
use LG\App\Shared\BaseController;
use LG\App\Shared\Validator;
use LG\Infrastructure\Persistence\User\UserRepository;

final class UserController extends BaseController implements UserServiceInterface
{
    protected readonly UserRepository $userRepository;
    protected readonly UserService    $userService;
    protected readonly array          $data;
    protected readonly Validator      $validator;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userService    = new UserService();
        $this->data           = $this->request();
        $this->validator      = new Validator();
    }

    public function create(): void
    {
        try {
            $this->validator->validate(
                $this->data,
                [
                    'email'     => ['required', 'email'],
                    'password'  => ['required', 'minLength:8'],
                    'document'  => ['required', 'maxLength:8', 'minLength:8'],
                    'full_name' => ['required', 'minLength:4', 'maxLength:100'],
                    'balance'   => ['required']
                ]
            );
            $res = $this->userService->create($this->data, $this->userRepository);
            $this->jsonResponse([
                'message' => 'The user has been created',
                'data' => json_encode($res)
            ], 201);
        } catch (\Exception $exception) {
            $this->jsonResponse([
                'message' => 'Error creating the user: ' . $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function read(): void
    {
        // TODO: Implement read() method.
    }

    public function update(): void
    {
        // TODO: Implement update() method.
    }

    public function delete(): void
    {
        // TODO: Implement delete() method.
    }
}