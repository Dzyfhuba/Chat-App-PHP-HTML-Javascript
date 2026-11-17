<?php

declare(strict_types=1);

namespace Controllers;

use Lib\DB;

use function Lib\responseJson;

class ChatController
{
    public static function uploadImage(): void
    {
        // receive the image file from the request
        if (!isset($_FILES['image'])) {
            responseJson(data: [], message: 'No image file provided', statusCode: 400);
            return;
        }

        $image = $_FILES['image'];

        // save to storage folder
        $storagePath = dirname(__DIR__) . '/storage/';
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        move_uploaded_file($image['tmp_name'], $storagePath . $image['name']);
 
        $image = $image['name'];

        // save to database
        $db = DB::getInstance();
        $statement = $db->prepare(
            'INSERT INTO chats (image, reference) VALUES (:image, :reference)'
        );
        $statement->execute(['image' => $image, 'reference' => time()+rand(1, 1000)]);
        $db->lastInsertId();

        $image = '/storage/' . $image;

        responseJson(data: ['image' => $image], message: 'Image received successfully', statusCode: 200);
    }
}