<?php
namespace App\Models;
use CodeIgniter\Model;

class OpeningModel extends Model
{
    protected $table = 'openingclosing';
    protected $allowedFields = ['id','opendate', 'closedate','status','school_year'];

    public function openaddmision()
    {
        return $this->db->table($this->table)
            ->select('*,openingclosing.id AS open_id')
            ->join('classes', 'classes.class_id = openingclosing.id')
            ->get()
            ->getRow(); // returns a single object instead of an array
    }
    public function isAdmissionOpen()
    {
        $row = $this->orderBy('id', 'DESC')
                ->select('id, opendate, closedate, status')
                ->first();

        if (!$row) return false;

        $today = date('Y-m-d');

        
        if ($today > $row['closedate'] && $row['status'] !== 'closed') {
            $this->update($row['id'], ['status' => 'closed']);
        }

        
      return ($today >= $row['opendate'] && $today <= $row['closedate']) and$row['status']=='open' ;

    }
    public function getStatus()
    {
        
        $row = $this->select('status')
                    ->orderBy('id', 'DESC')
                    ->first();

        return $row ? $row['status'] : null; 
    }
    public function openclosedate()
    {
        return $this->select('id, school_year')
                    ->orderBy('id', 'DESC')
                    ->findAll();   // ✅ returns array of arrays
    }



    

   



}
