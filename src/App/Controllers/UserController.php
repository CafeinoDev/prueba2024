<?php

declare(strict_types=1);

namespace LG\App\Controllers;

use LG\App\Shared\BaseController;

class UserController extends BaseController {
    public function all(): void
    {
        $this->jsonResponse([
            'message' => 'Todos los usuarios'
        ]);
    }

    public function create(): void
    {
        $datetime = new \DateTimeImmutable();
        $string = $datetime->format(\DateTimeInterface::ATOM);
        $this->jsonResponse([
            'message' => 'Crear usuario',
            'data'    => $this->request(),
            'datetime' => $string
        ]);
    }
}