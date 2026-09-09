<?php

class Login
{
    private $loginController;
    public function __construct()
    {
        $this->loginController = new Users();
    }
    public function index()
    {
        Load::template('header', [
            'title' => 'Login',
            "css" => ['logo', 'bootstrap.min']
        ]);
        \Load::view('login', ['message' => 'Please login to your account.']);
        \Load::template('footer', [
            "js" => ['jquery.min', 'logo', 'bootstrap.bundle.min', 'login'],
        ]);
    }

    // login logic
    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {

            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $result = $this->loginController->login($email, $password);
            if ($result['success']) {
                echo json_encode(['success' => true, 'message' => $result['message']]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['message']]);
            }
        }
    }

    // logout logic, implement prevent back history after logout
    public function logout()
    {
    
        session_destroy();

        // Prevent browser caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

        // Redirect to login page
        echo json_encode(['success' => true]);
        exit();;
    }
}
