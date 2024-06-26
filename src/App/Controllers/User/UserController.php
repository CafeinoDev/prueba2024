<?php

declare(strict_types=1);

namespace LG\App\Controllers\User;

use LG\App\Services\User\UserService;
use LG\App\Shared\BaseController;
use LG\App\Shared\Validator;
use LG\Domain\User\UserId;
use LG\Infrastructure\Persistence\User\UserMapper;
use LG\Infrastructure\Persistence\User\UserRepository;

final class UserController extends BaseController implements UserControllerInterface
{
    protected readonly UserRepository $userRepository;
    protected readonly UserService    $userService;
    protected readonly ?array         $data;
    protected readonly Validator      $validator;
    public ?array                     $params;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userService    = new UserService();
        $this->data           = $this->request();
        $this->validator      = new Validator();
    }

    /**
     * Listamos a todos los usuarios
     *
     * @return void
     */
    public function all(): void
    {
        try {
            $res = $this->userService->searchAll($this->userRepository);

            $this->jsonResponse([
                'message' => 'Users fetched successfully',
                'data' => $res
            ], 200);
        } catch (\Exception $exception) {
            $this->jsonResponse([
                'message' => 'Error fetching users: ' . $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * Validamos y creamos el usuario
     *
     * @return void
     */
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
                    'balance'   => ['required', 'isNumeric']
                ]
            );

            /**
             * Creamos y persistimos el usuario en la base de datos.
             * Se valida que no exista un usuario con el mismo correo o documento
             */
            $this->userService->create(
                UserMapper::mapUser($this->data),
                $this->userRepository,
                $this->data['balance'],
                $this->data['password'],
            );

            $this->jsonResponse([
                'message' => 'User register successfully'
            ], 201);
        } catch (\Exception $exception) {
            $this->jsonResponse([
                'message' => 'Error creating the user: ' . $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * Devolvemos la información de un usuario
     *
     * @return void
     */
    public function view(): void
    {
        try {
            $this->validator->validate(
                $this->params,
                [
                    'id' => ['required', 'isNumeric']
                ]);

            $user = $this->userService->view(
                new UserId((int)$this->params['id']),
                $this->userRepository
            );

            $this->jsonResponse([
                'data' => $user
            ], 200);
        } catch (\Exception $exception) {
            $this->jsonResponse([
                'message' => 'Error consulting the user: ' . $exception->getMessage()
            ], $exception->getCode());
        }
    }
}