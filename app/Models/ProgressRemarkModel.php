<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressRemarkModel extends Model
{
    protected $table            = 'progress_remarks';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'quarter',
        'school_year',
        'remarks',
        'created_at'
    ];
    protected $useTimestamps    = false;
    
    public function saveOrUpdateRemark($data)
    {
        $existing = $this->where([
            'user_id' => $data['user_id'],
           
            'quarter' => $data['quarter']
        ])->first();

        if ($existing) {
           
            return $this->update($existing[$this->primaryKey], $data);
        } else {
           
            return $this->insert($data);
        }
    }
    public function getAllremarks($userId)
    {
        $remarks = $this->where('user_id', $userId)
                        ->orderBy('quarter')
                        ->findAll();

        // Log for debugging
        log_message('info', 'getAllremarks called for user_id=' . $userId . '. Found ' . count($remarks) . ' remarks.');

        return $remarks;
    }


}
