<?php

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Query();
    }

//    signup logic
    public function signup($username, $email, $password, $password_confirm)
    {
        // Check if the email already exists
        $existingUser = $this->db->select('users', ['id'])
            ->where('email', '=', $email)
            ->get();

        if (!empty($existingUser)) {
            return ['success' => false, 'message' => 'Email already exists.'];
        }

        // Check if passwords match
        if ($password !== $password_confirm) {
            return ['success' => false, 'message' => 'Passwords do not match.'];
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $this->db->insert('users', [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ])->get();

        return ['success' => true, 'message' => 'User registered successfully.'];
    }

    // login logic
    public function login($email, $password)
    {
        // Fetch the user by email
        $user = $this->db->select('users', ['id', 'username', 'email', 'password'])
            ->where('email', '=', $email)
            ->get();

        if (empty($user)) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // Verify the password
        if (!password_verify($password, $user[0]['password'])) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // Start a session and store user information
        $_SESSION['user_id'] = $user[0]['id'];
        $_SESSION['username'] = $user[0]['username'];
        $_SESSION['email'] = $user[0]['email'];

        return ['success' => true, 'message' => 'Login successful.'];
    }
}