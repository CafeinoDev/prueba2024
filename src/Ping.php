<?php

namespace LG;

use LG\App\Shared\BaseController;

class Ping extends BaseController {
    public function ping()
    {
        $response = [
            'message' => 'I\'m a teapot!'
        ];

        $this->jsonResponse($response);
    }
}
