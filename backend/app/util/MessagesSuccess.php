<?php

class MessagesSuccess {

    public function requestSuccess ($string) {
        header('Content-Type: application/json');
        $sendError = [
            'statusCode' => 201,
            'message' => 'User ' . $string . ' successfully!',
        ];
        echo json_encode($sendError);
    }
}