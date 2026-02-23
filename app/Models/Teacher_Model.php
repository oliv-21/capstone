<?php
namespace App\Models;

use CodeIgniter\Model;

class Teacher_Model extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'first_name', 'middle_name', 'last_name','birthday','gender','civil_status','municipality','barangay','street','contact_number','email','specialization','teacher_department','profile_pic','created_at','updated_at'];
    protected $validationRules = [
       
    ];
    protected $useTimestamps = true;
    public function profilepic()
    {
        $userid = session()->get('user_id');

        if (!$userid) {
            log_message('debug', 'No user ID in session.');
            return null;
        }

        $user = $this->where('user_id', $userid)->first();

        if (!$user) {
            log_message('debug', 'User not found for user_id: ' . $userid);
            return null;
        }

        return $user['profile_pic'] ?? null;
    }
    public function teacherData($userId)
    {
        return $this->select("id, user_id, email, contact_number, profile_pic, teacher_department, specialization, 
                            CONCAT(
                                CONCAT(UCASE(LEFT(last_name, 1)), LCASE(SUBSTRING(last_name, 2))),
                                ' ',
                                CONCAT(UCASE(LEFT(first_name, 1)), LCASE(SUBSTRING(first_name, 2)))
                            ) AS lastname")
                    ->where('user_id', $userId)
                    ->first();
    }
    public function getStudentsByTeacher($teacherUserId)
    {
        return $this->db->table('students s')
            ->select("s.*,
                ad.nickname,
                ad.middle_name,
                ad.nationality,
                ad.gender,
                ad.birthday as admission_birthday,
                ad.age,
                ad.father_name,
                ad.father_occupation,
                ad.mother_name,
                ad.mother_occupation,
                ad.contact_number,
                ad.email,
                ad.municipality,
                ad.barangay,
                ad.street,
                CONCAT(
                    s.last_name, ', ',
                    s.first_name,
                    IF(s.middle_name IS NOT NULL AND s.middle_name != '', 
                        CONCAT(' ', LEFT(s.middle_name, 1), '.'),
                        ''
                    )
                ) AS full_name")
            ->join('teachers t', 's.class_level = t.teacher_department')
            ->join('admissions ad', 'ad.admission_id = s.admission_id')
            ->where('t.user_id', $teacherUserId)
            ->get()
            ->getResultArray();
    }
    public function profileandfullname(string $userId)
    {
        // Try to get from students
        $student = $this->db->table('students s')
            ->select("
                s.user_id AS id,
                CONCAT_WS(' ', s.last_name, s.first_name) AS full_name,
                s.profile_pic
            ")
            ->where('s.user_id', $userId)
            ->get()
            ->getRowArray();

        if ($student) {
            return $student;
        }

        // If not found, try to get from adminandstaff
        $admin = $this->db->table('adminandstaff a')
            ->select("
                a.user_id AS id,
                CONCAT_WS(' ', a.firstname) AS full_name,
                a.profilepic AS profile_pic
            ")
            ->where('a.user_id', $userId)
            ->get()
            ->getRowArray();

        return $admin ?: null;
    }
    public function announcementPost()
    {
       
         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
         $model = new AnnouncementModel();
        
        $title = $this->request->getPost('title');
        $message = $this->request->getPost('message');

        $model->saveAnnouncement($title, $message);

        
        $notification = new \App\Models\NotificationModel();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $students = $builder->whereIn('role', ['student', 'teacher'])->get()->getResult();

       

        foreach ($students as $student) {
            $notification->insert([
                'user_id' => $student->id,  
                'title'   => 'Announcement',
                'message' => 'A new Announcement has been posted',
                'type'    => 'announcement',
                'is_read' => 0
            ]);
        }

        $notification->insert([
            'user_id' => $userId, 
            'title'   => 'Announcement',
            'message' => 'A new Announcement posted',
            'type'    => 'announcement', 
            'is_read' => 0
        ]);

        return redirect()->to('/teacher-annoucement')->with('success', 'Announcement posted');
    }
    public function deleteAnnouncement($id)
    {
        $model = new AnnouncementModel();
        $model->update($id, ['status' => 'Deactive']);

        return redirect()->to(base_url('/teacher-annoucement'))->with('success', 'Announcement deactivated successfully.');
    }

    public function updateAnnouncement()
    {
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $message = $this->request->getPost('message');

        $model = new AnnouncementModel();

        $data = [
            'title' => $title,
            'message' => $message
        ];

        $model->update($id, $data);

        return redirect()->to(base_url('/teacher-annoucement'))->with('success', 'Announcement updated successfully.');
    }
    public function profileFullname($userId)
    {
         return $this->select("user_id as id, email, contact_number, profile_pic, teacher_department, specialization, 
                            CONCAT(
                                CONCAT(UCASE(LEFT(last_name, 1)), LCASE(SUBSTRING(last_name, 2))),
                                ' ',
                                CONCAT(UCASE(LEFT(first_name, 1)), LCASE(SUBSTRING(first_name, 2)))
                            ) AS full_name")
                    ->where('user_id', $userId)
                    ->first();
    }
    public function teacherinfo($userId)
    {
    return $this->select("
           *,
            CONCAT(
                CONCAT(UCASE(LEFT(last_name, 1)), LCASE(SUBSTRING(last_name, 2))),
                ' ',
                CONCAT(UCASE(LEFT(first_name, 1)), LCASE(SUBSTRING(first_name, 2)))
            ) AS fullname
        ")
        ->where('user_id', $userId)
        ->asObject() // ✅ Return as object instead of array
        ->first();
    }
    public function isProfileIncomplete($userId)
    {
        $teacher = $this->select('birthday, gender, civil_status, municipality, barangay, street')
                        ->where('user_id', $userId)
                        ->first();

        if (!$teacher) {
            return true; // No record found means incomplete
        }

        // Check if any of the required fields are null or empty
        return (
            empty($teacher['birthday']) ||
            empty($teacher['gender']) ||
            empty($teacher['civil_status']) ||
            empty($teacher['municipality']) ||
            empty($teacher['barangay']) ||
            empty($teacher['street'])
        );
    }
    public function dashboardCount($userId)
    {
       return $this->db->table('teachers t')
        ->select('
            t.teacher_department,
            COUNT(DISTINCT s.student_id) AS total_students,
            COUNT(DISTINCT c.id) AS total_material
        ')
        ->join('students s', 's.class_level = t.teacher_department')
        ->join('classroom c', 'c.user_id = t.user_id')
        ->where('t.user_id', $userId)
        ->groupBy('t.teacher_department')
        ->get()
        ->getRowArray();
    }
    

    public function recentNotif($userId)
    {
        return $this->db->table('notifications')
            ->select('message AS activity_text')
            ->where('user_id', $userId)
            ->whereIn('type', ['Highlight', 'Progress Report', 'announcement'])
            ->orderBy('created_at', 'DESC')
            ->limit(10) // ✅ limit to 10
            ->get()
            ->getResult(); // returns as objects
    }
    //================ newly added =============//
    public function dashboardCountOpening($userId, $openingId)
    {
        return $this->db->table('teachers t')
            ->select('
                t.teacher_department,
                COUNT(DISTINCT s.admission_id) AS total_students,
                COUNT(DISTINCT c.id) AS total_material
            ')
            ->join('admissions s', 's.class_applied = t.teacher_department', 'left') // LEFT JOIN
            ->join('classroom c', 'c.user_id = t.user_id', 'left') // LEFT JOIN
            ->where('t.user_id', $userId)
            ->where('s.status', "Enrolled") 
            ->groupBy('t.teacher_department')
            ->get()
            ->getRowArray();
    }


    public function getStudentsByTeacherOpening($teacherUserId, $openingId)
    {
        return $this->db->table('students s')
            ->select("s.*,
                ad.nickname,
                ad.middle_name,
                ad.nationality,
                ad.gender,
                ad.birthday as admission_birthday,
                ad.age,
                ad.father_name,
                ad.father_occupation,
                ad.mother_name,
                ad.mother_occupation,
                ad.contact_number,
                ad.email,
                ad.municipality,
                ad.barangay,
                ad.street,
                CONCAT(
                    s.last_name, ', ',
                    s.first_name,
                    IF(s.middle_name IS NOT NULL AND s.middle_name != '', 
                        CONCAT(' ', LEFT(s.middle_name, 1), '.'),
                        ''
                    )
                ) AS full_name")
            ->join('teachers t', 's.class_level = t.teacher_department')
            ->join('admissions ad', 'ad.admission_id = s.admission_id')
            ->where('t.user_id', $teacherUserId)
            ->where('ad.openingclosing_id', $openingId)
            ->get()
            ->getResultArray();
    }
    
    
    

    








    
}
