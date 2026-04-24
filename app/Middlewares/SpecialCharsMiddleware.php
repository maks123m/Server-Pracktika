<?php

namespace Middlewares;

use Src\Request;

class SpecialCharsMiddleware {
    public function handle(Request $request) {
        if ($request->method === 'POST') {
            foreach ($_POST as $key => $value) {
                if (is_string($value)) $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
            }
        }
    }
}