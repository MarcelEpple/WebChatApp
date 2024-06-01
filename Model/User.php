<?php
namespace Model;
use JsonSerializable;

class User implements \JsonSerializable {
    private $username;
    private $firstName;
    private $lastName;
    private $favoriteDrink;
    private $aboutMe;
    private $chatLayout;

    //Konstruktor der optional name übergeben bekommt und in username speichert
    function __construct($name = null) {
        $this->username = $name;
    }

    // Getter und Setter für $firstName
    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    // Getter und Setter für $lastName
    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    // Getter und Setter für $favoriteDrink
    public function getFavoriteDrink() {
        return $this->favoriteDrink;
    }

    public function setFavoriteDrink($favoriteDrink) {
        $this->favoriteDrink = $favoriteDrink;
    }

    // Getter und Setter für $aboutMe
    public function getAboutMe() {
        return $this->aboutMe;
    }

    public function setAboutMe($aboutMe) {
        $this->aboutMe = $aboutMe;
    }

    // Getter und Setter für $chatLayout
    public function getChatLayout() {
        return $this->chatLayout;
    }

    public function setChatLayout($chatLayout) {
        $this->chatLayout = $chatLayout;
    }

    //getter für $username
    public function getUsername() {
        return $this->username;
    }

    public function jsonSerialize():mixed {
        return [
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'favoriteDrink' => $this->favoriteDrink,
            'aboutMe' => $this->aboutMe,
            'chatLayout' => $this->chatLayout,
        ];
    }

    public static function fromJson($data) {
        $user = new User();
        $user->username = $data->username ?? null;
        $user->firstName = $data->firstName ?? null;
        $user->lastName = $data->lastName ?? null;
        $user->favoriteDrink = $data->favoriteDrink ?? null;
        $user->aboutMe = $data->aboutMe ?? null;
        $user->chatLayout = $data->chatLayout ?? null;
        return $user;
    }
}
?>
