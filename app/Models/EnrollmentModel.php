<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Allowed fields for insert/update
    protected $allowedFields    = [
        'student_id',
        'openingclosing_id', 
        'date_enrolled',
        'status',
    ];
    public function getEnrolledDate($userId)
    {
        return $this->db->table($this->table)
            ->select('date_enrolled')
            ->where('student_id', $userId)
            ->get()
            ->getRow(); // returns a single row object
    }





   
    /**
     * Get all enrolments for a given student and optionally filter by school year.
     */
    
}
