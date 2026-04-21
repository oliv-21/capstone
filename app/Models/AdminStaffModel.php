<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminStaffModel extends Model
{
    protected $table = 'adminandstaff';
    protected $primaryKey = "id"; 
    protected $allowedFields = ['firstname', 'middlename', 'lastname','role','user_id','profilepic','status'];


     public function profilepic()
    {
        $userid = session()->get('user_id');

        if (!$userid) {
            log_message('debug', 'No user ID in session.');
            return null;
        }

        $user = $this->where('user_id', $userid)->first();

        if (!$user) {
            log_message('debug', 'User not found for user_id: ' . $userid);
            return null;
        }

        return $user['profilepic'] ?? null;
    }
    
    public function profilepicAll()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT user_id, profilepic AS profile_pic, 'adminandstaff' AS source
            FROM adminandstaff
            UNION ALL
            SELECT user_id, profile_pic AS profile_pic, 'students' AS source
            FROM students
            UNION ALL
            SELECT user_id, profile_pic AS profile_pic, 'teachers' AS source
            FROM teachers
        ");

        return $query->getResultArray();
    }
    public function profileandfullname()
    {
        return $this->asArray()
                    ->select("
                        user_id AS id,
                        profilepic AS profile_pic,
                        CONCAT(
                           
                            UPPER(LEFT(firstname, 1)), LOWER(SUBSTRING(firstname, 2))
                        ) AS full_name
                    ")
                    ->first();
    }
     public function profileandfullnamestaff($userid)
    {
        return $this->asArray()
                    ->select("
                        user_id AS id,
                        profilepic AS profile_pic,
                        CONCAT(

                            UPPER(LEFT(firstname, 1)), LOWER(SUBSTRING(firstname, 2))
                        ) AS full_name
                    ")
                    ->where('user_id', $userid)
                    ->first();
    }
    public function getAdminAccounts()
    {
         return $this->asArray()
                ->select("
                   *,
                    CONCAT(firstname, ' ', middlename, ' ', lastname) AS full_name
                ")
                ->where('role', 'semi-admin')   // only semi-admin
                ->findAll();
        
    }

    


    
    
    

}


 