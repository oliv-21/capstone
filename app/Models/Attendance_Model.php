<?php
namespace App\Models;
use CodeIgniter\Model;

class Attendance_Model extends Model
{
    protected $table = "attendance";
    protected $primaryKey = "id "; 
    protected $allowedFields = [
        'user_id', 'date', 'arrival_time', 'accompanied_by','leave_time',
        'status', 'picked_up_by'
    ];	
    protected $useTimestamps = false;
	
    protected $returnType = "object";
    

     public function attendancetoday()
    {
        $builder = $this->db->table($this->table);
        $builder->select("*");
        $builder->where('date', date('Y-m-d')); // Today’s date
        return $builder->get()->getResult();

    }

}
