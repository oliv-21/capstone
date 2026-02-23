<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_log'; 

    protected $allowedFields = [
        'admission_id',
        'done_by',
        'description',
        'action',
        'status'
    ];

    // Enable automatic timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: if you want soft deletes
    // protected $useSoftDeletes = true;
    // protected $deletedField  = 'deleted_at';
    public function getAuditLogs()
    {
        // Basic: get all audit logs ordered by latest first
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    
}
