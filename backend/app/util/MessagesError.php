<?php

class MessagesError {

    public function pathNotFound($method, $uri) {
        header('Content-Type: application/json');
        $sendError = [
            'message' => 'Cannot ' . strtoupper($method) . ' ' . $uri,
            'error' => 'Not Found',
            'statusCode' => 404
        ];
        echo json_encode($sendError);
    }

    public function requestError () {
        header('Content-Type: application/json');
        $sendError = [
            'message' => 'Internal Error',
            'error' => 'Not Found',
            'statusCode' => 500
        ];
        echo json_encode($sendError);
    }

    public function userNotFound (String $notFound) {
        header('Content-Type: application/json');
        $sendError = [
            'message' => $notFound,
            'error' => 'Not Found',
            'statusCode' => 404
        ];
        echo json_encode($sendError);
    }

    public function requiredFields () {
        header('Content-Type: application/json');
        $sendError = [
            'message' => 'name, email, date_of_birth, contact_cellphone is requeired!',
            'error' => 'Not Accepted ',
            'statusCode' => 422
        ];
        echo json_encode($sendError);
    }
}