<?php

class Users
{
    private  $db;

    public function __construct()
    {
        $this->db = new Query();
    }

    //    signup logic
    public function signup(string $username, string $email, string $password, string $password_confirm)
    {
        // Check if the email already exists
        $existingUser = $this->db->getOne('users', ['email' => $email]);

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
        ]);

        return ['success' => true, 'message' => 'User registered successfully.'];
    }

    // login logic
    public function login( string $email, string $password)
    {
        // Fetch the user by email
        $user = $this->db->getOne('users', ['email' => $email]);

        if (empty($user)) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // Verify the password
        if (!password_verify($password, $user->password)) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // Start a session and store user information
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;

        return ['success' => true, 'message' => 'Login successful.'];
    }
}
