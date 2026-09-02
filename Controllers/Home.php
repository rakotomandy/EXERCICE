<?php

class Home
{
    // session applies here to check if the user is logged in or not
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL . '/Login');
            exit();
        }
    }
    public function index()
    {
        \Load::template('header', [
            "title" => "Home",
            "css" => ['bootstrap.min', 'logo']
        ]);
        \Load::view('home');
        \Load::template('footer', [
            "js" => ['jquery.min','logo', 'bootstrap.bundle.min']
        ]);
    }
}