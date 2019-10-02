<?php


class BaseResponse
{
    public $status;
    public $message;
    public $data;

    public function toJson()
    {
        return json_encode([
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }

}