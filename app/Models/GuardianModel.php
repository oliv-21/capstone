<?php
namespace App\Models;
use CodeIgniter\Model;

class GuardianModel extends Model
{
    protected $table = "guardian";
    protected $primaryKey = "guardian_id"; 
    protected $allowedFields = [ 'user_id', 'first_name','middle_name','last_name', 'relationship','photo','qr_code'];	
    protected $useTimestamps = false;
	
    protected $returnType = "object";

    public function saveGuardian(array $data)
    {
        return $this->insert($data);
    }

    public function displayAllguardian()
    {
        $userId = session()->get('child_id');
        if (!$userId) {
            return [];  // or null
        }

        return $this->db->table($this->table)
            ->select("*, CONCAT(
                UPPER(LEFT(first_name, 1)), LOWER(SUBSTRING(first_name, 2)), ' ',
                UPPER(LEFT(middle_name, 1)), LOWER(SUBSTRING(middle_name, 2)), ' ',
                UPPER(LEFT(last_name, 1)), LOWER(SUBSTRING(last_name, 2))
            ) AS full_name")
            ->where('user_id', $userId)
            ->get()
            ->getResult();
    }
    public function displayAllguardianAdmin()
    {
        return $this->db->table($this->table)
           ->select("*, CONCAT(
                UPPER(LEFT(first_name, 1)), LOWER(SUBSTRING(first_name, 2)), ' ',
                UPPER(LEFT(middle_name, 1)), LOWER(SUBSTRING(middle_name, 2)), ' ',
                UPPER(LEFT(last_name, 1)), LOWER(SUBSTRING(last_name, 2))
            ) AS full_name")
            ->where('user_id', $userId)
            ->get()
            ->getResult();
    }
    public function getUserIdByQrCode(string $qrCode)
    {
        log_message('debug', 'Looking up user by QR Code model: ' . $qrCode);
        return $this->where('qr_code', $qrCode)
                    ->select('user_id')
                    ->first();
    }
    public function guardianData(string $qrCode)
    {
       
        return $this->where('qr_code', $qrCode)
                    ->select("*, CONCAT(
                                    UPPER(LEFT(first_name, 1)), LOWER(SUBSTRING(first_name, 2)), ' ',
                                    UPPER(LEFT(middle_name, 1)), LOWER(SUBSTRING(middle_name, 2)), ' ',
                                    UPPER(LEFT(last_name, 1)), LOWER(SUBSTRING(last_name, 2))
                                ) AS full_name")
                    ->first();
    }
    public function findguardian($userId)
    {
        return $this->db->table($this->table)
            ->select("*")
            ->where('user_id', $userId)
            ->get()
            ->getResult();
    }





}

