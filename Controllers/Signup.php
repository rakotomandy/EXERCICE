<?php

class Signup
{

    private $signupController;
    public function __construct()
    {
        $this->signupController = new Users();
    }
    public function index()
    {
        Load::template('header', [
            'title' => 'Signup',
            "css" => ['logo', 'bootstrap.min']
        ]);
        Load::view('Templates/navbar');
        Load::view('Signup');
        Load::template('footer', [
            "js" => ['jquery.min','logo', 'bootstrap.bundle.min', 'login'],
        ]);
    }

    // signup logic
    public function signup(){
        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])){
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $password_confirm = htmlspecialchars($_POST['password_confirm']);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $result = $this->signupController->signup($username, $email, $password, $password_confirm);
          if($result['success']){
            echo json_encode(['success' => true, 'message' => $result['message']]);
          } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);    
          }

        }
    }
}