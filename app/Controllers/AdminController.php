<?php

namespace App\Controllers;

use App\Models\Admin_Model;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\Attendance_Model;
use App\Models\PaymentModel;
use App\Models\OpeningModel;
use App\Models\AuditLogModel;
use App\Models\ClassModel;
use App\Models\AnnouncementModel;
use App\Models\AdminStaffModel;
use App\Models\EnrolmentModel;
use App\Models\NotificationModel;
use App\Models\Teacher_Model;
use App\Models\GuardiansAccountModel;
use App\Models\CustomizeThemeModel;
use App\Models\TuitionPlanModel;
use CodeIgniter\API\ResponseTrait;
use Dompdf\Dompdf;
use Dompdf\Options;




class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    //123  
    public function admindashbord()
    {
        
        $this->maybeMarkAbsentees();
        $dashboardModel = new Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $paymentModel = new \App\Models\PaymentModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        log_message('debug', 'user_id: ' . $userId);
        
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
        $yearsRecord     = $openingModel       -> openclosedate();



        $data = [
            // 'total_students' => $dashboardModel->getTotalStudents(),
             //'total_applicants' => $dashboardModel->getTotalApplicants(),
             //'active_classes' => $dashboardModel->getActiveClasses(),
            'total_students' => $dashboardModel->getTotalStudentsOpining($openingId),
            'total_applicants' => $dashboardModel->getTotalApplicantsOpening($openingId),
            'active_classes' => $dashboardModel->getActiveClassesOpening($openingId),
            'recent_activities' => $dashboardModel->recentactivity(),
            'profilepic' => $profilepicModel ->profilepic(),
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
            'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];

        return view('admin/dashboard', $data); 
    }
    
    public function AdminAdmission()
    {
        
        //
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $members_model = new \App\Models\Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $notificationmodel = new \App\Models\NotificationModel();

         $openingModel = new OpeningModel();
        $notificationmodel->markAllAsReadAdmission();
        
         $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
        $yearsRecord     = $openingModel       -> openclosedate(); 

        $userId = session()->get('user_id');
        log_message('debug', 'user_id: ' . $userId);

        $data = [
            //'members'       => $members_model      -> getAllAdmissions(),
            'members'       => $members_model      -> getAllAdmissionsOpening($openingId),
            'profilepic'    => $profilepicModel    -> profilepic(),
            'notification'  => $notificationmodel  -> adminNotif($userId),
            'unread_count'  => $notificationmodel  -> adminNotifCount(),
            'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,
             'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];

        return view('admin/admission', $data);
    }

    public function updateAdmissionStatus()
    {
        
        $admission_id = $this->request->getPost('admission_id');
        $user = $this->request->getPost('userID');
        $status = $this->request->getPost('status');
        $reason = $this->request->getPost('reason');
        log_message('error', 'Reason received: ' . json_encode($reason));
        $adminName = session()->get('full_name Admin');


        if ($admission_id && $status) {
            $model = new \App\Models\Admin_Model();

            // Get email of the admission
            $admission = $model->find($admission_id);
            $email = $admission->email ?? null;


            // Update status
            $updated = $model->update($admission_id, ['status' => $status, 'reason' => $reason]);
                if (!$updated) {
                    log_message('error', 'Update failed for admission ID: ' . $admission_id);
                }


            

            // If status is approved and email exists
            if ($status === 'Approved' && $email) {
            
                $emailService = \Config\Services::email();

                $emailService->setTo($email);
                $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
                $emailService->setSubject('Admission Approved');
                $emailService->setMailType('html');
                $emailService->setMessage("
                     <p>Dear " . esc($admission->first_name) . ",</p>
                    <p>We are pleased to inform you that your admission has been <strong>Approved</strong>.</p>
                    <p>Your enrollment schedule is available from <strong>Monday to Friday, 8:00 AM to 4:00 PM</strong>.</p>

                    <p>Please bring the following requirements upon your visit:</p>
                    <ul>
                    <li>Photocopy of Birth Certificate</li>
                    <li>2 pcs 1x1 ID Pictures</li>
                    </ul>

                    <p>Welcome aboard!</p>
                    <p>– School Admin</p>

                ");

                if (!$emailService->send()) {
                    log_message('error', 'Email sending failed: ' . print_r($emailService->printDebugger(['headers']), true));
                }
            }else{
                $emailService = \Config\Services::email();

                $emailService->setTo($email);
                $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
                $emailService->setSubject('Admission Disaapproved');
                $emailService->setMailType('html');
                $emailService->setMessage("
                     <p>Dear " . esc($admission->first_name) . ",</p>

                <p>We regret to inform you that your admission application has been <strong>disapproved</strong>.</p>

                <p><strong>Reason:</strong> " . esc($reason) . "</p>

                <p>If you have any questions or need further clarification, please do not hesitate to contact the school administration. We are here to assist you.</p>

                <p>Thank you for your time and interest in our institution.</p>

                <p>Sincerely,<br>
                School Administration</p>

                ");

                if (!$emailService->send()) {
                    log_message('error', 'Email sending failed: ' . print_r($emailService->printDebugger(['headers']), true));
                }

            }
            

            $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $user, 
                'title'   => 'Admission',
                'message' => 'admission Updated status',
                'type'    => 'admission', 
                'is_read' => 0
            ]);
             $audit = new \App\Models\AuditLogModel();
            $audit->insert([
                'admission_id' => $admission_id,
                'action'       => 'Update Status',
                'description'  => "Status changed to {$status}. Reason: {$reason}",
                'done_by'      => $adminName, // FULLNAME FROM SESSION
                'status'      => $status
                
            ]);
            
            session()->setFlashdata('success', 'Status updated and email sent!');
            return redirect()->to('/admin-admission')->with('message', 'Status updated and email sent!');
        }
        session()->setFlashdata('error', 'Invalid request');
        return redirect()->to('/admin-admission')->with('error', 'Invalid request.');
    }

    
    public function enrollStudent()
    {
        $admissionId = $this->request->getPost('admission_id');
        $admissionModel = new \App\Models\Admin_Model();
        $userModel = new \App\Models\UserModel();
        $studentModel = new \App\Models\StudentModel();
        $enrollment = new \App\Models\EnrollmentModel();
        $openingmodel = new \App\Models\OpeningModel();
        $notification = new \App\Models\NotificationModel();

        $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];
        

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            
            $studentModel->enrollStudent($admissionId, $admissionModel, $userModel, $enrollment,$openingId,$notification);
            
            
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed.');
            }
            $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $user, 
                'title'   => 'Admission',
                'message' => 'Your child is officialy enrolled',
                'type'    => 'admission', 
                'is_read' => 0
            ]);

            return redirect()->to('admin-admission')->with('success', 'Student enrolled successfully!');
       } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('admin-admission')->withInput()->with('error', 'Enrollment failed: ' . $e->getMessage());
        }


    }
    public function enrolledStudents()
    {
        
        $adminModel = new \App\Models\Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $class_model = new \App\Models\ClassModel(); 
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();
     
        $students = $adminModel->getEnrolledStudentsWithAdmission();
         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        log_message('debug', 'user_id: ' . $userId);
       
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; 
            session()->set('opening_id', $openingId);
        }
        $yearsRecord     = $openingModel       -> openclosedate();
        
        $data = [
            //'students' => $students,getActiveClassNamesOpining
            //'classes' => $class_model->findAll(),

            'classes' => $class_model->getActiveClassNamesOpining($openingId),
            'students' => $adminModel->getEnrolledStudentsWithAdmissionOpening($openingId),
            'profilepic' => $profilepicModel ->profilepic(),
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
             'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,


        ];

        return view('admin/enrolled-students', $data);
    }
    public function updateStatusInterView()
    {
        
        $data = $this->request->getJSON(true);
        $admission_id = $data['admission_id'];
        $status = $data['status'];
        $reason = $data['reason'] ?? null;
        $email = $data['email'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $adminName = session()->get('full_name Admin');
        $model = new \App\Models\Admin_Model();

        // Ensure record exists
        $admission = $model->find($admission_id);
        if (!$admission) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Admission not found.'
            ]);
        }

        // Update status + reason
        $updated = $model->update($admission_id, [
            'status' => $status,
            'reason' => $reason
        ]);

       

        // ✅ Write log for successful status update
        log_message('info', "Admission ID {$admission_id} status updated to '{$status}' by admin. Reason: " . ($reason ?: 'None'));

        // Send email if interview failed
        if ($status === 'Interview Failed' && $reason) {
            $emailService = \Config\Services::email();

            $emailService->setTo($email);
            $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
            $emailService->setSubject('Admission Interview');
            $emailService->setMailType('html');
            $emailService->setMessage("
                <div style='font-family: Arial, sans-serif; background-color: #f7f9fc; padding: 20px;'>
                    <div style='max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;'>
                        <div style='background-color: #c0392b; color: #ffffff; padding: 15px 20px; text-align: center;'>
                            <h2 style='margin: 0; font-size: 20px;'>Interview Result Notification</h2>
                        </div>
                        <div style='padding: 25px; color: #333333;'>
                            <p>Dear Parent/Guardian,</p>
                            <p>We are sorry to inform you that your child, 
                            <strong style='color: #c0392b;'>" . esc($first_name) . " " . esc($last_name) . "</strong>, 
                            did not pass the admission interview.</p>
                            <div style='background-color: #f8d7da; padding: 10px 15px; border-left: 4px solid #c0392b; margin: 15px 0;'>
                                <strong>Reason for Rejection:</strong><br>
                                " . esc($reason) . "
                            </div>
                            <p>We truly appreciate your effort and interest in joining our institution.</p>
                            <p style='margin-top: 30px;'>Sincerely,<br>
                            <strong>School Administration</strong><br>
                            <span style='color: #888;'>Brightside School</span></p>
                        </div>
                        <div style='background-color: #f1f1f1; text-align: center; padding: 10px; font-size: 12px; color: #555;'>
                            &copy; " . date('Y') . " Brightside School. All rights reserved.
                        </div>
                    </div>
                </div>
            ");

            if (!$emailService->send()) {
                log_message('error', 'Email sending failed: ' . print_r($emailService->printDebugger(['headers']), true));
            } else {
                log_message('info', "Interview failure email sent to {$email} for admission ID {$admission_id}");
            }
        }
        $audit = new \App\Models\AuditLogModel();
                $audit->insert([
                    'admission_id' => $admission_id,
                    'action'       => 'Update Status',
                    'description'  => "Status changed to {$status}. Reason: {$reason}",
                    'done_by'      => $adminName, // FULLNAME FROM SESSION
                    'status'      => $status
                ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => "Status updated to {$status}."
        ]);
    }

    public function archived()
    {
        
       
        $members_model = new \App\Models\Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $openingModel = new OpeningModel();


        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
        $yearsRecord     = $openingModel       -> openclosedate();
        
        $data=[
            //'members' => $members_model->alldisapproved(),
            'members' => $members_model->alldisapprovedOpening($openingId),
            'profilepic' => $profilepicModel ->profilepic(),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];
        
        return view('admin/archived',$data);
    }

    public function restore()
    {
        $admission_id = $this->request->getPost('admission_id');
        $status = $this->request->getPost('status');

        if ($admission_id && $status) {
            $model = new \App\Models\Admin_Model();
            $model->update($admission_id, ['status' => $status]);
            session()->setFlashdata('success', 'Restore Successfully');
            return redirect()->to('/admin-admission')->with('message', 'Status updated!');
        }
        return redirect()->to('/admin-admission')->with('error', 'Invalid request.');
    }

    public function attendance()
    {
       
        $studentModel = new \App\Models\StudentModel();
        $classModel = new \App\Models\ClassModel();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();

         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $openingId = session()->get('opening_id');

        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
        $yearsRecord     = $openingModel       -> openclosedate();


        $userId = session()->get('user_id');

        $data = [
            //'classes'   => $classModel->findAll(),
            // 'summaries' => $studentModel->attendance_summary_view(),
            'classes'   => $classModel->getActiveClassNamesOpining($openingId),
            'summaries' => $studentModel->attendance_summary_viewOpening($openingId),
            'profilepic' => $profilepicModel ->profilepic(),
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
             'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,


        ];

        return view('admin/attendance', $data);
    }


    public function getGuardiansByUserId($userId)
    {
        $guardianModel = new \App\Models\GuardianModel();
        $guardians = $guardianModel
            ->where('user_id', $userId)
            ->findAll();

        return $this->response->setJSON($guardians);
    }
    
    public function markDailyAbsentees()
    {
        $today = date('Y-m-d');
        $studentModel = new StudentModel();
        $attendanceModel = new Attendance_Model();

        // Get all enrolled students
        $allStudents = $studentModel->select('user_id')->findAll();

        // Get user_ids that already have attendance today
        $presentStudents = $attendanceModel
            ->select('user_id')
            ->where('date', $today)
            ->findAll();

        $presentIds = array_column($presentStudents, 'user_id');

        $absentData = [];

        foreach ($allStudents as $student) {
            if (!in_array($student['user_id'], $presentIds)) {
                $absentData[] = [
                    'user_id' => $student['user_id'],
                    'date' => $today,
                    'status' => 'Absent',
                    'arrival_time' => '',
                    'leave_time' => '',
                    'picked_up_by' => '',
                ];
            }
        }

        if (!empty($absentData)) {
            $attendanceModel->insertBatch($absentData);
        }

        return $this->response->setJSON([
            'message' => 'Absentees marked successfully',
            'count' => count($absentData)
        ]);
    }
    public function maybeMarkAbsentees()
    {
        $currentHour = date('H');

    // Only trigger at 6PM (18:00)
        if ($currentHour == '18') {
            $url = base_url('admin/mark-absentees');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch); // ignore the result, just trigger it
            curl_close($ch);
        }
    }
    // public function accountManagement()
    // {
        
    //     $adminModel = new \App\Models\Admin_Model();
    //     $classModel = new \App\Models\ClassModel();
    //     $profilepicModel = new \App\Models\AdminStaffModel();
    //     $notificationmodel = new \App\Models\NotificationModel();

    //      if (!session()->get('user_id')) {
    //     return redirect()->to('/login');
    //     }

    //     $userId = session()->get('user_id');


    //     $data = [
    //         'students' => $adminModel->getEnrolledStudentsWithAdmission(),
    //         'classes'  => $classModel->findAll(),
    //         'profilepic' => $profilepicModel ->profilepic(),
    //         'notification' => $notificationmodel -> adminNotif($userId),
    //         'unread_count' => $notificationmodel->adminNotifCount(),


    //     ];

    //     return view('admin/account-management', $data);
    // }
    public function accountManagement()
    {
        
        $adminModel = new \App\Models\Admin_Model();
        $classModel = new \App\Models\ClassModel();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $notificationmodel = new \App\Models\NotificationModel();

         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');


        $data = [
            'users' => $adminModel->getAllUsers(),
            'classes'  => $classModel->findAll(),
            'profilepic' => $profilepicModel ->profilepic(),
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
             'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,



        ];

        return view('admin/account-management', $data);
    }


    public function accountManagementPost()
    {
        helper('url');

        $post = $this->request->getPost();
        log_message('info', 'Guardian Update POST data: ' . json_encode($post));

        $pictureFile = $this->request->getFile('profile_pic');
        $newName = null;

        // Handle profile picture upload
        if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {
            $newName = $pictureFile->getRandomName();
            $pictureFile->move('public/assets/profilepic', $newName);
            log_message('info', "Uploaded new guardian profile picture: {$newName}");
        }

        $user_id = $post['user_id'] ?? null;
        $guardian_id = $post['id'] ?? null;
        $existingPicture = $post['existingPicture'] ?? null;

        if (!$user_id || !$guardian_id) {
            log_message('error', 'Missing user_id or guardian_id in accountManagementPost');
            return redirect()->back()->with('error', 'Missing required data.');
        }

        // Keep old picture if no new upload
        $profilePic = $newName ?: $existingPicture;

        // Update guardians table
        $guardianData = [
            'first_name'   => $post['first_name'],
            'middle_name'  => $post['middle_name'],
            'last_name'    => $post['last_name'],
            'relationship' => $post['relationship'],
            'contact_number' => $post['contact_number'],
            'email'        => $post['email'],
            'municipality' => $post['municipality'],
            'barangay'     => $post['barangay'],
            'street'       => $post['street'],
            'profile_pic'  => $profilePic,
        ];

        $updatedGuardian = $this->db->table('guardiansAccount')
            ->where('id', $guardian_id)
            ->update($guardianData);

        log_message('info', "Updated guardians_account table for guardian_id {$guardian_id}: " . ($updatedGuardian ? 'Success' : 'Failed'));

        // Update users table (sync email)
        if (!empty($post['email'])) {
            $updatedUser = $this->db->table('users')
                ->where('id', $user_id)
                ->update(['email' => $post['email']]);

            log_message('info', "Updated users table for user_id {$user_id}: " . ($updatedUser ? 'Success' : 'Failed'));
        }

        session()->setFlashdata('success', 'Guardian information updated successfully.');
        return redirect()->to('/admin-accountManagement');
    }

    private function generateUniqueUsername(string $firstname): string
    {
        $userModel = new \App\Models\UserModel();

        // base username = first name + random number
        $baseUsername = strtolower(preg_replace('/\s+/', '', $firstname));
        $username = $baseUsername;
        $counter  = 1;

        // loop hanggang makahanap ng unique
        while ($userModel->where('username', $username)->countAllResults() > 0) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function addTeacher()
    {
    

        $userModel    = new \App\Models\UserModel();
        $teacherModel = new \App\Models\Teacher_Model();

        
        // DEFAULT profile picture (must exist in assets/profilepic)
        $newName = '1752420767_9459efda9027940a87c4.webp';

        // Get uploaded file
        $pictureFile = $this->request->getFile('teacher_picture');

        // Check if a file was uploaded correctly
        if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {

            // Generate random filename
            $newName = $pictureFile->getRandomName();

            // Move file to public/assets/profilepic
            $pictureFile->move(FCPATH . 'assets/profilepic', $newName);
        }

        

        $firstname          = $this->request->getPost('first_name');
        $middlename         = $this->request->getPost('middle_name');
        $lastname           = $this->request->getPost('last_name');
        $email              = $this->request->getPost('email');
        $contactnumber      = $this->request->getPost('contact_number');
        $password           = $this->request->getPost('password');
        $confirmPassword    = $this->request->getPost('confirm_password');
        $teacher_department = $this->request->getPost('teacher_department');
        $specialization     = $this->request->getPost('specialization');

        log_message('info', 'Starting addTeacher: {email}', ['email' => $email]);

        // Password check
        if ($password != $confirmPassword) {
        log_message('error', 'Password mismatch for {email}', ['email' => $email]);
        log_message('error', 'Passwords provided: pass="{pass}" confirm="{confirm}"', [
            'pass'    => $password,
            'confirm' => $confirmPassword
        ]);
        session()->setFlashdata('error', 'Password not Match.');
        return redirect()->to('/admin-accountManagement')->with('error', 'Password not Match');
        }


        try {
            $username     = $this->generateUniqueUsername($firstname);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Save to users table
            $userData = [
                'username'      => $username,
                'password_hash' => $password, 
                'email'         => $email,
                'role'          => 'teacher',
            ];

            $userModel->insert($userData);
            $userId = $this->db->insertID();

            log_message('info', 'User inserted with ID: {id}', ['id' => $userId]);

            // Save to teachers table
            $teacherData = [
                'user_id'            => $userId,
                'first_name'         => $firstname,
                'middle_name'        => $middlename,
                'last_name'          => $lastname,
                'email'              => $email,
                'contact_number'     => $contactnumber,
                'profile_pic'        => $newName,
                'teacher_department' => $teacher_department,
                'specialization'     => $specialization,
            ];

            $teacherModel->insert($teacherData);
            if ($email) {
            $emailService = \Config\Services::email();

            $emailService->setTo($email);
            $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
            $emailService->setSubject('Teacher Account Created');
            $emailService->setMailType('html');
            $emailService->setMessage("
                <p>Dear " . esc($firstname) . " " . esc($lastname) . ",</p>
                <p>Your teacher account has been successfully created.</p>
                <p><strong>Username:</strong> {$username}</p>
                <p><strong>Password:</strong> {$password}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Department:</strong> {$teacher_department}</p>
                <p><strong>Specialization:</strong> {$specialization}</p>
                <p>You may now log in to the system using your credentials.</p>
                <p>Please update your account immediately</p>
                <p>– School Admin</p>
            ");

            if (!$emailService->send()) {
                log_message('error', 'Teacher add email failed: ' . print_r($emailService->printDebugger(['headers']), true));
            } else {
                log_message('info', 'Teacher add email sent to: {email}', ['email' => $email]);
            }
        }
            log_message('info', 'Teacher record inserted for user ID: {id}', ['id' => $userId]);
            session()->setFlashdata('success', 'Teacher added.');
            return redirect()->to('/admin-accountManagement')->with('success', 'Teacher added');
        } catch (\Exception $e) {
            log_message('error', 'Error in addTeacher: {message}', ['message' => $e->getMessage()]);
            session()->setFlashdata('error', 'Failed to add teacher.');
            return redirect()->to('/admin-accountManagement')->with('error', 'Failed to add teacher');
        }
    }





   //admin-announcement
   public function announcement()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
         $userId = session()->get('user_id');
        $announcementModel = new \App\Models\AnnouncementModel();
        $profilepicModel = new \App\Models\AdminStaffModel();
        // $announcements = $announcementModel->activeAnnouncement($userId); activeAnnouncementOpening
        
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();
        $announcements = $announcementModel->activeAnnouncementOpening($userId, $openingId);


         

       
       

        $data = [
            'profilepic' => $profilepicModel ->profilepic(),
            'announcements' => $announcements,
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
            'countAnnoucment' => $notificationmodel ->countAnnoucment($userId),
             'unread_announcement' =>  $notificationmodel -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel -> adminNotif($userId),
            'user_id'             => $userId,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
            
        ];

        return view('admin/announcement', $data);
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
        $openingId = session()->get('opening_id');


        $model->saveAnnouncementOpening($title, $message,$userId,$openingId);

        
        $notification = new \App\Models\NotificationModel();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $students = $builder->whereIn('role', ['parent', 'teacher'])->get()->getResult();

       

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

        return redirect()->to('/admin-announcement')->with('success', 'Announcement posted');
    }
    public function deleteAnnouncement($id)
    {
        $model = new AnnouncementModel();
        $model->update($id, ['status' => 'Deactive']);

        return redirect()->to(base_url('/admin-announcement'))->with('success', 'Announcement deactivated successfully.');
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
        return redirect()->to(base_url('/admin-announcement'))->with('success', 'Announcement updated successfully.');
    }


  
    public function payment()
    {
        $paymentModel      = new \App\Models\PaymentModel();
        $profilepicModel   = new \App\Models\AdminStaffModel();
        $notificationModel = new \App\Models\NotificationModel();
        $parentModel       = new \App\Models\GuardiansAccountModel();
        $admissionModel    = new \App\Models\Admission_Model();
        $reportModel = new \App\Models\Admin_Model();
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
                if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();


        // Get all parents
        // $parents = $parentModel->AllParents();
        $parents = $parentModel->AllParentsOpening($openingId);
        // Attach children info and their payment history
            foreach ($parents as &$parent) {
                $children       = $admissionModel->getStudentWithStudentInfoToPayment($parent['user_id']);
                $paymentHistory = $paymentModel->getChildPaymentHistory($parent['user_id']);
                $paymentHistorypyment = $paymentModel->getChildPaymentHistoryPaymentNew($parent['user_id']);
                $childData = [];
                foreach ($children as &$child) {
                    $childPayments = array_filter($paymentHistorypyment, function($p) use ($child) {
                        return $p['admission_id'] == $child['admission_id'];
                    });

                    $totalPaid = array_sum(array_column($childPayments, 'amount_paid'));
                    $totalFee  = isset($childPayments[0]['total_amount']) ? $childPayments[0]['total_amount'] : 0;
                    $remaining = $totalFee - $totalPaid;

                    $childData[] = [
                        'full_name'       => $child['full_name'],
                        'admission_id'    => $child['admission_id'],
                        'user_id'         => $child['user_id'],
                        'payment_history' => $childPayments,
                        'total_paid'      => $totalPaid,
                        'total_fee'       => $totalFee,
                        'remaining'       => $remaining
                    ];

                    // Log each child in CodeIgniter log
                    log_message('debug', 'Child Payment Debug: ' . print_r($childData[count($childData)-1], true));
                }

                $parent['children'] = $childData;

                // Log parent info
                log_message('debug', 'Parent Debug: ' . print_r($parent, true));
            }



        $data = [
             //  'reports' => $reportModel->generateReport(),generateReportOpening
            'profilepic'   => $profilepicModel->profilepic(),
            'parents'      => $parents,
            'notification' => $notificationModel->adminNotif($userId),
            'unread_count' => $notificationModel->adminNotifCount(),
             'reports' => $reportModel->generateReportOpening($openingId),
           
              'unread_announcement' =>  $notificationModel -> adminNotifCountAll($userId),
            'notification'        => $notificationModel -> adminNotif($userId),
            'user_id'             => $userId,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,


        ];

        return view('admin/payment', $data);
    }






    public function openAdmission()
    {
       
        $openadmission = new \App\Models\OpeningModel();
        $profilepicModel = new \App\Models\AdminStaffModel();
         $notificationModel = new \App\Models\NotificationModel();
         $data=[
            
            'admissions' =>  $openadmission->openaddmision(),
            'profilepic' => $profilepicModel ->profilepic(),
            'unread_count' => $notificationModel->adminNotifCount(),
            
         ];

        return view('admin/open-admission', $data);
    }
    
    public function adminProfile()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $userModel = new \App\Models\UserModel();
        $email = $userModel->email();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $profilepic = $profilepicModel->profilepic();
        


        // Mag-log sa app/Logs/log-XXXX.php
        log_message('debug', 'Email fetched: ' . $email);

        $data = [
            'email' => $email,
            'profilepic' => $profilepic
        ];

        return view('admin/admin-profile', $data);
    }
    //updateprofile
    public function adminProfilepost()
    {
        $userModel = new \App\Models\UserModel();
        $staffModel = new \App\Models\AdminStaffModel();

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

        // Get email from POST
        $newEmail = $this->request->getPost('email');

        // Update email in users table
        $userModel->update($userId, ['email' => $newEmail]);

        // Handle profile image
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/assets/profilepic', $newName); // moves to public/assets/img
            $staffModel->where('user_id', $userId)->set(['profilepic' => $newName])->update();
        }

        return redirect()->to('/adminProfile')->with('success', 'Profile updated.');
    }




    public function save()
    {
        $openingModel    = new OpeningModel();
        $classModel      = new ClassModel();
         $enrollmentModel = new \App\Models\EnrollmentModel();

        $opendate  = $this->request->getPost('openingDate');
        $closedate = $this->request->getPost('closingDate');
        $classes   = $this->request->getPost('classes');

        $openYear  = date('Y', strtotime($opendate));
        $closeYear = date('Y', strtotime($closedate));
        $schoolYear = $openYear . '-' . $closeYear;

        // Create new opening
        $openingId = $openingModel->insert([
            'opendate'    => $opendate,
            'closedate'   => $closedate,
            'school_year' => $schoolYear
        ]);

       $classModel->set(['status' => 'inactive'])
           ->where('status', 'active')
           ->update();

        $enrollmentModel->set(['status' => 'finished'])
                        ->where('status !=', 'finished')
                        ->update();

        // Insert new class list with ACTIVE status
        foreach ($classes as $class) {
            $classModel->insert([
                'class_id'        => $openingId,
                'classname'       => $class['name'],
                'tuitionfee'      => $class['fee'],
                'monthly_payment' => $class['monthlyfee'],
                'miscellaneous'   => $class['miscellaneous'],
                'status'          => 'active'
            ]);
        }

        session()->setFlashdata('success', 'Successfully Saved');
        return redirect()->to('/admin-dashboard');
    }




    public function settings()
    {   
        
        $model = new \App\Models\CustomizeThemeModel();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $openingModel = new \App\Models\OpeningModel();
        $notificationmodel = new \App\Models\NotificationModel();

        $settings = $model->getSettings();
        $profilepic = $profilepicModel->profilepic();
        $getStatus = $openingModel ->getStatus();

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $data = [

            'settings' => $settings,
            'profilePic' =>$profilepic,
            'status' => $getStatus,
             'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount()
        ];

        return view('admin/settings', $data);
    }

    public function settingPost()
    {
        $sms = $this->request->getPost('sms') ? 1 : 0;
        $email = $this->request->getPost('email') ? 1 : 0;
        $admissionStatus = $this->request->getPost('admission_status') ? 'open' : 'closed';
       

        $model = new \App\Models\CustomizeThemeModel();
        $admissionModel = new \App\Models\OpeningModel();
        $latest = $admissionModel->orderBy('id', 'DESC')->first();
        $existing = $model->first(); 

        if ($existing) {
            $model->update($existing['id'], [
                'sms_enabled' => $sms,
                'email_enabled' => $email
            ]);
        } else {
            $model->save([
                'sms_enabled' => $sms,
                'email_enabled' => $email
            ]);
        }
        if ($latest) {
        $admissionModel->update($latest['id'], [
            'status' => $admissionStatus
        ]);
    }

        return redirect()->to('admin-settings');
    }


    public function resetPasswordPost()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate new passwords
        if ($newPassword !== $confirmPassword) {
             session()->setFlashdata('error', 'New passwords do not match.');
            return redirect()->to('/adminProfile')->with('error', 'New passwords do not match.');
        }

        $userModel = new \App\Models\UserModel(); // Replace with your actual user model
        $user = $userModel->find($userId);

        if (!$user || $currentPassword !== $user['password_hash']) {
             session()->setFlashdata('error', 'Current password is incorrect.');
        return redirect()->to('/adminProfile')->with('error', 'Current password is incorrect.');
        }

        // Hash and update password
        $userModel->update($userId, [
            'password_hash' => $newPassword
        ]);

        session()->setFlashdata('success', 'Password changed successfully.');
        return redirect()->to('/adminProfile')->with('success', 'Password changed successfully.');
    }


   
    public function printStudent($admissionId)
    {
        $admissionModel = new \App\Models\Admission_Model();
        $student = $admissionModel->getStudent($admissionId);

        if (!$student) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Student not found.');
        }

       
        if (is_array($student)) $student = (object) $student;

        return view('admin/print-student', [
            'student' => $student,
            'isPdf'   => false, 
        ]);
    }

    public function generateId($admissionId)
    {
        $admissionModel = new \App\Models\Admission_Model();
        $student = $admissionModel->getStudentWithStudentInfo($admissionId);


        if (!$student) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Student not found');
        }
        $data=[
            'student' => $student
        ];

        return view('admin/id-template', $data);
    }
    public function studentDetails($userId)
    {
        $model = new \App\Models\Admin_Model();
        $data = $model->getGuardianWithUserId($userId);
        return $this->response->setJSON($data);
    }

    public function teacherDetails($userId)
    {
        $model = new \App\Models\Admin_Model();
        $data = $model->getTeacher($userId);
        return $this->response->setJSON($data);
    }
    public function teacherpdatePost()
{
    helper(['url', 'form']);

    $post = $this->request->getPost();
    log_message('info', 'Received teacher update data: ' . json_encode($post));

    $user_id = $post['user_id'] ?? null;
    if (!$user_id) {
        log_message('error', 'Missing user_id in teacherpdatePost');
        return redirect()->back()->with('error', 'User ID missing.');
    }

    // Handle profile picture upload
    $pictureFile = $this->request->getFile('profilepicteacher');
    $profilePic = $post['existingPictureTeacher'] ?? null;

    if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {
        $newName = $pictureFile->getRandomName();
        $pictureFile->move('public/assets/profilepic', $newName);
        $profilePic = $newName;
        log_message('info', "Profile picture updated for user_id {$user_id}: {$newName}");
    }

    // Prepare teacher update data
    $teacherData = [
        'first_name'        => trim($post['first_name']),
        'middle_name'       => trim($post['middle_name']),
        'last_name'         => trim($post['last_name']),
        'birthday'          => trim($post['birthday']),
        'gender'            => trim($post['gender']),
        'civil_status'      => trim($post['civil_status']),
        'contact_number'    => trim($post['contact_number']),
        'email'             => trim($post['email']),
        'municipality'      => trim($post['municipality']),
        'barangay'          => trim($post['barangay']),
        'street'            => trim($post['street']),
        'specialization'    => trim($post['specialization']),
        'teacher_department'=> trim($post['teacher_department']),
        'profile_pic'       => $profilePic,
    ];

    // Update teachers table
    $updatedTeacher = $this->db->table('teachers')
        ->where('user_id', $user_id)
        ->update($teacherData);

    log_message('info', "Teacher table update for user_id {$user_id}: " . ($updatedTeacher ? 'Success' : 'Failed'));

    // Update users table email
    if (!empty($post['email'])) {
        $this->db->table('users')
            ->where('id', $user_id)
            ->update(['email' => trim($post['email'])]);
    }

    session()->setFlashdata('success', 'Teacher information successfully updated.');
    return redirect()->to('/admin-accountManagement');
}



    public function studentpay($admissionId)
    {
         $session = session();
        $adminModel        = new \App\Models\Admin_Model();
        $profilepicModel   = new \App\Models\AdminStaffModel();
        $class_model       = new \App\Models\ClassModel(); 
        $notificationmodel = new \App\Models\NotificationModel();  
        $admissionModel    = new \App\Models\Admission_Model();
        $TuitionPlanModel  = new \App\Models\TuitionPlanModel();
        
        $students = $admissionModel->getStudent($admissionId);
         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        
        
        $students = $admissionModel->getStudent($admissionId);
        $userId = session()->get('user_id');
        log_message('debug', 'user_id: ' . $userId);
        
        $data = [
            
            'classes'      => $class_model->findAll(),
            'students'     => $students,
            'profilepic'   => $profilepicModel ->profilepic(),
            'notification' => $notificationmodel -> adminNotif($userId),
            'unread_count' => $notificationmodel->adminNotifCount(),
            
        ];
        

        return view('admin/paycash',$data );
    }
    public function paymentMiscCash($parentID)
    {
        $paymentModel      = new \App\Models\PaymentModel();
        $profilepicModel   = new \App\Models\AdminStaffModel();
        $notificationModel = new \App\Models\NotificationModel();
        $parentModel       = new \App\Models\GuardiansAccountModel();
        $admissionModel    = new \App\Models\Admission_Model();
        $class_model       = new ClassModel();


        $guardianModel      = new GuardiansAccountModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();


        
        $user_id = session()->get('user_id');
       
        $studentinfo   = $guardianModel     -> getGuardiandata($parentID);
        $paymentMischistory   = $paymentModel     -> paymentMischistory($parentID);
        // $childrens           = $admissionModel     -> getChildrenByGuardianWithRemainingMisc($parentID);
         $childrens           = $admissionModel     -> getChildrenByGuardianWithRemainingMiscOpening($parentID, $openingId);

         $userId = session()->get('user_id');

        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $data = [
            'Mischistory'  => $paymentMischistory,
            'profilepic'   => $profilepicModel->profilepic(),
            'student'      => $studentinfo,
            'notification' => $notificationModel->adminNotif($userId),
            'unread_count' => $notificationModel->adminNotifCount(),
            'childrens'   => $childrens,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

            
        ];

        return view('admin/payMiscCash', $data);
    }
    public function paymentTuitioncCash($parentID)
    {
        $paymentModel      = new \App\Models\PaymentModel();
        $profilepicModel   = new \App\Models\AdminStaffModel();
        $notificationModel = new \App\Models\NotificationModel();
        $parentModel       = new \App\Models\GuardiansAccountModel();
        $admissionModel    = new \App\Models\Admission_Model();


        $guardianModel      = new GuardiansAccountModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $openingModel = new OpeningModel();
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();

        
        
        $user_id = session()->get('user_id');
        $studentinfo   = $guardianModel     -> getGuardiandata($parentID);
       
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $scheduleModel = new \App\Models\PaymentScheduleModel();
        $childrens           = $admissionModel     -> getChildrenByGuardianopening($parentID, $openingId);
         // Check if plan_id 4 exists
        $hasPlan4 = $paymentModel->where('user_id', $parentID)
                                ->where('plan_id', 4)
                                ->countAllResults();

        $payment = [];
        if ($hasPlan4 == 0) {
            // Only fetch plan_id 2 payments if no plan_id 4 exists
            // $payment = $paymentModel->getPaymentForTuition($parentID);
            $payment = $paymentModel->getPaymentForTuitionOpening($parentID, $openingId);
        }
        
        // $schedulesRaw = $scheduleModel->getPaymentScheduleByUser($parentID);
        $schedulesRaw = $scheduleModel->getPaymentScheduleByUserOpening($parentID, $openingId);
        $paymentMischistory   = $paymentModel     -> paymentTuitionhistorOpening($parentID,4,$openingId);

        // Group schedules by child
        $schedules = [];
        foreach ($schedulesRaw as $row) {
            $schedules[$row['admission_id']]['full_name'] = $row['full_name'];
            $schedules[$row['admission_id']]['data'][] = $row;
        }
       
        

       
        

        $data = [
            'Mischistory'  => $paymentMischistory,
            'profilepic'   => $profilepicModel->profilepic(),
            'student'      => $studentinfo,
            'notification' => $notificationModel->adminNotif($userId),
            'unread_count' => $notificationModel->adminNotifCount(),
            'schedules'    => $schedules,
            'childrens'    => $childrens,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

        ];

        return view('admin/payTuitionCash', $data);
    }
    public function markAsRead($userId)
    {
        $notifModel = new \App\Models\NotificationModel();

        $notifModel->where('user_id', $userId)
                ->set('is_read', 1)
                ->update();

        return redirect()->to(previous_url()); // Go back to the same page
    }

    // AdminController.php
    public function printReport()
    {
        $json = $this->request->getJSON(true);
        $data['reports'] = $json['data'] ?? [];
        return view('admin/print_payment_report', $data);
    }

    public function studentEditPostEnrolled()
    {
        helper('url');

        $post = $this->request->getPost();
        $admission_id = $this->request->getPost('admission_id');
        
        $pictureFile = $this->request->getFile('picture');
        $newName = null;
        if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {
            $newName = $pictureFile->getRandomName();
            $pictureFile->move('public/assets/profilepic', $newName);
        }
        $psa = $this->request->getFile('psa');

        $newNamepsa = null;
        if ($psa && $psa->isValid() && !$psa->hasMoved()) {
            $newNamepsa = $psa->getRandomName();
            $psa->move('public/assets/psa', $newNamepsa);
        }
         
       
        $admissionData = [
            
            'first_name'        => $post['first_name'],
            'middle_name'       => $post['middle_name'],
            'last_name'         => $post['last_name'],
            'nickname'          => $post['nickname'],
            'birthday'          => $post['birthday'],
            'age'               => $post['age'],
            'nationality'       => $post['nationality'],
            'gender'            => $post['gender'],
            'father_name'       => $post['father_name'],
            'father_occupation' => $post['father_occupation'],
            'mother_name'       => $post['mother_name'],
            'mother_occupation' => $post['mother_occupation'],
            'class_applied'     => $post['class_level'],
            'contact_number'    => $post['contact_number'],
            'municipality'      => $post['municipality'],
            'barangay'          => $post['barangay'],
            'street'            => $post['street'],
            'email'             => $post['email'],
        ];
        $suudentData = [
            
            'first_name'        => $post['first_name'],
            'middle_name'       => $post['middle_name'],
            'last_name'         => $post['last_name'],
            
            'birthday'          => $post['birthday'],
            'class_level'     => $post['class_level'],
        ];
    
        if ($newName !== null) {
        $admissionData['picture'] = $newName;
        }
        if ($newNamepsa !== null) {
        $admissionData['psa'] = $newNamepsa;
        }
         if ($newName !== null) {
        $suudentData['profile_pic'] = $newName;
        }
        
        $updatedAdmissions = $this->db->table('admissions')
            ->where('admission_id', $admission_id)
            ->update($admissionData);
        $updatedStudent = $this->db->table('students')
            ->where('user_id', $admission_id)
            ->update($suudentData);
    
        session()->setFlashdata('success', 'Student information updated!');
        return redirect()->to('admin-enrolled')->with('success', 'Student information updated!');
    }
    public function AddAdminAccount()
    {
       
        $members_model = new \App\Models\Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
         $notificationModel = new \App\Models\NotificationModel();
        
        $data=[
              'members' => $members_model->alldisapproved(),
            'profilepic' => $profilepicModel ->profilepic(),
             'unread_count' => $notificationModel->adminNotifCount(),
        ];
        
        return view('admin/add-admin-account',$data);
    }
    public function AddAdminAccountPost()
    {
        $userModel        = new \App\Models\UserModel();
        $adminStaffModel  = new \App\Models\AdminStaffModel();

        // Handle profile picture upload
        $pictureFile = $this->request->getFile('profile_pic');
        $newName = null;

        if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {
            $newName = $pictureFile->getRandomName();
            $pictureFile->move('public/assets/profilepic', $newName);
        }

        // Collect form inputs 
       
        $username        = $this->request->getPost('username');
        $firstname        = $this->request->getPost('first_name');
        $middlename       = $this->request->getPost('middle_name');
        $lastname         = $this->request->getPost('last_name');
        $email            = $this->request->getPost('email');
        $password         = $this->request->getPost('password');
        $confirmPassword  = $this->request->getPost('confirm_password');


        log_message('info', 'Adding new admin account: {email}', ['email' => $email]);

        // ------------------------------------------------------
        // ✔ VALIDATIONS
        // ------------------------------------------------------

        // 1. Check for empty email
        if (!$email) {
            return redirect()->back()->withInput()->with('error', 'Email is required.');
        }

        // 2. Duplicate email check
        $existing = $userModel->where('email', $email)->first();
        if ($existing) {
            session()->setFlashdata('error', 'Email already exists..');
            return redirect()->back()->withInput()->with('error', 'Email already exists.');
        }
        $existing = $userModel->where('username', $username)->first();
        if ($existing) {
            session()->setFlashdata('error', 'Username already exists..');
            return redirect()->back()->withInput()->with('error', 'Username already exists..');
        }

        // 3. Password mismatch
        if ($password !== $confirmPassword) {
            session()->setFlashdata('error', 'Password and Confirm Password do not match..');
            return redirect()->back()->withInput()->with('error', 'Password and Confirm Password do not match.');
        }

        try {
            // Generate username
            

            // Correct password hashing
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user record
            $userData = [
                'username'      => $username,
                'password_hash' => $password,
                'email'         => $email,
                'role'          => 'admin',
            ];

            $userModel->insert($userData);
            $userId = $userModel->getInsertID();

            log_message('info', 'Admin user inserted with ID: {id}', ['id' => $userId]);

            // Insert admin/staff record
            $adminData = [
               
                'firstname'   => $firstname,
                'middlename'  => $middlename,
                'lastname'    => $lastname,
               
                'role'         => 'semi-admin',
                 'user_id'      => $userId,
                'profilepic'  => $newName,
            ];

            $adminStaffModel->insert($adminData);
            session()->setFlashdata('success', 'Admin account added successfully.');

            return redirect()->to('admin-settings')->with('success', 'Admin account added successfully.');

        } catch (\Exception $e) {

            log_message('error', 'Error adding admin: {msg}', ['msg' => $e->getMessage()]);
            session()->setFlashdata('error', 'An unexpected error occurred. Please try again.!');
            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
    public function adminDetails()
    {
        
        $members_model = new \App\Models\Admin_Model();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $AuditLogModel = new \App\Models\AuditLogModel();
                if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        log_message('debug', 'user_id: ' . $userId);

        
        $data=[
            'members'           => $members_model         ->alldisapproved(),
            'profilepic'          => $profilepicModel     ->profilepic(),
            'notification'       => $notificationmodel    -> adminNotif($userId),
            'unread_count'        => $notificationmodel   ->adminNotifCount(),
            'notification'       => $notificationmodel    -> adminNotif($userId),
            'unread_count'        => $notificationmodel   ->adminNotifCount(),
            'unread_announcement' =>  $notificationmodel  -> adminNotifCountAll($userId),
            'notification'        => $notificationmodel   -> adminNotif($userId),
            'user_id'             => $userId,
            'adminAccounts'       => $profilepicModel     ->getAdminAccounts(),
            'auditLogs'          => $AuditLogModel       ->getAuditLogs(),
        ];
        
        return view('admin/auditlog',$data);
    }
    public function getAdminDetails($user_id)
    {
        $adminModel = new \App\Models\AdminStaffModel();
        $admin = $adminModel->where('user_id', $user_id)->first();


        if($admin){
            return $this->response->setJSON([
                'user_id'   => $admin['user_id'],
                'firstname' => $admin['firstname'],
                'middlename'=> $admin['middlename'],
                'lastname'  => $admin['lastname'],
                'status'    => $admin['status']
            ]);
        } else {
            return $this->response->setJSON(['error' => 'Admin not found']);
        }
    }
    
    public function editAdmin($user_id)
    {
        $model = new \App\Models\AdminStaffModel();

        $admin = $model->where('user_id', $user_id)->first();
        if(!$admin){
            return $this->response->setJSON(['success' => false, 'message' => 'Admin not found']);
        }

        $updateData = [
                'firstname' => $this->request->getPost('firstname'),
                'middlename' => $this->request->getPost('middlename'),
                'lastname' => $this->request->getPost('lastname'),
                'status' => $this->request->getPost('status'),
        ];

       

        $model->where('user_id', $user_id)->set($updateData)->update();

        return $this->response->setJSON(['success' => true]);
    }






    
}


    



