<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password_hash', 'email', 'role','reset_token', 'token_expiry','status'];
    protected $validationRules = [
       
    ];
    protected $useTimestamps = true;

    // Method to get user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Method to get user by ID
    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function email()
    {
        $userid = session()->get('user_id'); 
        if (!$userid) {
            log_message('debug', 'No user ID in session.');
            return null;
        }

        $user = $this->find($userid);

        if (!$user) {
            log_message('debug', 'User not found for ID: ' . $userid);
            return null;
        }

        return $user['email'] ?? null;
    }

    
    
    public function getUsernamesByEmail($email)
    {
        log_message('debug', 'User not found for email: ' . $email);
        return $this->select('username')
                    ->where('email', $email)
                     ->findAll();
    }

    public function getEmailByUsername($Username)
    {
        log_message('debug', 'User  found for username: ' . $Username);
        return $this->select('email')
                    ->where('username', $Username)                
                    ->first();
    }

    public function saveResetToken($username, $token, $expiry)
    {
        return $this->where('username', $username)
                    ->set(['reset_token' => $token, 'token_expiry' => $expiry])
                    ->update();
    }

    public function getResetTokenData($token)
    {
        return $this->where('reset_token', $token)
                    ->where('token_expiry >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function getUsernameData($token)
    {
        log_message('debug', 'Get pass using token: ' . $token);
        return $this->select('username')
                    ->where('reset_token', $token)                
                    ->first();
    }
    public function getStatus($userID)
    {
        return $this->select('status')
                    ->where('id', $userID)
                    ->first(); 
    }


    






    

    




    
    


    
}
