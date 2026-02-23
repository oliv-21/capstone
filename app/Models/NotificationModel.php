<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'created_at',
        'updated_at'
    ];

    // Auto set created_at & updated_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all notifications for a user.
     */
    public function getUserNotifications($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($notificationId)
    {
        return $this->update($notificationId, ['is_read' => 1]);
    }

    /**
     * Mark all notifications for a user as read.
     */
    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->set(['is_read' => 1])
                    ->update();
    }

    public function adminNotif($userId)
    {
        return $this->where('user_id', $userId)
                    ->whereIn('type', ['admission', 'announcement'])
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function adminNotifCountAll($userId)
    {
        return $this->db->table('notifications')
            ->where('user_id', $userId)
            ->whereIn('type', ['admission', 'announcement'])
            ->where('is_read', 0)
            ->countAllResults();
    }



    public function adminNotifCount()
    {
        return $this->where('type', 'admission')
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    public function markAllAsReadAdmission()
    {
        return $this->where('is_read', 0)
                    ->where('type', 'admission')
                    ->set(['is_read' => 1])
                    ->update();
    }
    public function countAnnoucment($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('type', 'announcement')
                    ->where('is_read', 0)
                    ->countAllResults();
    }
    public function userNotif($userId)
    {
        return $this->where('user_id', $userId)
                    ->whereIn('type', ['payment', 'announcement', 'Admission','Update'])
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    public function markAllAsReadAnnoucment($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->where('type', 'announcement')
                    ->set(['is_read' => 1])
                    ->update();
    }
    public function StudentNotification($userId)
    {
        return $this->where('user_id', $userId)
                    ->whereIn('type', ['Highlight','material','Progress Report'])
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    public function countAnnoucmentStudent($userId)
    {
        return $this->where('user_id', $userId)
                     ->whereIn('type', ['Highlight','material','Progress Report'])
                    ->where('is_read', 0)
                    ->countAllResults();
    }




    

}
