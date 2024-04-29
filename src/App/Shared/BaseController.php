<?php

namespace LG\App\Shared;

abstract class BaseController {
    public ?array                     $params;
    protected readonly ?array         $data;

    public function __construct()
    {
        $this->data = $this->request();
    }

    protected function jsonResponse(array $data, int $status = 200): void
    {

        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data);
    }

    protected function request(): ?array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}