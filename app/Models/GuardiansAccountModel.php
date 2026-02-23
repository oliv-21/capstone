<?php

namespace App\Models;

use CodeIgniter\Model;

class GuardiansAccountModel extends Model
{
    protected $table            = 'guardiansAccount';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'relationship',
        'contact_number',
        'email',
        'municipality',
        'barangay',
        'street',
        'profile_pic'
    ];


    //============================= New Methods Added =============================//
    public function AllParentsOpening($openingId)
    {
        return $this->db->table('guardiansAccount g')
            ->select("g.*, CONCAT(
        UPPER(LEFT(g.first_name,1)), LOWER(SUBSTRING(g.first_name,2))
    ) AS first_name,
    CONCAT(
        UPPER(LEFT(g.last_name,1)), LOWER(SUBSTRING(g.last_name,2))
    ) AS last_name, CONCAT(g.municipality, ', ', g.barangay, ', ', g.street) AS address")
            ->join('admissions a', 'a.user_id = g.user_id', 'inner')
            ->where('a.status', 'Enrolled')
            ->where('a.openingclosing_id', $openingId)
            ->groupBy('g.user_id') 
            ->get()
            ->getResultArray();
    }
    //===============================================================================//

   

    // Optional: Get guardian info by user_id
    public function getByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    
    public function emailExists($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
    public function getGuardiandata($userId)
    {
        return $this->select("guardiansAccount.*, users.*, CONCAT(guardiansAccount.first_name, ' ', guardiansAccount.last_name) AS full_name")
                    ->join('users', 'users.id = guardiansAccount.user_id')
                    ->where('guardiansAccount.user_id', $userId)
                    ->asObject()
                    ->first();
    }

    public function getEmail($userId)
    {
        return $this->select('email')
                    ->where('user_id', $userId)
                    ->get()
                    ->getRow('email');
    }

    public function AllParents()
    {
        return $this->db->table('guardiansAccount g')
            ->select("g.*, CONCAT(g.municipality, ', ', g.barangay, ', ', g.street) AS address")
            ->join('admissions a', 'a.user_id = g.user_id', 'inner')
            ->where('a.status', 'Enrolled')
            ->groupBy('g.user_id') // ✅ ensures unique guardians only
            ->get()
            ->getResultArray(); // ✅ return as array for view compatibility
    }



    public function GuardianInfo($userId)
    {
        $builder = $this->db->table('guardiansAccount as s');

        $builder->select("
            s.*,
            s.user_id as id, 
            CONCAT(
                UPPER(LEFT(s.last_name, 1)), LOWER(SUBSTRING(s.last_name, 2)), ' ',
                UPPER(LEFT(s.first_name, 1)), LOWER(SUBSTRING(s.first_name, 2))
            ) AS full_name
        ");

        $builder->where('s.user_id', $userId);

        return $builder->get()->getRowArray(); // ✅ return array instead of object
    }
    public function getGuardianDataByAdmission($admissionId)
    {
        return $this->db->table('guardiansAccount g')
            ->select("g.*,CONCAT(
            UPPER(SUBSTRING(g.first_name, 1, 1)), LOWER(SUBSTRING(g.first_name, 2)), ' ',
            UPPER(SUBSTRING(g.last_name, 1, 1)), LOWER(SUBSTRING(g.last_name, 2))
        ) AS parentfull_name, a.*, g.profile_pic AS parentProfilepic")
            ->join('admissions a', 'a.user_id = g.user_id', 'left')
            ->where('a.admission_id', $admissionId)
            ->where('a.status', 'Enrolled')
            ->get()
            ->getRow(); // returns a single row as object
    }
   public function Profiletoeditselect($userId)
    {
        return $this->db->table('guardiansAccount g')
            ->select("g.*, CONCAT(g.last_name, ' ', g.first_name) AS full_name")
            ->where('g.user_id', $userId)
            ->get()
            ->getRow(); // returns a single row as object
    }






    




}
