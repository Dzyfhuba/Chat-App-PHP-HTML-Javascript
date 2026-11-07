<?php

namespace Lib;

function responseJson(
    array $data = [], 
    int $status = 200, 
    string $message = ''): void
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}