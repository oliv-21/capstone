<?php
namespace App\Models;
use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'message_id';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'sent_at','is_read'];
    protected $useTimestamps = false;

    public function getMessages($userId, $contactId)
    {
        return $this->where("(sender_id = $userId AND receiver_id = $contactId) 
                             OR (sender_id = $contactId AND receiver_id = $userId)")
                    ->orderBy('sent_at', 'ASC')
                    ->findAll();
    }

    ////pag isa lang or yung may convo lang 
    // public function getContacts($userId)
    // {
    //     $subQuery = $this->db->table('message m2')
    //         ->select('MAX(m2.sent_at)')
    //         ->where('m2.sender_id = u.id AND m2.receiver_id = ' . $userId, null, false)
    //         ->orWhere('m2.receiver_id = u.id AND m2.sender_id = ' . $userId, null, false)
    //         ->getCompiledSelect();

    //     return $this->db->table('message m')
    //         ->select('u.id, u.username, u.profile_pic, m.message AS last_message, m.sent_at')
    //         ->join('users u', '(u.id = m.sender_id AND m.receiver_id = ' . $userId . ') OR (u.id = m.receiver_id AND m.sender_id = ' . $userId . ')', 'inner', false)
    //         ->where('u.id !=', $userId)
    //         ->where("m.sent_at = ($subQuery)", null, false)
    //         ->orderBy('m.sent_at', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }
    // public function getContacts($userId)
    // {
    //     $db = \Config\Database::connect();

    //     // Raw SQL subquery for recent messages
    //     $subQuery = "
    //         SELECT 
    //             CASE 
    //                 WHEN sender_id < receiver_id THEN sender_id 
    //                 ELSE receiver_id 
    //             END AS user_a,
    //             CASE 
    //                 WHEN sender_id < receiver_id THEN receiver_id 
    //                 ELSE sender_id 
    //             END AS user_b,
    //             message,
    //             sent_at
    //         FROM message
    //         WHERE sender_id = $userId OR receiver_id = $userId
    //     ";

    //     return $db->table('users u')
    //         ->select("
    //             u.id,
                 
    //             u.username, 
    //             sub.message AS last_message, 
    //             sub.sent_at,
    //             COALESCE(s.profile_pic, a.profilepic) AS profile_pic,
    //              COALESCE(
    //                 NULLIF(CONCAT_WS(' ', s.first_name, s.last_name), ' '),
    //                 NULLIF(CONCAT_WS(' ', a.firstname), ' ')
                   
    //             ) AS full_name
    //         ")
    //         ->join("($subQuery) sub", 
    //             "(sub.user_a = u.id AND sub.user_b = $userId) OR (sub.user_b = u.id AND sub.user_a = $userId)",
    //             'left', false)
    //         ->join('students s', 's.user_id = u.id', 'left')
    //         ->join('adminandstaff a', 'a.user_id = u.id', 'left')
    //         ->where('u.id !=', $userId)
    //         ->groupBy('u.id')
    //         ->orderBy('sub.sent_at', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }
    // 

    // public function getContacts($userId, $role)
    // {
    //     $db = \Config\Database::connect();

    //     // SQL subquery for last message
    //     $subQuery = "
    //         SELECT 
    //             CASE WHEN sender_id < receiver_id THEN sender_id ELSE receiver_id END AS user_a,
    //             CASE WHEN sender_id < receiver_id THEN receiver_id ELSE sender_id END AS user_b,
    //             message,
    //             sent_at,
    //             is_read,
    //             sender_id,
    //             receiver_id
    //         FROM message
    //         WHERE sender_id = $userId OR receiver_id = $userId
    //     ";

    //     $builder = $db->table('users u')
    //         ->select("
    //             u.id, 
    //             u.username, 
    //             sub.message AS last_message, 
    //             sub.sent_at,
    //             COALESCE(s.profile_pic, a.profilepic) AS profile_pic,
    //             COALESCE(
    //                 NULLIF(CONCAT_WS(' ', s.first_name, s.last_name), ' '),
    //                 NULLIF(CONCAT_WS(' ', a.firstname), ' ')
    //             ) AS full_name,
    //             -- Count of unread messages papunta sa current user
    //             SUM(CASE WHEN sub.receiver_id = {$userId} AND sub.is_read = 0 THEN 1 ELSE 0 END) AS unread_count
    //         ")
    //         ->join("($subQuery) sub", 
    //             "(sub.user_a = u.id AND sub.user_b = $userId) OR (sub.user_b = u.id AND sub.user_a = $userId)",
    //             'left', false)
    //         ->join('students s', 's.user_id = u.id', 'left')
    //         ->join('adminandstaff a', 'a.user_id = u.id', 'left')
    //         ->where('u.id !=', $userId)
    //         ->groupBy('u.id')
    //         ->orderBy('sub.sent_at', 'DESC');

    //     // Filter depende sa role
    //     if ($role === 'student') {
    //         $builder->whereIn('u.role', ['attendance_monitor', 'admin']);
    //     }

    //     return $builder->get()->getResultArray();
    // }
    public function getContacts($userId, $role)
    {
        $db = \Config\Database::connect();

        $subQuery = "
            SELECT 
                CASE WHEN sender_id < receiver_id THEN sender_id ELSE receiver_id END AS user_a,
                CASE WHEN sender_id < receiver_id THEN receiver_id ELSE sender_id END AS user_b,
                message,
                sent_at,
                is_read,
                sender_id,
                receiver_id
            FROM message
            WHERE sender_id = $userId OR receiver_id = $userId
        ";

        $builder = $db->table('users u')
            ->select("
                u.id, 
                u.username, 
                sub.message AS last_message, 
                sub.sent_at,
                COALESCE(s.profile_pic, a.profilepic, t.profile_pic) AS profile_pic,
                COALESCE(
                    NULLIF(CONCAT_WS(' ', s.first_name, s.last_name), ' '),
                    NULLIF(CONCAT_WS(' ', a.firstname, a.lastname), ' '),
                    NULLIF(CONCAT_WS(' ', t.first_name, t.last_name), ' ')
                ) AS full_name,
                SUM(CASE WHEN sub.receiver_id = {$userId} AND sub.is_read = 0 THEN 1 ELSE 0 END) AS unread_count
            ")
            ->join("($subQuery) sub", 
                "(sub.user_a = u.id AND sub.user_b = $userId) OR (sub.user_b = u.id AND sub.user_a = $userId)",
                'left', false)
            ->join('guardiansAccount s', 's.user_id = u.id', 'left')
            ->join('adminandstaff a', 'a.user_id = u.id', 'left')
            ->join('teachers t', 't.user_id = u.id', 'left')
            ->where('u.id !=', $userId)
            ->groupBy('u.id')
            ->orderBy('sub.sent_at', 'DESC');

        // Role-based contact visibility
        if ($role === 'parent') {
            $builder->whereIn('u.role', ['teacher', 'admin']);
        } elseif ($role === 'admin') {
            $builder->whereIn('u.role', ['teacher', 'parent']);
        } elseif ($role === 'teacher') {
            $builder->whereIn('u.role', ['parent', 'admin']);
        }

        return $builder->get()->getResultArray();
    }
    public function getContactsParent($userId, $role)
    {
        $db = \Config\Database::connect();

        $subQuery = "
            SELECT 
                CASE WHEN sender_id < receiver_id THEN sender_id ELSE receiver_id END AS user_a,
                CASE WHEN sender_id < receiver_id THEN receiver_id ELSE sender_id END AS user_b,
                message,
                sent_at,
                is_read,
                sender_id,
                receiver_id
            FROM message
            WHERE sender_id = $userId OR receiver_id = $userId
        ";

        $builder = $db->table('users u')
            ->select("
                u.id, 
                u.username, 
                sub.message AS last_message, 
                sub.sent_at,
                COALESCE(s.profile_pic, a.profilepic, t.profile_pic) AS profile_pic,
                COALESCE(
                    NULLIF(CONCAT_WS(' ', s.first_name, s.last_name), ' '),
                    NULLIF(CONCAT_WS(' ', a.firstname, a.lastname), ' '),
                    NULLIF(CONCAT_WS(' ', t.first_name, t.last_name), ' ')
                ) AS full_name,
                SUM(CASE WHEN sub.receiver_id = {$userId} AND sub.is_read = 0 THEN 1 ELSE 0 END) AS unread_count
            ")
            ->join("($subQuery) sub", 
                "(sub.user_a = u.id AND sub.user_b = $userId) OR (sub.user_b = u.id AND sub.user_a = $userId)",
                'left', false)
            ->join('guardiansAccount s', 's.user_id = u.id', 'left')
            ->join('adminandstaff a', 'a.user_id = u.id', 'left')
            ->join('teachers t', 't.user_id = u.id', 'left')
            ->where('u.id !=', $userId)
            ->groupBy('u.id')
            ->orderBy('sub.sent_at', 'DESC');

        // Role-based contact visibility
        if ($role === 'parent') {
            $builder->whereIn('u.role', ['teacher', 'admin']);
        } elseif ($role === 'admin') {
            $builder->whereIn('u.role', ['teacher', 'parent']);
        } elseif ($role === 'teacher') {
            $builder->whereIn('u.role', ['parent', 'admin']);
        }

        return $builder->get()->getResultArray();
    }
    








}
