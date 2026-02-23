<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'message', 'status', 'created_at', 'user_id','opening_id'];
    protected $returnType = 'object'; // ✅ Add this line

    public function saveAnnouncement($title, $message, $user_id)
    {
        $data = [
            'title'      => $title,
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'user_id'    => $user_id,
        ];

        return $this->insert($data);
    }

    public function activeAnnouncement($userId)
    {
        return $this->where([
            'status' => 'Active',
            'user_id' => $userId
        ])->findAll();
    }
    public function activeAnnouncementstudent()
    {
        return $this->where([
            'status' => 'Active',
            
        ])->findAll();
    }
    public function AnnouncementGuardian($userId)
    {
        $sql = "
               SELECT 
                a.id AS announcement_id,
                a.title,
                a.message,
                a.status,
                a.created_at,
                COALESCE(t.first_name, ad.firstname) AS posted_by,
                am.class_applied
            FROM announcement a
            LEFT JOIN teachers t ON t.user_id = a.user_id
            LEFT JOIN adminandstaff ad ON ad.id = a.user_id
            LEFT JOIN admissions am ON am.user_id = ?
            WHERE (t.teacher_department = am.class_applied
                OR a.user_id = ad.id)
            GROUP BY a.id
            ORDER BY a.created_at DESC;
                    ";

        return $this->db->query($sql, [$userId])->getResult();
    }

    //================= Additional Methods =================//
    public function saveAnnouncementOpening($title, $message, $user_id, $opening_id)
    {
        $data = [
            'title'      => $title,
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'user_id'    => $user_id,
            'opening_id' => $opening_id
        ];

        return $this->insert($data);
    }
     public function activeAnnouncementOpening($userId, $openingId)
    {
        return $this->where([
            'status' => 'Active',
            'user_id' => $userId,
            'opening_id' => $openingId
        ])->findAll();
    }

    
    public function AnnouncementGuardianOpening($userId,$opening_id)
    {
        $sql = "
               SELECT 
                a.id AS announcement_id,
                a.title,
                a.message,
                a.status,
                a.created_at,
                COALESCE(t.first_name, ad.firstname) AS posted_by,
                am.class_applied
            FROM announcement a
            LEFT JOIN teachers t ON t.user_id = a.user_id
            LEFT JOIN adminandstaff ad ON ad.id = a.user_id
            LEFT JOIN admissions am ON am.user_id = ?
            WHERE (t.teacher_department = am.class_applied
                OR a.user_id = ad.id and a.opening_id  = ?)
            GROUP BY a.id
            ORDER BY a.created_at DESC;
                    ";

        return $this->db->query($sql, [$userId, $opening_id])->getResult();
    }
    
    
}
