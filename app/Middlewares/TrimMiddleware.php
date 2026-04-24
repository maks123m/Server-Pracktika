<?php
namespace Middlewares;
use Src\Request;

class TrimMiddleware {
    public function handle(Request $request) {
        if ($request->method === 'POST') {
            foreach ($_POST as $key => $value) {
                if (is_string($value)) $_POST[$key] = trim($value);
            }
        }
    }
}