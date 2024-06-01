<?php
namespace Model;

use JsonSerializable;

class Friend implements \JsonSerializable {
    private $username;
    private $status;

    //Konstruktor der optional name übergeben bekommt und in username speichert
    function __construct($username = null, $status = null) {
        $this->username = $username;
        $this->status = $status;
    }


    //getter
    public function getUsername() {
        return $this->username;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function jsonSerialize(): mixed {
        return [
            'username' => $this->username,
            'status' => $this->status
        ];
    }

    public static function fromJson($data) {
        return new Friend($data->username, $data->status);
    }
}
?>