<?php

namespace App\Controllers;
use App\Models\Admission_Model;
use App\Models\ClassModel;
use App\Models\NotificationModel;
use App\Models\Teacher_Model;
use App\Models\StudentModel;
use App\Models\ClassroomModel;
use App\Models\AnnouncementModel;
use App\Models\TeacherPhotosUploadModel;
use CodeIgniter\Email\Email;
use App\Models\OpeningModel;

class TeacherController extends BaseController
{
   

	 public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
	public function teacherDashboard(): string
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $notificationmodel = new \App\Models\NotificationModel();
        $profilepicModel = new \App\Models\Teacher_Model();
        $openingModel = new OpeningModel();
        $userId = session()->get('user_id');
        
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();


         $data = [
            'teacher'        => $profilepicModel ->teacherData($userId),
            'profilepic'     => $profilepicModel ->profilepic(),
            // 'dashboardCount' => $profilepicModel ->dashboardCount($userId),dashboardCountOpening
            'dashboardCount' => $profilepicModel ->dashboardCountOpening($userId,$openingId),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            'recent_activities'         => $profilepicModel -> recentNotif($userId),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];

        return view('teacher/dashboard',$data);
    }
    public function teacherAnnouncement(): string
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $announcementModel = new \App\Models\AnnouncementModel();
          $notificationmodel = new \App\Models\NotificationModel();
        // $announcements = $announcementModel->activeAnnouncementOpening($userId); 
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();
         $announcements = $announcementModel->activeAnnouncementOpening($userId, $openingId); 




         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'announcements' => $announcements,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

            
        ];

        return view('teacher/announcement',$data);
    }

    public function teacherGrades(): string
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
         $notificationmodel = new \App\Models\NotificationModel();
        
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();




         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'studentData' => $profilepicModel ->getStudentsByTeacherOpening($userId, $openingId),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

            
        ];

        return view('teacher/grades',$data);
    }

    public function teacherMaterial(): string
    {
         $notificationmodel = new \App\Models\NotificationModel();
         $profilepicModel = new \App\Models\Teacher_Model();
         $classroomModel = new \App\Models\ClassroomModel();
         $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();



         $userId = session()->get('user_id');

         $data = [
            //'classroom' => $classroomModel ->classroomData($userId),classroomDataOpening
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'classroom' => $classroomModel ->classroomDataOpening($userId, $openingId),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

        ];

        return view('teacher/materials',$data);
    }
    public function teacherStudents(): string
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $notificationmodel = new \App\Models\NotificationModel();
        $profilepicModel = new \App\Models\Teacher_Model();
        $userId = session()->get('user_id');
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();


        $data = [
             //'studentData' => $profilepicModel ->getStudentsByTeacher($userId),getStudentsByTeacherOpening
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'studentData' => $profilepicModel ->getStudentsByTeacherOpening($userId,$openingId),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

            
        ];

        return view('teacher/student',$data);
    }
    public function teacherProfile(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/teacher-profile',$data);
    }
    public function teacherProfileInfo(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherinfo($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/teacer-profile-info',$data);
    }
    public function adminProfilepostTeacher()
    {
        $userModel = new \App\Models\UserModel();
        $teacherModel = new \App\Models\Teacher_Model();

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->back('login')->with('error', 'User not logged in.');
        }

        
        $newEmail = $this->request->getPost('email');

        // Update email in users table
        $userModel->update($userId, ['email' => $newEmail]);

        // Handle profile image
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/assets/profilepic', $newName); // moves to public/assets/img
            $teacherModel->where('user_id', $userId)->set(['profile_pic' => $newName])->update();
        }
        session()->setFlashdata('success', 'Profile updated.');
        return redirect()->to('/teacherProfile')->with('success', 'Profile updated.');
    }
    public function teacherResetPasswordPost()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        
        if ($newPassword !== $confirmPassword) {
             session()->setFlashdata('error', 'New passwords do not match.');
            return redirect()->to('/teacherProfile')->with('error', 'New passwords do not match.');
        }

        $userModel = new \App\Models\UserModel(); 
        $user = $userModel->find($userId);

        if (!$user || $currentPassword !== $user['password_hash']) {
             session()->setFlashdata('error', 'Current password is incorrect.');
        return redirect()->to('/teacherProfile')->with('error', 'Current password is incorrect.');
        }

        // Hash and update password
        $userModel->update($userId, [
            'password_hash' => $newPassword
        ]);

        session()->setFlashdata('success', 'Password changed successfully.');
        return redirect()->to('/teacherProfile')->with('success', 'Password changed successfully.');
    }

    public function teacherprogressreport($studentId)
    {
        $userId = session()->get('user_id');
        $profilepicModel = new \App\Models\Teacher_Model();
        $stidentModel = new \App\Models\StudentModel();
        $categoryModel = new \App\Models\ProgressCategoryModel();
        $criteriaModel = new \App\Models\ProgressCriteriaModel();
        $progressAssessmentModel = new \App\Models\ProgressAssessmentModel();
        $remarkModel = new \App\Models\ProgressRemarkModel();
       
        $categories = $categoryModel->findAll();
        $allRemarks = $remarkModel->getAllremarks($studentId);

        
        $remarksByQuarter = [];
        foreach($allRemarks as $r) {
            $remarksByQuarter[$r['quarter']] = $r;
        }
        
        
        
        foreach ($categories as &$category) {
            $category['criteria'] = $criteriaModel
                ->where('category_id', $category['id'])
                ->findAll();
        }

         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'studentData' => $stidentModel ->studentDataTeacher($studentId),
            'studentAssessments' => $progressAssessmentModel->getAllAssessments($studentId),
            'categories' => $categories,
            'remarks' => $remarksByQuarter,
            
          
            
        ];

        return view('teacher/progress-report',$data);
    }
    // public function teacherprogressreportPost ($studentId)
    // {
    //     $assessmentModel = new \App\Models\ProgressAssessmentModel();
    //     $EnrollmentModel = new \App\Models\EnrollmentModel();

    //     $criteriaData = $this->request->getPost('criteria'); 
    //     $quarter      = $this->request->getPost('quarter');
    //     $remark      = $this->request->getPost('remarks');
        
 
    //     $enrolled = $EnrollmentModel->getEnrolledDate($studentId);

    //     if (empty($criteriaData)) {
    //         return redirect()->back()->with('error', 'No assessment submitted.');
    //     }
       

    //     $schoolYearValue = $enrolled ? $enrolled->date_enrolled : null;

            

    //     foreach ($criteriaData as $criteriaId => $rating) {
    //         $assessmentModel->insert([
    //             'user_id'     => $studentId,
    //             'criteria_id' => $criteriaId,
    //             'quarter'     => 1,
    //             'school_year' => $schoolYearValue,
    //             'assessment'  => $rating,
    //             'created_at'  => date('Y-m-d H:i:s'),
    //         ]);
    //     }

    //     return redirect()->to('/teacher-grades')->with('success', 'Progress report saved successfully.');
    // }
    // public function teacher_progress_report_post($studentId)
    // {
    //     $assessmentModel = new \App\Models\ProgressAssessmentModel();
    //     $EnrollmentModel = new \App\Models\EnrollmentModel();
    //     $remarkModel = new \App\Models\ProgressRemarkModel();
    //     $quarter = $this->request->getPost('quarter');
    //     $criteriaData = $this->request->getPost('criteria'); // Array like [19 => 'Needs Improvement']
    //     $remarks = $this->request->getPost('remarks') ?? '';

    //     // Validation
    //     if (!$quarter || !is_numeric($quarter) || $quarter < 1 || $quarter > 4) {
    //         return redirect()->back()->with('error', 'Invalid quarter selected.');
    //     }
    //     if (empty($criteriaData) || !is_array($criteriaData)) {
    //         return redirect()->back()->with('error', 'No assessment data provided.');
    //     }

    //      $enrolled = $EnrollmentModel->getEnrolledDate($studentId);

       

    //     if (empty($criteriaData)) {
    //         return redirect()->back()->with('error', 'No assessment submitted.');
    //     }

    //     $schoolYearValue = $enrolled ? $enrolled->date_enrolled : null;
        

    //     $successCount = 0;
    //     $errorCount = 0;

       
    //     foreach ($criteriaData as $criteriaId => $assessment) {
    //         $criteriaId = (int) $criteriaId; 
    //         if ($criteriaId < 1 || $criteriaId > 56 || empty(trim($assessment))) {
    //             continue; 
    //         }

    //         $data = [
    //             'user_id' => $studentId,
    //             'criteria_id' => $criteriaId,
    //             'quarter' => $quarter,
    //             'school_year' => $schoolYearValue,
    //             'assessment' => trim($assessment),
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];

    //         if ($assessmentModel->saveOrUpdateAssessment($data)) {
    //             $successCount++;
    //         } else {
    //             $errorCount++;
    //           log_message('error', 'Failed to save assessment for criteria ' . $criteriaId . ': ' . json_encode($assessmentModel->errors()));

    //         }
    //     }
    //         if (!empty(trim($remarks))) {
    //         $remarkData = [
    //             'user_id' => $studentId,
    //             'quarter' => $quarter,
    //             'school_year' => $schoolYearValue,
    //             'remarks' => trim($remarks),
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];
    //         $remarkModel->saveOrUpdateRemark($remarkData);
    //     }

        
    //     if ($errorCount > 0) {
    //         return redirect()->back()->with('error', "Saved {$successCount} assessments, but {$errorCount} failed. Please try again.");
    //     }

    //     return redirect()->back()->with('success', "Progress report for Quarter {$quarter} saved/updated successfully ({$successCount} criteria)! Reload to see changes.");
    // }
    public function teacher_progress_report_post($studentId)
    {
        $assessmentModel = new \App\Models\ProgressAssessmentModel();
        $EnrollmentModel = new \App\Models\EnrollmentModel();
        $remarkModel = new \App\Models\ProgressRemarkModel();
        $userId = session()->get('user_id');

        $quarter = $this->request->getPost('quarter');
        $criteriaData = $this->request->getPost('criteria'); // [criteria_id => 'Needs Improvement']
        $remarks = $this->request->getPost('remarks') ?? '';

        // Validation
        if (!$quarter || !is_numeric($quarter) || $quarter < 1 || $quarter > 4) {
            return redirect()->back()->with('error', 'Invalid quarter selected.');
        }
        if (empty($criteriaData) || !is_array($criteriaData)) {
            return redirect()->back()->with('error', 'No assessment data provided.');
        }

        $enrolled = $EnrollmentModel->getEnrolledDate($studentId);
        $schoolYearValue = $enrolled ? $enrolled->date_enrolled : null;

        $successCount = 0;
        $errorCount = 0;

        foreach ($criteriaData as $criteriaId => $assessment) {
            $criteriaId = (int) $criteriaId;
            if ($criteriaId < 1 || $criteriaId > 56 || empty(trim($assessment))) {
                continue;
            }

            // ✅ Check if previous quarter exists (only if quarter > 1)
            if ($quarter > 1) {
                $previousQuarter = $quarter - 1;
                $previousExists = $assessmentModel
                    ->where('user_id', $studentId)
                    ->where('criteria_id', $criteriaId)
                    ->where('quarter', $previousQuarter)
                    ->where('school_year', $schoolYearValue)
                    ->first();

                if (!$previousExists) {
                    return redirect()->back()->with(
                        'error',
                        "Cannot submit Quarter {$quarter} — missing Quarter {$previousQuarter} assessment for criteria ID {$criteriaId}."
                    );
                }
            }

            $data = [
                'user_id' => $studentId,
                'criteria_id' => $criteriaId,
                'quarter' => $quarter,
                'school_year' => $schoolYearValue,
                'assessment' => trim($assessment),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($assessmentModel->saveOrUpdateAssessment($data)) {
                $successCount++;
            } else {
                $errorCount++;
                log_message('error', 'Failed to save assessment for criteria ' . $criteriaId . ': ' . json_encode($assessmentModel->errors()));
            }
        }

        if (!empty(trim($remarks))) {
            $remarkData = [
                'user_id' => $studentId,
                'quarter' => $quarter,
                'school_year' => $schoolYearValue,
                'remarks' => trim($remarks),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $remarkModel->saveOrUpdateRemark($remarkData);
        }

        if ($errorCount > 0) {
            return redirect()->back()->with('error', "Saved assessments, but {$errorCount} failed. Please try again.");
        }

            $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $studentId, 
                'title'   => 'Progress Report',
                'message' => 'New Progress Report',
                'type'    => 'Progress Report', 
                'is_read' => 0
            ]);
            $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $userId, 
                'title'   => 'Progress Report',
                'message' => 'New Progress Report',
                'type'    => 'Progress Report', 
                'is_read' => 0
            ]);



        return redirect()->back()->with('success', "Progress report for Quarter {$quarter} saved/updated successfully ({$successCount} criteria)!");
    }

    public function classroomPost()
    {
        if (!session()->has('user_id')) {
            log_message('error', '[SESSION ERROR] No user_id in session.');
            return redirect()->to('login')->with('error', 'Please log in first.');
        }

        $userId      = session()->get('user_id');
        $openingId = session()->get('opening_id');
        $title       = $this->request->getPost('title');
        $classLevel  = $this->request->getPost('classLevel');
        $description = $this->request->getPost('description') ?? '';
        $uploadType  = $this->request->getPost('uploadType'); 
        $filename    = null;

        if (empty($title) || empty($classLevel) || empty($uploadType)|| empty($description) ) {
              session()->setFlashdata('error', 'Title, class level, and upload type are required.');
            return redirect()->back()->with('error', 'Title, class level, and upload type are required.');
        }

        // -------------------------------
        // 1️⃣ Handle file upload
        // -------------------------------
        if ($uploadType === 'file') {
            $file = $this->request->getFile('filename');

            if ($file && !$file->hasMoved()) {
                if (!$file->isValid()) {
                    $error = $file->getErrorString();
                    session()->setFlashdata('error', 'File upload failed');
                    log_message('error', '[UPLOAD FAILED] ' . $error);
                    return redirect()->back()->with('error', 'File upload failed: ' . $error);
                }

                $allowedMimeTypes = [
                    'application/pdf', 'image/jpeg', 'image/png', 'video/mp4', 'video/mpeg', 'video/quicktime'
                ];
                $maxFileSize = 100 * 1024 * 1024; // 100MB

                $mime = $file->getMimeType();
                $fileSize = $file->getSize();

                if (!in_array($mime, $allowedMimeTypes)) {
                    session()->setFlashdata('error', 'Invalid file type. Only PDF, images, and videos are allowed');
                    return redirect()->back()->with('error', 'Invalid file type. Only PDF, images, and videos are allowed.');
                }
                if ($fileSize > $maxFileSize) {
                    session()->setFlashdata('error', 'File too large. Maximum allowed size is 100MB. Please upload your file to Google Drive and paste the link here instead.');
                    return redirect()->back()->with('error', 'File too large. Max 100MB.');
                }

                $uploadPath = ROOTPATH . 'public/assets/uploadedfile/';
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

                $filename = $file->getRandomName();
                $file->move($uploadPath, $filename);
                log_message('info', '[UPLOAD SUCCESS] User ID: ' . $userId . ' uploaded ' . $filename);
            }
        }

        // -------------------------------
        // 2️⃣ Handle link upload
        // -------------------------------
        elseif ($uploadType === 'link') {
            $link = trim($this->request->getPost('link'));
            if (!filter_var($link, FILTER_VALIDATE_URL)) {
                session()->setFlashdata('error', 'Invalid link URL');
                return redirect()->back()->with('error', 'Invalid link URL.');
            }
            $filename = $link; // store link in file column
            log_message('info', '[LINK SUBMITTED] User ID: ' . $userId . ' shared link: ' . $link);
        }

        // -------------------------------
        // 3️⃣ Save to database
        // -------------------------------
        $classroomModel = new \App\Models\ClassroomModel();
        $insertData = [
            'user_id'     => $userId,
            'class_level' => $classLevel,
            'file'        => $filename,
            'title'       => $title,
            'description' => $description, // file or link
            'openingclosing_id' => $openingId
        ];

        if ($classroomModel->insert($insertData)) {

             $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $userId, 
                'title'   => 'Material',
                'message' => 'New Material',
                'type'    => 'material', 
                'is_read' => 0
            ]);

             session()->setFlashdata('success', 'Material uploaded successfully');
            return redirect()->to('teacher-materials')->with('success', 'Material uploaded successfully.');
        }
        session()->setFlashdata('error', 'Data insert failed. Please try again or contact the admin to report this issue.');
        return redirect()->back()->with('error', 'Database insert failed. Please try again.');
    }
    public function deleteMaterial($materialId)
    {
        $classroomModel = new \App\Models\ClassroomModel();

        // Call the delete function from model
        $deleted = $classroomModel->deleteMaterial($materialId);

        if ($deleted) {
            session()->setFlashdata('success', 'Material deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete material or material not found. Please try again.');
        }

        return redirect()->to('/teacher-materials');
    }
     public function InteractiveLearning(): string
    {
        $notificationmodel = new \App\Models\NotificationModel();
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($userId),
            'notification'         => $notificationmodel -> userNotif($userId),
            
        ];

        return view('teacher/interactive-learning',$data);
    }
     public function coloringGame(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/coloring-game',$data);
    }

     public function shapeGame(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/shape-game',$data);
    }

    public function animalGame(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/animal-game',$data);
    }


    public function numberGame(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/number-game',$data);
    }


     public function colorGame(): string
    {
         $profilepicModel = new \App\Models\Teacher_Model();
         $userId = session()->get('user_id');
         $data = [
            'teacher' => $profilepicModel ->teacherData($userId),
            'profilepic' => $profilepicModel ->profilepic(),
            
        ];

        return view('teacher/color-game',$data);
    }
    public function announcementPost()
    {
       
         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
         $model = new AnnouncementModel();
         $openingId = session()->get('opening_id');
        
        $title = $this->request->getPost('title');
        $message = $this->request->getPost('message');

        $model->saveAnnouncementOpening($title, $message,$userId,$openingId);

        
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
         session()->setFlashdata('success', 'Announcement posted');
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
         session()->setFlashdata('success', 'Announcement updated successfully.');
        return redirect()->to(base_url('/teacher-annoucement'))->with('success', 'Announcement updated successfully.');
    }
    public function teacherUploadHighlight($studentId)
    {
         $profilepicModel = new \App\Models\Teacher_Model(); 
         $admissionModel = new \App\Models\Admission_Model(); 
        $TeacherPhotosModel = new \App\Models\TeacherPhotosUploadModel();

     

         $userId = session()->get('user_id');
         $data = [
            'highlight'     => $TeacherPhotosModel ->highlightPhotoPerchild($studentId),
            'teacher'       => $profilepicModel ->teacherData($userId),
            'profilepic'    => $profilepicModel ->profilepic(),
            'student'       => $admissionModel  ->getStudent($studentId),
            
        ];

        return view('teacher/studentHighlightUpload',$data);
    }
    public function saveUpload()
    {
        $model = new TeacherPhotosUploadModel();
        $user_id = session()->get('user_id');
        $pictureFile = $this->request->getFile('image');
        $comment = $this->request->getPost('comment');
        $userID = $this->request->getPost('userID');

        log_message('debug', 'saveUpload() called. Received user_id=' . $user_id . ', userID=' . $userID . ', comment=' . $comment);

        if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {

            log_message('debug', 'Image detected. Original filename: ' . $pictureFile->getName());

            $newName = $pictureFile->getRandomName();
            $pictureFile->move('public/assets/highlight', $newName);

            log_message('debug', 'Image moved to: public/assets/highlight/' . $newName);

            // Save record in DB
            $data = [
                'teacher_id' => $user_id,
                'user_id'    => $userID,
                'photo'      => $newName,
                'comment'    => $comment
            ];

            $model->insert($data);
            log_message('debug', 'Inserted in DB: ' . json_encode($data));

            // Notifications
            $notification = new \App\Models\NotificationModel();

            $notification->insert([
                'user_id' => $user_id,
                'title'   => 'Upload Highlight',
                'message' => 'Uploaded Highlight',
                'type'    => 'Highlight',
                'is_read' => 0
            ]);
            $notification->insert([
                'user_id' => $userID,
                'title'   => 'Upload Highlight',
                'message' => 'Uploaded Highlight',
                'type'    => 'Highlight',
                'is_read' => 0
            ]);

            $responseData = [
                'status'  => 'success',
                'path'    => base_url('public/assets/highlight/' . $newName),
                'comment' => $comment
            ];

            // 🔥 FINAL RESPONSE LOG
            log_message('debug', 'saveUpload JSON Response: ' . json_encode($responseData));

            return $this->response->setJSON($responseData);
        }

        // ERROR AREA
        log_message('error', 'Invalid or missing image. File info: ' . json_encode([
            'exists'   => $pictureFile ? 'yes' : 'no',
            'valid'    => $pictureFile ? $pictureFile->isValid() : 'no file',
            'moved'    => $pictureFile ? $pictureFile->hasMoved() : 'no file'
        ]));

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Invalid or missing image file.'
        ]);
    }
    public function DeleteUpload()
    {
        $model = new TeacherPhotosUploadModel();
    $input = $this->request->getJSON(true);
    $photoId = $input['id'] ?? null;

    if (!$photoId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Photo ID is required.'
        ]);
    }

    $photo = $model->find($photoId);
    if (!$photo) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Photo not found.'
        ]);
    }

    $filePath = WRITEPATH . '../public/assets/highlight/' . $photo['photo'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $model->delete($photoId);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Photo deleted successfully.'
    ]);
    }
    
    public function profileipdateTeacher()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $model = new \App\Models\Teacher_Model();
        helper('url');

        $post = $this->request->getPost();
        log_message('info', 'profileUpdateTeacher called with data: ' . json_encode($post));

        $user_id = $post['user_id'];
        $teacher_id = $post['admission_id'];
        $file = $this->request->getFile('profile_image');

        // Get current profile picture first
        $currentTeacher = $model->where('user_id', $user_id)->first();
        $currentProfilePic = $currentTeacher['profile_pic'] ?? null;
        $newName = $currentProfilePic; // Default to current image

        // If new image uploaded
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/assets/profilepic', $newName);
        }

        // Data for update
        $teacherData = [
            'first_name'         => $post['first_name'],
            'middle_name'        => $post['middle_name'],
            'last_name'          => $post['last_name'],
            'specialization'     => $post['specialization'],
            'teacher_department' => $post['teacher_department'],
            'contact_number'     => $post['contact_number'],
            'email'              => $post['email'],
            'birthday'           => $post['date_of_birth'],
            'gender'             => $post['gender'],
            'civil_status'       => $post['civil_status'],
            'municipality'       => $post['municipality'],
            'barangay'           => $post['barangay'],
            'street'             => $post['street'],
            'profile_pic'        => $newName
        ];

        // Update teacher table
        $updatedTeacher = $model->update($teacher_id, $teacherData);
        log_message('info', "Updated teacher table for user_id {$user_id}: " . ($updatedTeacher ? 'Success' : 'Failed'));

        // Update user table (email only)
        $updatedUser = $this->db->table('users')->where('id', $user_id)->update([
            'email' => $post['email']
        ]);
        log_message('info', "Updated users table for user_id {$user_id}: " . ($updatedUser ? 'Success' : 'Failed'));

        // Redirect with message
        if ($updatedTeacher && $updatedUser) {
             $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $user_id, 
                'title'   => 'Profile edit',
                'message' => 'Profile Updated',
                'type'    => 'Update', 
                'is_read' => 0
            ]);
            session()->setFlashdata('success', 'Teacher information updated successfully!');
           
        } else {
             session()->setFlashdata('error', 'Failed to update teacher information.');
           
        }



        return redirect()->to('/teacherProfile-info');
    }










        
}



	


	
	
