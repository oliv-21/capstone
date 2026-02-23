<?php
namespace App\Models;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use App\Models\Admission_Model;
use App\Models\TuitionPlanModel;
use App\Models\PaymentModel;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_id', 'first_name','middle_name', 'last_name', 'birthday', 'class_level', 'admission_id','profile_pic','qr_code','student_id'];

    public function enrollStudent($admissionId, $admissionModel, $userModel, $enrollment, $openingId,$notification)
    {
        
        $admission = $admissionModel->find($admissionId);
        if (!$admission) {
            throw new \Exception('Admission record not found.');
        }

        $username = $this->generateUniqueUsername($admission->first_name, $userModel);
        $passwordPlain = str_replace('-', '', $admission->birthday);  // Strip dashes from birthday for password
        $passwordHash = password_hash($passwordPlain, PASSWORD_DEFAULT);

        
        $userData = [
            'username'      => $username,
            'password_hash' => $passwordPlain,
            'email'         => $admission->email,
            'role'          => 'student',
        ];


        
        $userModel->insert($userData);
        $userId = $this->db->insertID();


        $studentId = uniqid(); 

        $qrText = "Guardian ID: $studentId";

        log_message('info', "Generating QR code for Guardian ID: {$studentId}");

        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->encoding(new Encoding('UTF-8'))
           ->errorCorrectionLevel(ErrorCorrectionLevel::Low)

            ->size(300)
            ->margin(10)
            ->build();

        // Save QR code to file
        $qrCodeDir = ROOTPATH . 'public/assets/qrstudentId/';
        if (!is_dir($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
            log_message('info', "Created QR code directory: {$qrCodeDir}");
        }
        $qrCodeFile = $qrCodeDir . $studentId . '.png';
        $result->saveToFile($qrCodeFile);
        log_message('info', "QR code saved to file: {$qrCodeFile}");

        $admissionModel->update($admissionId, ['status' => 'Enrolled']);

        $existingStudent = $this->where('admission_id', $admissionId)->first();
        if ($existingStudent) {
            throw new \Exception('This admission record is already enrolled as a student.');
        }

        $studentData = [
            'user_id'      => $userId,
            'first_name'   => $admission->first_name,
            'middle_name'  => $admission->middle_name,
            'last_name'    => $admission->last_name,
            'birthday'     => $admission->birthday,
            'class_level'  => $admission->class_applied,
            'admission_id' => (int)$admissionId,
            
            'qr_code'      =>$studentId. '.png',
        ];
        
        $this->insert($studentData);
       
        $email = \Config\Services::email();

        $email->setFrom('ecohaven28@gmail.com', 'Brightside'); 
        $email->setTo($admission->email);

        $email->setSubject('Brightside');
        
        $message = "
            <p>Dear {$admission->first_name},</p>
            <p>Your enrollment has been successful. Below are your login credentials:</p>
            <ul>
                <li><strong>Username:</strong> {$username}</li>
                <li><strong>Password:</strong> {$passwordPlain}</li>
            </ul>
            <p>Please change your password after your first login.</p>
            <p>Regards,<br>Your School Administration</p>
        ";

        $email->setMessage($message);

        if (! $email->send()) {
        
            log_message('error', 'Email sending failed: ' . $email->printDebugger(['headers']));
            
        }

        $enrollmentData = [
            'student_id'        => $userId,
            'openingclosing_id' => $openingId,
        ];
        $enrollment->insert($enrollmentData);

        




        
    }


    private function generateUniqueUsername($nickname, $userModel)
    {
        $baseUsername = strtolower(str_replace(' ', '_', $nickname));
        $username = $baseUsername;
        $counter = 1;

        while ($userModel->where('username', $username)->first()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
    
    public function attendanceDetails()
    {
        $builder = $this->db->table($this->table . ' s'); 
        $builder->select("
            s.*,
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
            CONCAT(s.last_name, ' ', s.first_name) AS full_name,
            at.date,
            at.arrival_time,
            at.leave_time,
            at.status,
            at.picked_up_by,
            at.id
        ");
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');
        $builder->join('attendance at', 'at.user_id = s.user_id AND at.date = CURDATE()', 'left');

        return $builder->get()->getResult();
    }

    public function attendance_summary_view()
    {
        $builder = $this->db->table('students s');
        
        $builder->select("
            s.user_id, 
            CONCAT(s.last_name, ', ', s.first_name, ' ', LEFT(s.middle_name, 1), '.') AS full_name, 
            s.class_level
        ");
        $students = $builder->get()->getResult();

        $summary = [];

        foreach ($students as $student) {
            $user_id = $student->user_id;

            $total_days = 180;
            // $total_days = $this->db->table('attendance')
            //     ->where('user_id', $user_id)
            //     ->countAllResults();

            $days_present = $this->db->table('attendance')
                ->where('user_id', $user_id)
                ->where('status', 'Present')
                ->countAllResults();

            $days_absent = $this->db->table('attendance')
                ->where('user_id', $user_id)
                ->where('status', 'Absent')
                ->countAllResults();

            $percentage = $total_days > 0 ? round(($days_present / $total_days) * 100, 2) : 0;

            $summary[] = [
                'name' => $student->full_name,
                'class_level' => $student->class_level,
                'total_days' => $total_days,
                'present' => $days_present,
                'absent' => $days_absent,
                'percentage' => $percentage
            ];
        }

         return $summary;
    }
    public function studentInfo()
    {
        
       $builder = $this->db->table('students s');
    $builder->select("
        s.*, 
        CONCAT(
            UPPER(LEFT(s.first_name, 1)), LOWER(SUBSTRING(s.first_name, 2)), ' ',
            UPPER(LEFT(s.last_name, 1)), LOWER(SUBSTRING(s.last_name, 2))
        ) AS full_name,
        a.user_id AS parent_id
    ");
    // Join admissions table
    $builder->join('admissions a', 'a.admission_id = s.admission_id', 'left');

        $builder->where('s.user_id', session()->get('child_id'));
        return $builder->get()->getRow();
    }
    public function studentProfile()
    {
        $builder = $this->db->table($this->table . ' s'); 
        $builder->select("
            s.*,
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
            ad.user_id as parent_id,
            CONCAT(
                UPPER(LEFT(s.first_name, 1)), LOWER(SUBSTRING(s.first_name, 2)), ' ',
                UPPER(LEFT(s.last_name, 1)), LOWER(SUBSTRING(s.last_name, 2))
            ) AS full_name
        ");
        
        $builder->where('s.user_id', session()->get('child_id'));
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');

        return $builder->get()->getRow();
    }
    public function attendance_view()
    {
        // Get session instance
        $session = session();
        $user_id = $session->get('child_id');

        $total_days = 180;

        // Count days present
        $days_present = $this->db->table('attendance')
            ->where('user_id', $user_id)
            ->where('status', 'Present')
            ->countAllResults();

        // Count days absent
        $days_absent = $this->db->table('attendance')
            ->where('user_id', $user_id)
            ->where('status', 'Absent')
            ->countAllResults();

        

        return [
            'total_days' => $total_days,
            'present' => $days_present,
            'absent' => $days_absent
        ];
    }
    public function attendance_withguarnianview()
    {
      
        $session = session();
        $user_id = $session->get('child_id');

        
        $attendance_with_guardian = $this->db->table('attendance')
        ->select("attendance.*, 
                CONCAT(students.last_name, ' ', students.first_name) AS student_full_name,
                CONCAT(guardian.last_name, ' ', guardian.first_name) AS full_name,
                guardian.relationship")  
        ->join('guardian', "guardian.qr_code = CONCAT(attendance.picked_up_by, '.png') AND attendance.picked_up_by <> 0", 'left')
        ->join('students', 'students.user_id = attendance.user_id')
        ->where('attendance.user_id', $user_id)
        ->get()
        ->getResult();




        // Return the full attendance data
        return [
            'attendance_records' => $attendance_with_guardian
        ];
    }
    
    public function getdataStudent(string $userId)
    {
        $builder = $this->db->table($this->table . ' s');
        $builder->select("s.*, ad.contact_number, CONCAT(s.last_name, ' ', s.first_name) AS fullname");
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');
        $builder->where('s.user_id', $userId);

        return $builder->get()->getRow();
    }
    public function getdataStudentall(string $userId)
    {
        $builder = $this->db->table($this->table . ' s');
        $builder->select("s.*, ad.contact_number, CONCAT(s.last_name, ' ', s.first_name) AS fullname");
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');
        $builder->where('s.user_id', $userId);

        
        return $builder->get()->getResult();
    }



    // public function profileandfullname(string $userId)
    // {
    //     // Try to get from students
    //     $student = $this->db->table('students s')
    //         ->select("
    //             s.user_id AS id,
    //             CONCAT_WS(' ', s.last_name, s.first_name) AS full_name,
    //             s.profile_pic
    //         ")
    //         ->where('s.user_id', $userId)
    //         ->get()
    //         ->getRowArray();

    //     if ($student) {
    //         return $student;
    //     }

    //     // If not found, try to get from adminandstaff
    //     $admin = $this->db->table('adminandstaff a')
    //         ->select("
    //             a.user_id AS id,
    //             CONCAT_WS(' ', a.firstname) AS full_name,
    //             a.profilepic AS profile_pic
    //         ")
    //         ->where('a.user_id', $userId)
    //         ->get()
    //         ->getRowArray();

    //     return $admin ?: null;
    // }
    public function profileandfullname(string $userId)
    {
        // ✅ Try to get from students
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

        // ✅ Try to get from teachers
        $teacher = $this->db->table('teachers t')
            ->select("
                t.user_id AS id,
                CONCAT_WS(' ', t.last_name, t.first_name) AS full_name,
                t.profile_pic
            ")
            ->where('t.user_id', $userId)
            ->get()
            ->getRowArray();

        if ($teacher) {
            return $teacher;
        }

        // ✅ Try to get from adminandstaff
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


    public function getAllStudent($classname = null)
    {
        $builder = $this->db->table($this->table . ' s')
            ->select("
                s.user_id,
                CONCAT(s.last_name, ' ', s.first_name) AS full_name
            ");

        // Apply filter only if $classname is provided and not 'all'
        if (!empty($classname) && strtolower($classname) !== 'all') {
            $builder->where('s.class_level', $classname);
        }

        return $builder->get()->getResult();
    }
    public function studentDataTeacher($UserId)
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
                 CONCAT(s.first_name, ' ', LEFT(s.middle_name, 1), '. ', s.last_name) AS full_name,")    
            ->join('admissions ad', 'ad.admission_id = s.admission_id')
            ->where('s.user_id', $UserId)
            ->get()
            ->getRowArray();
    }
    public function getStudentClassroom($userId)
    {
        return $this->db->table('students as s')
                        ->join('classroom as c', 's.class_level = c.class_level')
                        ->where('s.user_id', $userId)
                        ->orderBy('c.created_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }
    public function processCashPayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId)
    {
        // $db = \Config\Database::connect();
        // $admissionModel   = new Admission_Model();
      
        // $paymentModel     = new PaymentModel();
        // $notificationModel= new NotificationModel();
        

        // $db->transStart();

        // $student = $admissionModel->getStudent($admissionId);
        // if (!$student) return ['success' => false, 'message' => 'Student admission not found.'];

        // $plan = $TuitionPlanModel->getPlanById(2);
        // if (!$plan) return ['success' => false, 'message' => 'Tuition plan not found.'];

        // $remainingBalance = max(0, $plan['total_amount'] - $amountPaid);
        // $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

        // // ✅ Generate QR Code
        // $studentId = uniqid();
        // $qrText = "Guardian ID: $studentId";
        // $result = Builder::create()
        //     ->writer(new PngWriter())
        //     ->data($qrText)
        //     ->encoding(new Encoding('UTF-8'))
        //     ->errorCorrectionLevel(ErrorCorrectionLevel::Low)
        //     ->size(300)
        //     ->margin(10)
        //     ->build();

        // $qrCodeDir = ROOTPATH . 'public/assets/qrstudentId/';
        // if (!is_dir($qrCodeDir)) mkdir($qrCodeDir, 0755, true);
        // $result->saveToFile($qrCodeDir . $studentId . '.png');

        // $admissionModel->update($admissionId, ['status' => 'Enrolled']);

        // // Insert student
        //   $this->insert([
        //     'user_id'      => $admissionId,
        //     'student_id'   => $admissionId,
        //     'admission_id' => $admissionId,
        //     'first_name'   => $student->first_name,
        //     'middle_name'  => $student->middle_name,
        //     'last_name'    => $student->last_name,
        //     'birthday'     => $student->birthday,
        //     'class_level'  => $student->class_applied,
        //     'profile_pic'  => $student->picture ?? 'default.webp',
        //     'qr_code'      => $studentId . '.png',
        // ]);

       
        // // Insert payment
        // $paymentModel->insert([
        //     'user_id'           => $admissionId,
        //     'plan_id'           => 2,
        //     'amount_paid'       => number_format((float)$amountPaid, 2, '.', ''),
        //     'remaining_balance' => number_format((float)$remainingBalance, 2, '.', ''),
        //     'payment_method'    => $paymentType,
        //     'payment_date'      => $paymentDate,
        //     'status'            => $status,
        // ]);

        // // Notification
        // $notificationModel->insert([
        //     'user_id' => $admissionId,
        //     'title'   => 'Payment Received',
        //     'message' => 'Your school payment has been successfully recorded.',
        //     'type'    => 'payment',
        //     'is_read' => 0
        // ]);

        // $db->transComplete();

       
        // return ['success' => true, 'message' => 'Student enrolled and payment recorded successfully.'];
        $admissionModel   = new Admission_Model();
        $TuitionPlanModel = new TuitionPlanModel();
        $paymentModel     = new PaymentModel();
        $enrollment      = new EnrollmentModel();
        $admission = $admissionModel->find($admissionId);
        if (!$admission) {
            throw new \Exception('Admission record not found.');
        }

        $studentId = uniqid(); 

        $qrText = "Guardian ID: $studentId";

        log_message('info', "Generating QR code for Guardian ID: {$studentId}");

        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->encoding(new Encoding('UTF-8'))
           ->errorCorrectionLevel(ErrorCorrectionLevel::Low)

            ->size(300)
            ->margin(10)
            ->build();

        // Save QR code to file
        $qrCodeDir = ROOTPATH . 'public/assets/qrstudentId/';
        if (!is_dir($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
            log_message('info', "Created QR code directory: {$qrCodeDir}");
        }
        $qrCodeFile = $qrCodeDir . $studentId . '.png';
        $result->saveToFile($qrCodeFile);
        log_message('info', "QR code saved to file: {$qrCodeFile}");

        $admissionModel->update($admissionId, ['status' => 'Enrolled']);

        $existingStudent = $this->where('admission_id', $admissionId)->first();
        if ($existingStudent) {
            throw new \Exception('This admission record is already enrolled as a student.');
        }

        $studentData = [
            'user_id'      => (int)$admissionId,
            'first_name'   => $admission->first_name,
            'middle_name'  => $admission->middle_name,
            'last_name'    => $admission->last_name,
            'birthday'     => $admission->birthday,
            'class_level'  => $admission->class_applied,
            'admission_id' => (int)$admissionId,
            'profile_pic'  =>$admission->picture,
            
            'qr_code'      =>$studentId. '.png',
            'student_id'   => (int)$admissionId,
        ];
        
        $this->insert($studentData);
        // // Insert payment
        // 'user_id', 'plan_id ', 'amount_paid', 'remaining_balance', 'payment_method', 'payment_date','status'
        $plan = $TuitionPlanModel->getPlanById((int)2);
        $remainingBalance = max(0, 2000 - $amountPaid);
        $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

        $paymentModel->insert([
            'user_id'           => (int)$admissionId,
            'plan_id'           => 2,
            'amount_paid'       => number_format((float)$amountPaid, 2, '.', ''),
            'remaining_balance' => number_format((float)$remainingBalance, 2, '.', ''),
            'payment_method'    => $paymentType,
            'payment_date'      => $paymentDate,
            'status'            => $status,
        ]);
       
        $enrollmentData = [
            'student_id'        => $admissionId,
            'openingclosing_id' => $openingId,
        ];
        $enrollment->insert($enrollmentData);
        
        

         
       
    }
    public function processOnlinePayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId)
    {
        
        if (empty($admissionId)) {
        log_message('error', 'processOnlinePayment failed: Admission ID is missing.');
        return; // stop the function safely
        }

        $TuitionPlanModel = new TuitionPlanModel();
        $paymentModel     = new PaymentModel();
        $enrollment      = new EnrollmentModel();
        $admissionModel      = new Admission_Model();
        $admission = $admissionModel->find($admissionId);
        if (!$admission) {
            throw new \Exception('Admission record not found.');
        }

        $studentId = uniqid(); 

        $qrText = "Guardian ID: $studentId";

        log_message('info', "Generating QR code for Guardian ID: {$studentId}");

        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->encoding(new Encoding('UTF-8'))
           ->errorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->size(300)
            ->margin(10)
            ->build();

        // Save QR code to file
        $qrCodeDir = ROOTPATH . 'public/assets/qrstudentId/';
        if (!is_dir($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
            log_message('info', "Created QR code directory: {$qrCodeDir}");
        }
        $qrCodeFile = $qrCodeDir . $studentId . '.png';
        $result->saveToFile($qrCodeFile);
        log_message('info', "QR code saved to file: {$qrCodeFile}");

        $admissionModel->update($admissionId, ['status' => 'Enrolled']);

        $existingStudent = $this->where('admission_id', $admissionId)->first();
        if ($existingStudent) {
            throw new \Exception('This admission record is already enrolled as a student.');
        }

        $studentData = [
            'user_id'      => (int)$admissionId,
            'first_name'   => $admission->first_name,
            'middle_name'  => $admission->middle_name,
            'last_name'    => $admission->last_name,
            'birthday'     => $admission->birthday,
            'class_level'  => $admission->class_applied,
            'admission_id' => (int)$admissionId,
            'qr_code'      =>$studentId. '.png',
            'student_id'   => (int)$admissionId,
            'profile_pic'  => $admission->picture,
        ];
        
        $this->insert($studentData);
        $plan = $TuitionPlanModel->getPlanById((int)2);
        $remainingBalance = max(0, 2000 - $amountPaid);
        $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

        $paymentModel->insert([
            'user_id'           => (int)$admissionId,
            'plan_id'           => 2,
            'amount_paid'       => number_format((float)$amountPaid, 2, '.', ''),
            'remaining_balance' => number_format((float)$remainingBalance, 2, '.', ''),
            'payment_method'    => $paymentType,
            'payment_date'      => $paymentDate,
            'status'            => $status,
        ]);
       
        $enrollmentData = [
            'student_id'        => $admissionId,
            'openingclosing_id' => $openingId,
        ];
        $enrollment->insert($enrollmentData);

    }
    public function studentInfoStudent($UserId)
    {
        $builder = $this->db->table('students s');
        $builder->select("
            s.*, 
            CONCAT(
                UPPER(LEFT(s.last_name, 1)), LOWER(SUBSTRING(s.last_name, 2)), ' ',
                UPPER(LEFT(s.first_name, 1)), LOWER(SUBSTRING(s.first_name, 2))
            ) AS full_name,
            a.user_id AS parent_id
        ");
        // Join admissions table
        $builder->join('admissions a', 'a.admission_id = s.admission_id', 'left');
        $builder->where('s.user_id', $UserId);

        return $builder->get()->getRow();
    }

    //=======================================================================New Data dec 22============================================================================
     public function attendance_summary_viewOpening($openingId)
    {
        $builder = $this->db->table('students s');
        
        $builder->select("
            s.user_id, 
            CONCAT(s.last_name, ', ', s.first_name, ' ', LEFT(s.middle_name, 1), '.') AS full_name, 
            s.class_level
        ");
        $builder->join('admissions a', 'a.admission_id = s.user_id');
        $builder->where('a.openingclosing_id', $openingId);
        $students = $builder->get()->getResult();

        $summary = [];

        foreach ($students as $student) {
            $user_id = $student->user_id;

            $total_days = 180;
            // $total_days = $this->db->table('attendance')
            //     ->where('user_id', $user_id)
            //     ->countAllResults();

            $days_present = $this->db->table('attendance')
                ->where('user_id', $user_id)
                ->where('status', 'Present')
                ->countAllResults();

            $days_absent = $this->db->table('attendance')
                ->where('user_id', $user_id)
                ->where('status', 'Absent')
                ->countAllResults();

            $percentage = $total_days > 0 ? round(($days_present / $total_days) * 100, 2) : 0;

            $summary[] = [
                'name' => $student->full_name,
                'class_level' => $student->class_level,
                'total_days' => $total_days,
                'present' => $days_present,
                'absent' => $days_absent,
                'percentage' => $percentage
            ];
        }

         return $summary;
    }

    //=======================================================================New Data ============================================================================
    public function getPaymentDetails($admissionId)
    {
        $builder = $this->db->table('students s');
        $builder->select("
            CONCAT(UPPER(LEFT(s.first_name,1)), LOWER(SUBSTRING(s.first_name,2))) AS first_name,
            CONCAT(UPPER(LEFT(s.middle_name,1)), LOWER(SUBSTRING(s.middle_name,2))) AS middle_name,
            CONCAT(UPPER(LEFT(s.last_name,1)), LOWER(SUBSTRING(s.last_name,2))) AS last_name,
            s.student_id,
            s.admission_id,
            s.profile_pic,
            CONCAT(
                UPPER(LEFT(g.first_name,1)), LOWER(SUBSTRING(g.first_name,2)), ' ',
                UPPER(LEFT(g.last_name,1)), LOWER(SUBSTRING(g.last_name,2))
            ) AS guardianfull_name
        ");
        
        // Join with guardians table
        $builder->join('guardiansAccount g', 'g.user_id = s.user_id', 'left');
        
        // Filter by admission ID
        $builder->where('s.admission_id', $admissionId);

        // Get single row as array
        $query = $builder->get();
        return $query->getRowArray();
    }

    

    





    




    
}
