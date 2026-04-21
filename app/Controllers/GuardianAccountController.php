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
use App\Models\PaymentScheduleModel;
use App\Models\Admission_Model;
use App\Models\OpeningModel;
use App\Models\UserModel;

use CodeIgniter\HTTP\RedirectResponse;

class GuardianAccountController extends BaseController
{   
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function mainDashboard(): string|RedirectResponse
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $admissionModel     = new Admission_Model();
        $openingModel = new OpeningModel();
		
        
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
            
        $user_id = session()->get('user_id');
        $announcements       = $announcementModel  -> activeAnnouncementstudent();
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);
        $childrens           = $admissionModel     -> getChildrenByGuardianNew($user_id,$openingId);
        $guardianDataAccount = $guardianModel      -> getGuardiandata($user_id);
        $admissioninfo       = $admissionModel     -> getStudentDataNew($user_id,$openingId);
        $status              = $admissionModel     -> getStatuses($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        $yearsRecord     = $openingModel       -> openclosedate();

        $allowedStatuses = ['Enrolled', 'Disapproved', 'Interview Failed']; // example
        $allEnrolled = true;

        foreach ($status as $s) {
            $currentStatus = $s['status'] ?? '';
            // check if current status is NOT one of the allowed ones
            if (!in_array($currentStatus, $allowedStatuses)) {
                $allEnrolled = false;
                break;
            }
        }

     
       

        $data = [
            'isAdmissionOpen'      => $isAdmissionOpen,
            'status'               => $status,
            'guardian'             => $guardianDataAccount,
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'students'             => $studentinfo,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($user_id),
            'notification'         => $notificationmodel -> userNotif($user_id),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];

        log_message('debug', 'Current User ID: ' . $user_id);
       
       return view('guardian/dashboard',$data);
    }
    
    
    public function GuardianAdmission(): string|RedirectResponse
    {
       
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $user_id = session()->get('user_id');

        $studentModel       = new StudentModel();
        $announcementModel  = new \App\Models\AnnouncementModel();
        $notificationModel  = new NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $class_model        = new \App\Models\ClassModel();
        $admissionModel     = new Admission_Model();
        
        $guardianDataAccount = $guardianModel->getGuardiandata($user_id);
        $email = $guardianModel->getEmail($user_id);
        $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);


        $data = [
            'students'             => $studentinfo,
            'childrens'            => $childrens,
            'email'                => $email,
            'guardian'             => $guardianDataAccount,
            'unread_announcement'  => $notificationModel->countAnnoucment($user_id),
            'notification'         => $notificationModel->userNotif($user_id),
            'classes'               => $class_model->getActiveClassNames()
        ];

        return view('guardian/guardianAdmission', $data);
    }
    public function AdmissionPost()
    {
        $admission_model = new \App\Models\Admission_Model();
        $notification = new \App\Models\NotificationModel();
        $openingmodel = new \App\Models\OpeningModel();
        
        if ($this->request->is('post')) {

           
            $first_name        = trim(strip_tags($this->request->getPost('first_name')));
            $middle_name       = trim(strip_tags($this->request->getPost('middle_name')));
            $last_name         = trim(strip_tags($this->request->getPost('last_name')));
            $nickname          = trim(strip_tags($this->request->getPost('nickname')));
            $nationality       = trim(strip_tags($this->request->getPost('nationality')));
            $gender            = trim(strip_tags($this->request->getPost('gender')));
            $birthday          = trim(strip_tags($this->request->getPost('birthday')));
            $age               = trim(strip_tags($this->request->getPost('age')));
            $class_applied     = trim(strip_tags($this->request->getPost('class_applied')));
            $father_name       = trim(strip_tags($this->request->getPost('father_name')));
            $father_occupation = trim(strip_tags($this->request->getPost('father_occupation')));
            $mother_name       = trim(strip_tags($this->request->getPost('mother_name')));
            $mother_occupation = trim(strip_tags($this->request->getPost('mother_occupation')));
            $contact_number    = trim(strip_tags($this->request->getPost('contact_number')));
            $email             = trim(strip_tags($this->request->getPost('email')));
            $municipality      = trim(strip_tags($this->request->getPost('municipality')));
            $barangay          = trim(strip_tags($this->request->getPost('barangay')));
            $street            = trim(strip_tags($this->request->getPost('street')));

           
           
            
            $picture = '1752420767_9459efda9027940a87c4.webp';

            // Get uploaded file
            $pictureFile = $this->request->getFile('picture');

            // Check if a file was uploaded correctly
            if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {

                // Generate random filename
                $newName = $pictureFile->getRandomName();

                // Move file to public/assets/profilepic
                $pictureFile->move(FCPATH . 'public/assets/profilepic', $picture);
            }

            $psa = $this->request->getFile('psa');
            $filepsa = null;
            if ($psa && $psa->isValid() && !$psa->hasMoved()) {
                $filepsa = $psa->getRandomName();
                $psa->move('public/assets/psa', $filepsa);
            }
            $user_id = session()->get('user_id');
            log_message('debug', 'user_id: ' . $user_id);
            $opening = $openingmodel->orderBy('id', 'DESC')->first();
            if (!$opening) {
                return redirect()->to('admin-admission')->with('error', 'No active opening found.');
            }
            $openingId = $opening['id'];


           
            $data = [
                'first_name'        => $first_name,
                'middle_name'       => $middle_name,
                'last_name'         => $last_name,
                'nickname'          => $nickname,
                'nationality'       => $nationality,
                'gender'            => $gender,
                'birthday'          => $birthday,
                'age'               => $age,
                'class_applied'     => $class_applied,
                'father_name'       => $father_name,
                'father_occupation' => $father_occupation,
                'mother_name'       => $mother_name,
                'mother_occupation' => $mother_occupation,
                'contact_number'    => $contact_number,
                'email'             => $email,
                'municipality'      => $municipality,
                'barangay'          => $barangay,
                'street'            => $street,
                'picture'           => $picture,
                'user_id'           => $user_id,
                'psa'               => $filepsa,
                'openingclosing_id' => $openingId,
                
            ];

            $admission_model->save($data);

            $notification->insert([
                'user_id' => 1,
                'title' => 'New Admission',
                'message' => 'A new admission has been submitted by ' . $first_name . ' ' . $last_name,
                'type' => 'admission',
                'is_read' => 0
            ]);
            session()->setFlashdata('success', 'Admission form submitted successfully!');
            return redirect()->to('/guardian/dashboard');
        }
    }
    public function studentView($admissionId): string|RedirectResponse
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }
        

        $user_id = session()->get('user_id');
       
        $studentModel       = new StudentModel();
        $announcementModel  = new \App\Models\AnnouncementModel();
        $notificationModel  = new NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $studentModel      = new StudentModel();
        $admissionModel      = new Admission_Model();

        $guardianDataAccount = $guardianModel->getGuardiandata($user_id);

        $announcements = $announcementModel->activeAnnouncementstudent();
        $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);

        $admissioninfo   = $admissionModel->getStudent($admissionId);

        $session = session();
        $session->set([
            'admissionID'     => $admissionId,
        ]);
       
        $data = [
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'guardian'             => $guardianDataAccount,
            'unread_announcement'  => $notificationModel->countAnnoucment($user_id),
            'notification'         => $notificationModel->userNotif($user_id),
        ];

        return view('guardian/viewStudent', $data);
    } 
    public function studentEdit($admissionId)
    {
        
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $user_id = session()->get('user_id');
       
        $studentModel       = new StudentModel();
        $announcementModel  = new \App\Models\AnnouncementModel();
        $notificationModel  = new NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $studentModel       = new StudentModel();
        $admissionModel     = new Admission_Model();
        $class_model        = new \App\Models\ClassModel();

        $guardianDataAccount = $guardianModel->getGuardiandata($user_id);
         $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $announcements = $announcementModel->activeAnnouncementstudent();
        $admissioninfo       = $admissionModel     -> getStudentData($user_id);
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);

        $admissioninfo   = $admissionModel->getStudent($admissionId);
       
        $data = [
             'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'guardian'             => $guardianDataAccount,
            'unread_announcement'  => $notificationModel->countAnnoucment($user_id),
            'notification'         => $notificationModel->userNotif($user_id),
            'classes'               => $class_model->findAll(),
            'students'             => $studentinfo,
        ];

        return view('guardian/edit_student', $data);
    }
    public function studentEditPost($admission_id)
    {
        helper('url');

        $post = $this->request->getPost();

        
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
            'class_applied'     => $post['class_applied'],
            'contact_number'    => $post['contact_number'],
            'municipality'      => $post['municipality'],
            'barangay'          => $post['barangay'],
            'street'            => $post['street'],
            'email'             => $post['email'],
        ];
    
        if ($newName !== null) {
        $admissionData['picture'] = $newName;
        }
        if ($newNamepsa !== null) {
        $admissionData['psa'] = $newNamepsa;
        }
   
        $updatedAdmissions = $this->db->table('admissions')
            ->where('admission_id', $admission_id)
            ->update($admissionData);
    
        session()->setFlashdata('success', 'Student information updated!');
        return redirect()->to('/Studentview/' . $admission_id)->with('success', 'Student information updated!');
    }
    
    public function studentViewDashboard($admissionId): string|RedirectResponse
{
    if (!session()->get('user_id')) {
        return redirect()->to('/login');
    }

    $session = session();
    $session->set([
        'child_id' => $admissionId,
    ]);
    
    $userId = session()->get('child_id');
    $studentModel  = new \App\Models\StudentModel();
    $parentInfo    = new \App\Models\GuardiansAccountModel();
    $guardianModel = new \App\Models\GuardianModel();
    $notificationmodel = new \App\Models\NotificationModel();

    $studentinfo     = $studentModel->studentInfo();
    $studentprofile  = $studentModel->studentProfile();
    $parentdata      = $parentInfo->getGuardianDataByAdmission($admissionId);
    $guardians       = $guardianModel->displayAllguardian();

    // ✅ Check if displayAllguardian() is not null or empty
    if (!empty($guardians)) {
        return redirect()->to('/guardian/dashboard-highlight/' . $admissionId);
    }

    $data = [
        'parentData'      => $parentdata,
        'student'         => $studentinfo,
        'guardians'       => $guardians,
        'studentprofile'  => $studentprofile,
         'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($userId),
            'notification'        => $notificationmodel -> StudentNotification($userId),
    ];

    $user_id = session()->get('user_id');
    log_message('debug', 'Current User ID: ' . $user_id);

    return view('user/Guardian-setup', $data);
}

    public function studentViewDashboardHighlight($admissionId): string|RedirectResponse
    {
         if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }

        $session = session();
        $session->set([
            'child_id'     => $admissionId,
        ]);
        
        
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $parentInfo = new \App\Models\GuardiansAccountModel();
        $TeacherPhotosModel = new \App\Models\TeacherPhotosUploadModel();

        $announcements = $announcementModel->activeAnnouncementstudent();
       
        $studentinfo = $studentModel ->studentInfo();
      

        
         $highlight    = $TeacherPhotosModel ->highlightPhotoPerchild($admissionId);
         $notificationmodel->markAllAsReadAnnoucment($admissionId);
         $parentdata   = $parentInfo      -> getGuardianDataByAdmission($admissionId);
        


        $data = [
            'highlight'           => $highlight,
            'announcements' => $announcements,
             'student' => $studentinfo,
             'unread_announcement' =>  $notificationmodel -> countAnnoucmentStudent($admissionId),
             'notification' => $notificationmodel -> StudentNotification($admissionId),
             'parentData'  => $parentdata,
        ];

        return view('user/Announcements',$data);
    }
    
    public function mainFromStudentDashboard($userId): string|RedirectResponse
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
       }
        
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $admissionModel     = new Admission_Model();
        $openingModel = new OpeningModel();
         $session = session();
         $session->set([
            'user_id'     => $userId,
        ]);
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
            $openingId = $yearsRecord[0]['id']; // Latest ID
            session()->set('opening_id', $openingId);
        }
		

	
        
        $user_id = session()->get('user_id');
        $announcements       = $announcementModel  -> activeAnnouncementstudent();
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);
         $childrens           = $admissionModel     -> getChildrenByGuardianNew($user_id,$openingId);
        $guardianDataAccount = $guardianModel      -> getGuardiandata($user_id);
        $admissioninfo       = $admissionModel     -> getStudentDataNew($user_id,$openingId);
        $status              = $admissionModel     -> getStatuses($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
         $yearsRecord     = $openingModel       -> openclosedate();
        

        $allowedStatuses = ['Enrolled', 'Disapproved', 'Interview Failed']; // example
        $allEnrolled = true;

        foreach ($status as $s) {
            $currentStatus = $s['status'] ?? '';
            // check if current status is NOT one of the allowed ones
            if (!in_array($currentStatus, $allowedStatuses)) {
                $allEnrolled = false;
                break;
            }
        }



        $data = [
            'isAdmissionOpen'      => $isAdmissionOpen,
            'status'               => $status,
            'guardian'             => $guardianDataAccount,
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'students'             => $studentinfo,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($user_id),
            'notification'         => $notificationmodel -> userNotif($user_id),
             'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];

        log_message('debug', 'Current User ID: ' . $user_id);
       

       
       return view('guardian/dashboard',$data);
    }
    public function paymenParent($user_id)
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        
        $openingModel = new OpeningModel();
        $guardianModel      = new GuardiansAccountModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $admissionModel     = new Admission_Model();
        $class_model = new ClassModel();
        $openingModel = new OpeningModel();

        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();
       
        $user_id = session()->get('user_id');
         $micellaneous  = $class_model -> getMiscellaneous($user_id); 
        $micellaneousFee = $micellaneous->miscellaneous ?? 0;
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);   
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen(); 
        $childrens           = $admissionModel     -> getChildrenByGuardianopening($user_id,$openingId);
        //$miscCard           = $admissionModel     ->  getChildrenByGuardianWithRemainingMisc($user_id);
        $miscCard           = $admissionModel     ->  getChildrenByGuardianWithRemainingMiscOpening($user_id,$openingId);
         
        
        $data = [
            'announcements'       => $announcements,
            'student' => $studentinfo,
            'unread_announcement' =>  $notificationmodel -> countAnnoucment($user_id),
            'notification'        => $notificationmodel -> userNotif($user_id),
            'isAdmissionOpen'      => $isAdmissionOpen,
            'childrens'            => $childrens,
            'miscCard'             => $miscCard,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,
        ];


        return view('guardian/parentPayment',$data);
    }
    public function getPaymentsByPlan($planId, $studentId)
    {
        $class_model = new ClassModel();
        $micellaneous  = $class_model -> getMiscellaneous($studentId); 
        $micellaneousFee = $micellaneous->miscellaneous ?? 0;
        
        $paymentModel = new \App\Models\PaymentModel();


        $payments = $paymentModel->getGuardianPaymenmisc($studentId,$planId);

        return $this->response->setJSON($payments);
    }
    public function tuition($planId, $guardianId)
    {
        $paymentModel = new \App\Models\PaymentModel();

        // Fetch all children + their payments + their tuition fee
        $payments = $paymentModel->getGuardianPaymentstuition($guardianId, $planId);

        return $this->response->setJSON($payments);
    }

    public function paymenParentTuition($user_id)
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $guardianModel      = new GuardiansAccountModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $paymentModel = new \App\Models\PaymentModel();
        $scheduleModel = new \App\Models\PaymentScheduleModel();
        $admissionModel     = new Admission_Model();
        $openingModel = new OpeningModel();
        
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }

        
        
        $user_id = session()->get('user_id');
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);
        $history = $paymentModel->getPaymentHistory($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        //$childrens           = $admissionModel     -> getChildrenByGuardian($user_id);getChildrenByGuardianopening
        $childrens           = $admissionModel     -> getChildrenByGuardianopening($user_id,$openingId);
        $yearsRecord     = $openingModel       -> openclosedate();

         // Check if plan_id 4 exists
        $hasPlan4 = $paymentModel->where('user_id', $user_id)
                                ->where('plan_id', 4)
                                ->countAllResults();

        $payment = [];
        if ($hasPlan4 == 0) {
            // Only fetch plan_id 2 payments if no plan_id 4 exists
            $payment = $paymentModel->getPaymentForTuition($user_id);
        }
        
        $schedulesRaw = $scheduleModel->getPaymentScheduleByUser($user_id);

        // Group schedules by child
        $schedules = [];
        foreach ($schedulesRaw as $row) {
            $schedules[$row['admission_id']]['full_name'] = $row['full_name'];
            $schedules[$row['admission_id']]['data'][] = $row;
        }

        
        $data = [
            'payment'             => $payment,
            'schedules'           => $schedules,
            'history'             => $history,
            'announcements'       => $announcements,
            'student' => $studentinfo,
            'unread_announcement' =>  $notificationmodel -> countAnnoucment($user_id),
            'notification'        => $notificationmodel -> userNotif($user_id),
            'isAdmissionOpen'      => $isAdmissionOpen,
            'childrens'            => $childrens,
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

          
        ];


        return view('guardian/parentpaypemtTuition',$data);
    }
    public function compute_totals()
{
    $childrenAmounts = $this->request->getPost('children') ?? [];   // array of posted amounts (from checkboxes)
    $childrenID = $this->request->getPost('childrenID') ?? [];       // array of student/admission IDs
    $partial = floatval($this->request->getPost('partial') ?? 0);

    // Debug: log received data
    log_message('info', 'Compute Totals - Children Amounts: ' . json_encode($childrenAmounts));
    log_message('info', 'Compute Totals - Children IDs: ' . json_encode($childrenID));
    log_message('info', 'Compute Totals - Partial Payment: ' . $partial);

    // Compute total of posted amounts
    $total = 0;
    foreach ($childrenAmounts as $amount) {
        $total += floatval(str_replace(',', '', $amount));
    }

    $classModel = new \App\Models\ClassModel();

    // Compute full tuition total from DB
    $Fulltotal = 0;
    foreach ($childrenID as $admission_id) {
        $tuitionData = $classModel->getTuitionFeeComputation($admission_id);

        // Debug: log fetched tuition data
        log_message('info', "Tuition Data for Admission ID {$admission_id}: " . json_encode($tuitionData));

        if (!empty($tuitionData) && isset($tuitionData[0]['tuitionfee'])) {
            $Fulltotal += floatval($tuitionData[0]['tuitionfee']);
        }
    }

    $balance = max($total - $partial, 0);
    $discountRate = 0.08;

    // Show full monthly only if no partial payment and total equals full tuition
    $showFullMonthly = ($partial == 0 && $total == $Fulltotal);
    $discountedTotal = $showFullMonthly ? $total * (1 - $discountRate) : 0;

    return $this->response->setJSON([
        'childrenCount' => count($childrenID),
        'total' => number_format($total, 2),
        'partial' => number_format($partial, 2),
        'balance' => number_format($balance, 2),
        'showFullMonthly' => $showFullMonthly,
        'discountedTotal' => number_format($discountedTotal, 2),
        'partialFormatted' => number_format($partial, 2),
        'fullTotalFormatted' => number_format($Fulltotal, 2),
    ]);
}


    public function deleteStudent($admissionId)
    {
        $admissionModel = new \App\Models\Admission_Model();

        if ($admissionModel->deleteStudent($admissionId)) {
            return redirect('guardian/dashboard')->with('success', 'Student deleted successfully.');
        } else {
            return redirect('guardian/dashboard')->with('error', 'Failed to delete student.');
        }
    }
    public function Parenthistory($userId)
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $guardianModel      = new GuardiansAccountModel();
        $announcementModel  = new \App\Models\AnnouncementModel();
        $notificationmodel  = new \App\Models\NotificationModel();
        $paymentModel       = new \App\Models\PaymentModel();
        $scheduleModel      = new \App\Models\PaymentScheduleModel();
        $openingModel = new OpeningModel();
         $admissionModel     = new Admission_Model();
         
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }


        
        
        $user_id = session()->get('user_id');
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);
        $announcements = $announcementModel -> activeAnnouncementstudent();
        $studentinfo   = $guardianModel     -> getGuardiandata($user_id);
        $history       = $paymentModel      -> getAllPaymentHistoryOpening($user_id, $openingId);
        $schedulesRaw  = $scheduleModel     -> getPaymentScheduleByUser($user_id);
         $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        // $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $childrens           = $admissionModel     -> getChildrenByGuardianopening($user_id,$openingId);
        $yearsRecord     = $openingModel       -> openclosedate();

        // Group schedules by child
        $schedules = [];
        foreach ($schedulesRaw as $row) {
            $schedules[$row['admission_id']]['full_name'] = $row['full_name'];
            $schedules[$row['admission_id']]['data'][] = $row;
        }     
        
        
         
         
        $data = [
            'history'             => $history,
            'announcements'       => $announcements,
            'students'            => $studentinfo,
            'unread_announcement' => $notificationmodel -> countAnnoucment($user_id),
            'notification'        => $notificationmodel -> userNotif($user_id),
            'isAdmissionOpen'     => $isAdmissionOpen,
             'childrens'          => $childrens,
             'yearsRecord'        => $yearsRecord,
            'selectedOpeningId'   => $openingId,
        ];


        return view('guardian/paymenthistory',$data);
    }
    public function ProfileEdit(): string|RedirectResponse
    {
        $studentModel      = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel     = new GuardiansAccountModel();
        $admissionModel    = new Admission_Model();
        $openingModel      = new OpeningModel();
		
    
	
        
        $user_id = session()->get('user_id');
        $announcements       = $announcementModel  -> activeAnnouncementstudent();
        
        $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $guardianDataAccount = $guardianModel      -> getGuardiandata($user_id);
        $admissioninfo       = $admissionModel     -> getStudentData($user_id);
        $status              = $admissionModel     -> getStatuses($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        

        $allowedStatuses = ['Enrolled', 'Disapproved', 'Interview Failed']; // example
        $allEnrolled = true;

        foreach ($status as $s) {
            $currentStatus = $s['status'] ?? '';
            // check if current status is NOT one of the allowed ones
            if (!in_array($currentStatus, $allowedStatuses)) {
                $allEnrolled = false;
                break;
            }
        }


      
        $data = [
            'isAdmissionOpen'      => $isAdmissionOpen,
            'guardian'             => $guardianDataAccount,
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'studentprofile'       => $guardianDataAccount,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($user_id),
            'notification'         => $notificationmodel -> userNotif($user_id),
            'students'             => $guardianDataAccount,
            'childrens'            => $childrens,
        ];

        log_message('debug', 'Current User ID: ' . $user_id);
       
       return view('guardian/profileEdit',$data);
    }
    public function updateProfile()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        helper('url');

        $post = $this->request->getPost();
        log_message('info', 'updateProfile called with data: ' . json_encode($post));

        $user_id = $post['user_id'];


         $existingUser = $this->db->table('users')
            ->groupStart()
                ->where('email', $post['email'])
                ->orWhere('username', $post['username'])
            ->groupEnd()
            ->where('id !=', $user_id)
            ->get()
            ->getRow();

        if ($existingUser) {
            session()->setFlashdata('error', 'Email or username already exists. Please use a different one.');
            return redirect()->back()->withInput();
        }

        // Handle profile picture upload
        $profilePicFile = $this->request->getFile('profile_pic');
        $profilePic = null;

        if ($profilePicFile && $profilePicFile->isValid() && !$profilePicFile->hasMoved()) {
            $profilePic = $profilePicFile->getRandomName();
            $profilePicFile->move('public/assets/profilepic/', $profilePic);
            log_message('info', "Uploaded profile picture: {$profilePic}");
        }

        // Prepare data for update
        $updateData = [
            'first_name'     => $post['first_name'],
            'middle_name'    => $post['middle_name'],
            'last_name'      => $post['last_name'],
            'contact_number' => $post['contact_number'],
            'email'          => $post['email'],
            'municipality'   => $post['municipality'],
            'barangay'       => $post['barangay'],
            'street'         => $post['street']
        ];

        if ($profilePic !== null) {
            $updateData['profile_pic'] = $profilePic;
        }

        // Update guardiansAccount table
        $updatedGuardian = $this->db->table('guardiansAccount')
            ->where('user_id', $user_id)
            ->update($updateData);

        log_message('info', "Updated guardiansAccount for user_id {$user_id}: " . ($updatedGuardian ? 'Success' : 'Failed'));

        // Update users table (only email)
       $updatedUser = $this->db->table('users')
        ->where('id', $user_id)
        ->update([
            'email' => $post['email'],
            'username' => $post['username']
        ]);

        log_message('info', "Updated users table for user_id {$user_id}: " . ($updatedUser ? 'Success' : 'Failed'));

        $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $user_id, 
                'title'   => 'Profile edit',
                'message' => 'Profile Updated',
                'type'    => 'Update', 
                'is_read' => 0
            ]);
            session()->setFlashdata('success', 'Profile updated successfully!');
         return redirect()->to('guardian/dashboard')->with('success', 'Profile updated successfully!');
    }
   
    public function guardianAnnouncement()
    {
        if (!session()->get('user_id')) {
        return redirect()->to('/login');
        }
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $admissionModel     = new Admission_Model();
        $openingModel = new OpeningModel();
        
        $openingId = session()->get('opening_id');
        if (!$openingId && !empty($yearsRecord)) {
                    $openingId = $yearsRecord[0]['id']; // Latest ID
                    session()->set('opening_id', $openingId);
                }
        $yearsRecord     = $openingModel       -> openclosedate();



		

        
        
        $user_id = session()->get('user_id');
        //$announcements       = $announcementModel  -> AnnouncementGuardian($user_id);AnnouncementGuardianOpening
        $announcements       = $announcementModel  -> AnnouncementGuardianOpening($user_id,$openingId);
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);
        //$childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $childrens           = $admissionModel     -> getChildrenByGuardianopening($user_id,$openingId);
        $guardianDataAccount = $guardianModel      -> getGuardiandata($user_id);
        $admissioninfo       = $admissionModel     -> getStudentData($user_id);
        $status              = $admissionModel     -> getStatuses($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        

        $allowedStatuses = ['Enrolled', 'Disapproved', 'Interview Failed']; // example
        $allEnrolled = true;

        foreach ($status as $s) {
            $currentStatus = $s['status'] ?? '';
            // check if current status is NOT one of the allowed ones
            if (!in_array($currentStatus, $allowedStatuses)) {
                $allEnrolled = false;
                break;
            }
        }



        $data = [
            'isAdmissionOpen'      => $isAdmissionOpen,
            'status'               => $status,
            'guardian'             => $guardianDataAccount,
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'students'             => $studentinfo,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($user_id),
            'notification'         => $notificationmodel -> userNotif($user_id),
            'yearsRecord'          => $yearsRecord,
            'selectedOpeningId'    => $openingId,

        ];

        log_message('debug', 'Current User ID: ' . $user_id);
       
       return view('guardian/guardian-announcements',$data);
    }
    public function resetPassword()
    {
        $studentModel = new \App\Models\StudentModel();
        $announcementModel = new \App\Models\AnnouncementModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $admissionModel     = new Admission_Model();
        $openingModel = new OpeningModel();
		
   
        
        $user_id = session()->get('user_id');
        $announcements       = $announcementModel  -> activeAnnouncementstudent();
        $studentinfo         = $guardianModel      -> getGuardiandata($user_id);
        $childrens           = $admissionModel     -> getChildrenByGuardian($user_id);
        $guardianDataAccount = $guardianModel      -> getGuardiandata($user_id);
        $admissioninfo       = $admissionModel     -> getStudentData($user_id);
        $status              = $admissionModel     -> getStatuses($user_id);
        $isAdmissionOpen     = $openingModel       -> isAdmissionOpen();
        

        $allowedStatuses = ['Enrolled', 'Disapproved', 'Interview Failed']; // example
        $allEnrolled = true;

        foreach ($status as $s) {
            $currentStatus = $s['status'] ?? '';
            // check if current status is NOT one of the allowed ones
            if (!in_array($currentStatus, $allowedStatuses)) {
                $allEnrolled = false;
                break;
            }
        }

     
       

        $data = [
            'isAdmissionOpen'      => $isAdmissionOpen,
            'status'               => $status,
            'guardian'             => $guardianDataAccount,
            'childrens'            => $childrens,
            'announcements'        => $announcements,
            'student'              => $admissioninfo,
            'students'             => $studentinfo,
            'unread_announcement'  => $notificationmodel -> countAnnoucment($user_id),
            'notification'         => $notificationmodel -> userNotif($user_id),
        ];

        log_message('debug', 'Current User ID: ' . $user_id);
       
       return view('guardian/guardian-password',$data);
    }
    public function resetPasswordPostGuardian()
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
            return redirect()->to('/guardian-resetPassword')->with('error', 'New passwords do not match.');
        }

        $userModel = new \App\Models\UserModel(); // Replace with your actual user model
        $user = $userModel->find($userId);

        if (!$user || $currentPassword !== $user['password_hash']) {
        session()->setFlashdata('error', 'Current password is incorrect.');
        return redirect()->to('/guardian-resetPassword')->with('error', 'Current password is incorrect.');
        }

        // Hash and update password
        $userModel->update($userId, [
            'password_hash' => $newPassword
        ]);
        

        session()->setFlashdata('success', 'Password changed successfully');
        return redirect()->to('/guardian/dashboard')->with('success', 'Password changed successfully.');
    }
    public function payOnlineEnrollmentFailed()
    {
         $userId = session()->get('user_id');


        if (!$userId) {
            return redirect()->to('/login');
        }

        return redirect()
            ->to('guardian/dashboard')
            ->with('error', 'Your online payment was not successful. Please try again or use another payment method.');
    }

    public function generatereport($paymentID)
    {
        $paymentModel = new \App\Models\PaymentModel();

        $data = [
            'payment' => $paymentModel->paymentReceipt($paymentID),
        ];

        return view('guardian/guardian-receipt', $data);
    }


    
    //new dec 4
    public function setOpeningId()
    {
        $id = $this->request->getPost('id');

        if ($id) {
            session()->set('opening_id', $id);
        }

        return $this->response->setJSON(['status' => 'success']);
    }


}
