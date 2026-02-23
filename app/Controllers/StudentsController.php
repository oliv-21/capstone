<?php

namespace App\Controllers;
use App\Models\GuardianModel;
use App\Models\StudentModel;
use App\Models\Admin_Model;
use App\Models\ClassModel;
use App\Models\PaymentModel;
use App\Models\GuardiansAccountModel;

use App\Models\Attendance_Model;
use App\Models\NotificationModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use CodeIgniter\HTTP\RedirectResponse;

class StudentsController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function DasboardUser(): string
    {  
        //123 

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $parentInfo = new \App\Models\GuardiansAccountModel();
        $TeacherPhotosModel = new \App\Models\TeacherPhotosUploadModel();
        $notificationmodel = new \App\Models\NotificationModel();

        $announcements = $announcementModel->activeAnnouncementstudent();
       
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
         $highlight    = $TeacherPhotosModel ->highlightPhotoPerchild($userId);
         $notificationmodel->markAllAsReadAnnoucment($userId);
         $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);
        


        $data = [
            'highlight'           => $highlight,
            'announcements'       => $announcements,
            'student'             => $studentinfo,
            'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($userId),
            'notification'        => $notificationmodel -> StudentNotification($userId),
            'parentData'          => $parentdata,
        ];

        return view('user/Announcements',$data);
    }
    public function GuardianSetup(): string|RedirectResponse
    {
        if (!session()->get('child_id')) {
           return redirect()->to('/login');

        }
        $userId = session()->get('child_id');
        $studentModel = new \App\Models\StudentModel();
        $parentInfo = new \App\Models\GuardiansAccountModel();
        $guardianModel = new \App\Models\GuardianModel();
        $notificationmodel = new \App\Models\NotificationModel();



        $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);
        $studentinfo = $studentModel ->studentInfo();
        $studentprofile = $studentModel ->studentProfile();
       

        $data = [
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'guardians' =>$guardianModel->displayAllguardian(),
             'studentprofile'=>$studentprofile,
              'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($userId),
            'notification'        => $notificationmodel -> StudentNotification($userId),
        ];
        return view('user/Guardian-setup',$data);
    }
    public function GuardianSetupPost(): \CodeIgniter\HTTP\RedirectResponse
    {
        $session = session();
        helper(['form', 'url']);

        log_message('info', 'GuardianSetupPost called.');
        $request = service('request');

        

        // Validation rules
        $rules = [
           
            'relationship' => 'required|min_length[3]|max_length[100]',
            'photo' => [
                'uploaded[photo]',
               'mime_in[photo,image/jpg,image/jpeg,image/png,image/gif,image/pjpeg,image/webp]',
                'max_size[photo,2048]',
            ],
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed in GuardianSetupPost: ' . json_encode($this->validator->getErrors()));
           session()->setFlashdata('error', 'Validation failed in GuardianSetupPost: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        
        $relationship = $request->getPost('relationship');

    
        if ($relationship === 'Other') {
            $relationship = $request->getPost('other_relationship');
        }
        $firstName = $this->request->getPost('Firstname');
        $middleName = $this->request->getPost('Middlename');
        $lastName = $this->request->getPost('Lastname');
        
        $photoFile = $this->request->getFile('photo');

        

       
        if ($photoFile->isValid() && !$photoFile->hasMoved()) {
            $newPhotoName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/assets/img', $newPhotoName);
            log_message('info', "Photo uploaded successfully: {$newPhotoName}");
        } else {
            log_message('error', 'Photo upload failed in GuardianSetupPost.');
            
            return redirect()->back()->withInput()->with('error', 'Photo upload failed.');
        }

        $userId = $session->get('child_id');
        $guardianId = uniqid(); 

        $qrText = "Guardian ID: $guardianId";

        log_message('info', "Generating QR code for Guardian ID: {$guardianId}");

        // Use enum case for error correction level (PHP 8.1+)
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->encoding(new Encoding('UTF-8'))
           ->errorCorrectionLevel(ErrorCorrectionLevel::Low)

            ->size(300)
            ->margin(10)
            ->build();

        // Save QR code to file
        $qrCodeDir = ROOTPATH . 'public/assets/qrcodes/';
        if (!is_dir($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
            log_message('info', "Created QR code directory: {$qrCodeDir}");
        }
        $qrCodeFile = $qrCodeDir . $guardianId . '.png';
        $result->saveToFile($qrCodeFile);
        log_message('info', "QR code saved to file: {$qrCodeFile}");

        // Prepare data array for DB insert
        $data = [
            'user_id' => $userId,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'relationship' => $relationship,
            'photo' => $newPhotoName,
            'qr_code' => $guardianId . '.png',
        ];

        $guardianModel = new GuardianModel();

        // Save to DB
        $insertId = $guardianModel->saveGuardian($data);

        if ($insertId === false) {
            log_message('error', 'Failed to save guardian data to database.');
            session()->setFlashdata('error', 'Failed to save data. Please try again or report to admin');
            return redirect()->back()->withInput()->with('error', 'Failed to save data.');
        }

        log_message('info', "Guardian data saved successfully with ID: {$insertId}");

        return redirect()->to('/student-guardiansetup')->with('success', 'Authorized person added successfully.');
    }

    //deleted gurdian
    public function GuardianSetupDelete($id = null): RedirectResponse
    {
        $guardianModel = new \App\Models\GuardianModel();

        if ($id && $guardianModel->find($id)) {
            $guardianModel->delete($id);
            return redirect()->to('student-guardiansetup')->with('success', 'Removed successfully.');
        }

        return redirect()->to('student-guardiansetup')->with('error', 'Guardian not found.');
    }


    public function paymentInfo()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $user_id = session()->get('user_id');
        $studentModel = new \App\Models\StudentModel();
        $paymentModel = new \App\Models\PaymentModel();
       
        $studentinfo = $studentModel ->studentInfo();
        $payment = $paymentModel ->paymentUser();
        $paymenthistory = $paymentModel ->paymenthistory();
        $remainingBalance = $paymentModel ->remainingBalance($user_id);

        
        
        $data = [
             'student' => $studentinfo,
             'payment' => $payment,
             'paymenthistorys' => $paymenthistory,
            'remainingBalance' => $remainingBalance
        ];


        return view('user/payment-info',$data);
    }

    public function attendance()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $userId = session()->get('child_id');

        $studentModel = new \App\Models\StudentModel();
        $parentInfo   = new \App\Models\GuardiansAccountModel();
        $notificationmodel = new \App\Models\NotificationModel();

        // Get all data needed for attendance view
        $attendance_summary       = $studentModel->attendance_view(); 
        $attendance_with_guardian = $studentModel->attendance_withguarnianview(); 
        $studentinfo              = $studentModel->studentInfo(); 
        $parentData               = $parentInfo->getGuardianDataByAdmission($userId);

        // Convert parent data to object (for -> access in the view)
        $parentData = (object) $parentData;

        // Merge attendance data (if they are arrays)
        $data = array_merge(
            (array) $attendance_summary,
            (array) $attendance_with_guardian
        );

        $data['unread_announcement']  = $notificationmodel->countAnnoucmentStudent($userId);
        $data['notification']         = $notificationmodel->StudentNotification($userId);
        // Add other variables
        $data['studentinfo'] = $studentinfo;
        $data['parentData']  = $parentData;

        // Load the view with all data
        return view('user/attendance', $data);
    }

    



    public function resetPassword()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $studentModel = new \App\Models\StudentModel();
       
        $studentinfo = $studentModel ->studentInfo();
        


        $data = [
             'student' => $studentinfo,
             
        ];
        return view('user/resetPassword',$data);
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
            return redirect()->to('/student-resetPassword')->with('error', 'New passwords do not match.');
        }

        $userModel = new \App\Models\UserModel(); // Replace with your actual user model
        $user = $userModel->find($userId);

        if (!$user || $currentPassword !== $user['password_hash']) {
        return redirect()->to('/student-resetPassword')->with('error', 'Current password is incorrect.');
        }

        // Hash and update password
        $userModel->update($userId, [
            'password_hash' => $newPassword
        ]);


        return redirect()->to('/student-resetPassword')->with('success', 'Password changed successfully.');
    }


    public function profile()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $userId = session()->get('child_id');
        

        $studentModel = new \App\Models\StudentModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();
         
        $studentinfo = $studentModel ->studentInfo();
        $studentprofile = $studentModel ->studentProfile();
         $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);

        $data = [
             'student' => $studentinfo,
              'parentData'  => $parentdata,
             'studentprofile'=>$studentprofile,
             
        ];

        return view('user/profile',$data);
    }

    public function profileipdate()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        helper('url');

        $post = $this->request->getPost();
        log_message('info', 'accountManagementPost called with data: ' . json_encode($post));

        $user_id = $post['user_id'];
        $admission_id = $post['admission_id'];

        $profilePicFile = $this->request->getFile('profile_pic');
        $profilePic = null;

        if ($profilePicFile && $profilePicFile->isValid() && !$profilePicFile->hasMoved()) {
            $profilePic = $profilePicFile->getRandomName();
            $profilePicFile->move('public/assets/profilepic/', $profilePic);
            log_message('info', "Uploaded profile picture: {$profilePic}");
        }

        // Update students table
        $studentUpdateData = [
            'first_name'   => $post['first_name'],
            'middle_name'  => $post['middle_name'],
            'last_name'    => $post['last_name'],
            'class_level'  => $post['class_level'],
        ];

        if ($profilePic !== null) {
            $studentUpdateData['profile_pic'] = $profilePic;
        }

        $updatedStudents = $this->db->table('students')->where('user_id', $user_id)->update($studentUpdateData);
        log_message('info', "Updated students table for user_id {$user_id}: " . ($updatedStudents ? 'Success' : 'Failed'));

        
       
       

        // Update admissions table
        $updatedAdmissions = $this->db->table('admissions')->where('admission_id', $admission_id)->update([
            'first_name'        => $post['first_name'],
            'middle_name'       => $post['middle_name'],
            'last_name'         => $post['last_name'],
            'nickname'          => $post['nickname'],
            'nationality'       => $post['nationality'],
            'birthday'          => $post['birthday'],
            'age'               => $post['age'],
            'father_name'       => $post['father_name'],
            'father_occupation' => $post['father_occupation'],
            'mother_name'       => $post['mother_name'],
            'mother_occupation' => $post['mother_occupation'],
            'contact_number'    => $post['contact_number'],
            'email'             => $post['email'],
            'municipality'      => $post['municipality'],
            'barangay'          => $post['barangay'],
            'street'            => $post['street'],
        ]);

        log_message('info', "Updated admissions table for admission_id {$admission_id}: " . ($updatedAdmissions ? 'Success' : 'Failed'));
        session()->setFlashdata('success', 'Student information updated!');
        return redirect()->to('/student-dashboard')->with('success', 'Student information updated!');
    }

    

    public function chat()
    {
        return view('user/student-chat');
    }

    public function classes()
    {
        //123
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        
        $session = session();
         $userId = session()->get('child_id');
          $session->set([
            'user_id'     => $userId,
        ]);
        $notificationmodel = new \App\Models\NotificationModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();
        $studentModel = new \App\Models\StudentModel();
        $studentinfo = $studentModel ->studentInfo();
        $classroom = $studentModel ->getStudentClassroom($userId);


         $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);
       
        
       
         $data = [    
             'parentData'  => $parentdata,
             'student' => $studentinfo,
             'classroom' =>$classroom,
              'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($userId),
            'notification'        => $notificationmodel -> StudentNotification($userId),

        ];
        return view('user/classes', $data);
    }

    public function progressreport()
    {
        $studentModel = new \App\Models\StudentModel();
        $assesmentModel = new \App\Models\ProgressAssessmentModel();
        $remarkModel = new \App\Models\ProgressRemarkModel();
        $parentInfo = new \App\Models\GuardiansAccountModel();
        $notificationmodel = new \App\Models\NotificationModel();

        $studentinfo = $studentModel ->studentProfile();
        $userId = session()->get('child_id');
        $grade =$assesmentModel ->studentGrade($userId);
        $allRemarks = $remarkModel->getAllremarks($userId);
        $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);
        
        $remarksByQuarter = [];
        foreach($allRemarks as $r) {
            $remarksByQuarter[$r['quarter']] = $r;
        }

        
         $data = [    
             'student' => $studentinfo,
             'studentGrade' =>$grade,
             'remarks' => $remarksByQuarter,
            'parentData'  => $parentdata,
              'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($userId),
            'notification'        => $notificationmodel -> StudentNotification($userId),
             
        ];
        return view('user/progress-report', $data);
    }
    public function InteractiveLearning(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
           $parentInfo = new \App\Models\GuardiansAccountModel();

        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
         $notificationmodel->markAllAsReadAnnoucment($userId);
         $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);

        $data = [
            
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/interactive-learning',$data);
    }
    public function coloringGame(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();


        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');

        $notificationmodel->markAllAsReadAnnoucment($userId);
        $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);


        $data = [
            
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/coloring-game',$data);
    }
    public function shapeGame(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();


        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
         $notificationmodel->markAllAsReadAnnoucment($userId);
          $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);


        $data = [
            
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/shape-game',$data);
    }
    public function animalGame(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();

        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
       

        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
        $notificationmodel->markAllAsReadAnnoucment($userId);
        $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);

        $data = [
            
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/animal-game',$data);
    }
    public function numberGame(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
         $parentInfo = new \App\Models\GuardiansAccountModel();
        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
         $notificationmodel->markAllAsReadAnnoucment($userId);
          $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);

        $data = [
            
            'parentData'  => $parentdata,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/number-game',$data);
    }
    public function colorGame(): string
    {   

        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
       
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $parentInfo = new \App\Models\GuardiansAccountModel();

        $announcements = $announcementModel->activeAnnouncementstudent();
        $studentinfo = $studentModel ->studentInfo();
        
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $userId = session()->get('child_id');
        $notificationmodel->markAllAsReadAnnoucment($userId);
        $parentdata   = $parentInfo      -> getGuardianDataByAdmission($userId);

        $data = [
             'parentData'  => $parentdata,
           
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucment($userId),
             'notification' => $notificationmodel -> userNotif($userId),
        ];

        return view('user/color-game',$data);
    }
	
	
}
