<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherPhotosUploadModel extends Model
{
    protected $table = 'teacher_photos_upload';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'teacher_id',
        'user_id',
        'photo',
        'comment',
        'created_at'
    ];

    protected $useTimestamps = false; // dahil manual ang created_at mo

    public function highlightPhotoPerchild($userId)
    {
        return $this->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->findAll();
    }

}
