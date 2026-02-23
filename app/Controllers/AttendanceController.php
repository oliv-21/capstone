<?php

namespace App\Controllers;
require_once( 'vendor/autoload.php' );
use App\Models\Admin_Model;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\Admission_Model;
use App\Models\Attendance_Model;
use Semaphore\SemaphoreClient;
use App\Models\ClassModel;
use App\Models\GuardianModel;

use CodeIgniter\API\ResponseTrait;

class AttendanceController extends BaseController
{
   protected $format = 'json';
    protected $studentModel;
    protected $attendanceModel;
    public function __construct()
    {
        $this->studentModel = new \App\Models\StudentModel();
        $this->attendanceModel = new \App\Models\Attendance_Model();
        $this->guardianmodel =new \App\Models\GuardianModel();
        
    }
    public function attendance()
    {
         $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

         $profilepicModel = new \App\Models\AdminStaffModel();
        $this->maybeMarkAbsentees();

       

        $studentModel = new \App\Models\StudentModel();
        $students = $studentModel->attendanceDetails();
          $profilepic = $profilepicModel->profileandfullnamestaff($userId);
        $class_model = new \App\Models\ClassModel();
        $data = [];
        $data['classes'] = $class_model->findAll();
        $data['students'] = $students;
        $data['profileAccount'] = $profilepic;

        return view('attendance/attendance', $data);
    }

    public function staffprofile()
    {   
        $userModel = new \App\Models\UserModel();
        $email = $userModel->email();
        $profilepicModel = new \App\Models\AdminStaffModel();
        $profilepic = $profilepicModel->profilepic();
         $userId = session()->get('user_id');
         if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

        $profilepicAndName = $profilepicModel->profileandfullnamestaff($userId);
         
         
        $this->maybeMarkAbsentees();
        


        // Mag-log sa app/Logs/log-XXXX.php
        log_message('debug', 'Email fetched: ' . $email);

        $data = [
            'email' => $email,
            'profilepic' => $profilepic,
            'profileAccount' =>$profilepicAndName,
        ];
        $this->maybeMarkAbsentees();

        return view('attendance/staff-profile', $data);
    }
   
     public function staffprofilepost()
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

        return redirect()->to('/staffprofile')->with('success', 'Profile updated.');
    }



    
  
    use ResponseTrait;
    public function markArrival()
    {
        $input = $this->request->getJSON(true);

        if (!isset($input['qr_code'], $input['date'], $input['time'])) {
            return $this->respond([
                'success' => false,
                'message' => 'Missing required parameters.'
            ], 400);
        }

        // Extract QR code ID by removing prefix "Guardian ID:" and trimming spaces
        $qrId = trim(str_replace('Guardian ID:', '', $input['qr_code']));

        $date = $input['date'];
        $time = $input['time'];
        


        // Load models if not loaded in constructor
        $studentModel = $this->studentModel ?? new \App\Models\StudentModel();
        $attendanceModel = $this->attendanceModel ?? new \App\Models\AttendanceModel();
        $guardianModel = $this->guardianModel ?? new \App\Models\GuardianModel();
        $admission_Model = $this->guardianModel ?? new \App\Models\Admission_Model();
        $userModel = new \App\Models\UserModel();
        $model = new \App\Models\CustomizeThemeModel();
        $settingsRow = $model->SettingsMessage();
        log_message('debug', 'Settings Row: ' . print_r($settingsRow, true));

        $settings = is_array($settingsRow) ? $settingsRow : [];

        // Find student by QR code
        $student = $studentModel->where('qr_code', $qrId.'.png')->first();
        $guardian = $guardianModel->getUserIdByQrCode($qrId.'.png');
        log_message('error', 'pagwala: ' . ($student ? 'may student' : 'wala student') . ' at ' . ($guardian ? 'may guardian' : 'wala guardian'));


        // Determine user ID from student or guardian
        if ($student !== null) {
            if (is_array($student)) {
                $userId = $student['user_id'] ?? null;
            } elseif (is_object($student)) {
                $userId = $student->user_id ?? null;
            } else {
                $userId = null;
            }
        } elseif ($guardian !== null) {
            if (is_array($guardian)) {
                $userId = $guardian['user_id'] ?? null;
            } elseif (is_object($guardian)) {
                $userId = $guardian->user_id ?? null;
            } else {
                $userId = null;
            }
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Student or guardian not found.'
            ], 404);
        }
        if ($userId === null) {
            return $this->respond([
                'success' => false,
                'message' => 'User  ID not found.'
            ], 404);
        }

        // Now use $userId in your attendance query
        $attendance = $attendanceModel->where('user_id', $userId)
                                    ->where('date', $date)
                                    ->first();

        if (!$attendance) {
            // No attendance record yet, mark arrival
            $insertData = [
                'user_id' => $userId,
                'date' => $date,
                'arrival_time' => $time,
                'status' => 'Present'
            ];

            if (!$attendanceModel->insert($insertData)) {
                return $this->failServerError('Failed to save attendance');
            }
             $studentDetails = $studentModel->getdataStudent($userId);
            $contactNumber = $studentDetails->contact_number ?? '';
            $username = $studentDetails->first_name ?? '';
            

            // Normalize contact number to start with 63
            if (preg_match('/^0\d{10}$/', $contactNumber)) {
                $contactNumber = '63' . substr($contactNumber, 1);
            } elseif (preg_match('/^\+63/', $contactNumber)) {
                $contactNumber = str_replace('+', '', $contactNumber);
            }

            if (isset($settings['email_enabled']) && $settings['email_enabled'] == 1) {

    // Get user data
    $userResult = $admission_Model->getAll($userId);

    if (!empty($userResult)) {
        log_message('info', 'User data found for userId ' . $userId . ': ' . print_r($userResult, true));
    } else {
        log_message('warning', 'No user data found for userId ' . $userId);
    }

    $user = !empty($userResult) ? $userResult[0] : null;
    $emailSent = false;

    // Send Email
    if ($user && !empty($user['email'])) {
        $email = \Config\Services::email();
        $email->setFrom('ecohaven28@gmail.com', 'Brightside');
        $email->setTo($user['email']);
        $email->setSubject('Child Arrival Notification');
        $email->setMessage("
            <p>Dear Parent/Guardian,</p>
            <p>This is to inform you that your child <strong>{$user['nickname']}</strong> has arrived at <strong>{$time}</strong> on <strong>{$date}</strong>.</p>
            <p>Thank you.</p>
        ");

        if ($email->send()) {
            $emailSent = true;
            log_message('info', 'Email sent successfully to ' . $user['email']);
        } else {
            log_message('error', 'Email sending failed: ' . $email->printDebugger(['headers']));
        }
    }
}

// ✅ Send SMS if enabled
if (isset($settings['sms_enabled']) && $settings['sms_enabled'] == 1 && !empty($contactNumber)) {

    try {
        $ch = curl_init();

        $parameters = [
            'apikey' => '5f2f71805ebd9df167abafa73c4cda61',
            'number' => $contactNumber,
            'message' => "Hello, your child {$username} arrived at school at {$time} on {$date}. - Brightside",
            'sendername' => 'Brightside'
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        log_message('debug', 'SMS API response: ' . $output);

        $response = json_decode($output, true);
        if (isset($response['errors'])) {
            log_message('error', 'SMS Error: ' . json_encode($response['errors']));
        } else {
            log_message('info', 'SMS sent successfully to ' . $contactNumber);
        }
    } catch (Exception $e) {
        log_message('error', 'SMS Exception: ' . $e->getMessage());
    }
}

// ✅ Final response
return $this->respond([
    'success' => true,
    'message' => 'Arrival marked successfully.',
    'email_sent' => $emailSent ?? false
]);


            

           
        } elseif ($attendance && empty($attendance->leave_time)) {
                           $userResult = $admission_Model->getAll($userId);

// Log whether user data was found
if (!empty($userResult)) {
    log_message('info', 'User data found for userId ' . $userId . ': ' . print_r($userResult, true));
} else {
    log_message('warning', 'No user data found for userId ' . $userId);
}

$user = !empty($userResult) ? $userResult[0] : null;

            // Mark pickup
            $updateData = [
                'leave_time' => $time,
                'picked_up_by' => $qrId,
            ];
            if (!$attendanceModel->update($attendance->id, $updateData)) {
                return $this->failServerError('Failed to update attendance');
            }
            // Get guardian full name
            $guardianDetails = $guardianModel->guardianData($qrId.'.png');
            $guardianName = $guardianDetails->full_name ?? 'Unknown';
            // Get student contact number
            $studentDetails = $studentModel->getdataStudent($userId);
            $contactNumber = $studentDetails->contact_number ?? '';
            $username = $studentDetails->first_name ?? '';
            

            // Normalize contact number to start with 63
            if (preg_match('/^0\d{10}$/', $contactNumber)) {
                $contactNumber = '63' . substr($contactNumber, 1);
            } elseif (preg_match('/^\+63/', $contactNumber)) {
                $contactNumber = str_replace('+', '', $contactNumber);
            }

            $userModel = new \App\Models\UserModel();
                          $userResult = $admission_Model->getAll($userId);

// Log whether user data was found
if (!empty($userResult)) {
    log_message('info', 'User data found for userId ' . $userId . ': ' . print_r($userResult, true));
} else {
    log_message('warning', 'No user data found for userId ' . $userId);
}

$user = !empty($userResult) ? $userResult[0] : null;

            log_message('debug', 'User data: ' . print_r($user, true));
            log_message('debug', 'contactNumber: ' .$contactNumber);


        

            if (
                isset($settings['email_enabled']) && $settings['email_enabled'] == 1 
            ){ 
                
                $email = \Config\Services::email();
                $email->setFrom('ecohaven28@gmail.com', 'Brightside');
                $email->setTo($user['email']);
                $email->setSubject('Child Arrival Notification');

                $message = "
                    <html>
                        <body>
                            <p>Dear Parent/Guardian,</p>
                            <p>This is to inform you that your child <strong>" . htmlspecialchars($username) . "</strong> was picked up at <strong>" . htmlspecialchars($time) . "</strong> on <strong>" . htmlspecialchars($date) . "</strong>.</p>
                            <p>Picked up by: <strong>" . htmlspecialchars($guardianName) . "</strong></p>
                            <p>Thank you.</p>
                        </body>
                    </html>
                ";
                $email->setMessage($message);

                if (!$email->send()) {
                    log_message('error', 'Email sending failed: ' . print_r($email->printDebugger(['headers', 'subject', 'body']), true));
                    return $this->failServerError('Attendance saved but failed to send notification email.');
                }
        
            }
            if (
                isset($settings['sms_enabled']) && $settings['sms_enabled'] == 1 &&
                !empty($contactNumber)
            ){
        
        
                try {
                    $ch = curl_init();

                    $parameters = [
                        'apikey' => '5f2f71805ebd9df167abafa73c4cda61',
                        'number' => $contactNumber,
                        'message' => "Hello, your child {$username} was picked up at school at {$time} on {$date} by {$guardianName}.",
                        'sendername' => 'Brightside'
                    ];

                    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $output = curl_exec($ch);
                    curl_close($ch);

                    log_message('debug', 'SMS API response: ' . $output);

                    $response = json_decode($output, true);
                    if (isset($response['errors'])) {
                        log_message('error', 'SMS Error: ' . json_encode($response['errors']));
                    }
                } catch (Exception $e) {
                    log_message('error', 'SMS Exception: ' . $e->getMessage());
                }
            }
        

           return $this->respond([
                'success' => true,
                'message' => 'Pickup marked successfully.'
            ]);
        
            
        } else {
            // Both arrival and pickup already recorded
            return $this->respond([
                'success' => false,
                'message' => 'Attendance already completed for today.'
            ], 409);
        }
    }
    
    public function getGuardiansByUserId($userId)
    {
        $guardianModel = new \App\Models\GuardianModel();
        $guardians = $guardianModel
            ->where('user_id', $userId)
            ->findAll();

        return $this->response->setJSON($guardians);
    }

    //lilipat
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

    
       if ($currentHour >= '24') {
            $url = base_url('mark-absentees');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch); 
            curl_close($ch);
        }
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
            return redirect()->to('/staffprofile')->with('error', 'New passwords do not match.');
        }

        $userModel = new \App\Models\UserModel(); // Replace with your actual user model
        $user = $userModel->find($userId);

        if (!$user || $currentPassword !== $user['password_hash']) {
        return redirect()->to('/staffprofile')->with('error', 'Current password is incorrect.');
        }

        // Hash and update password
        $userModel->update($userId, [
            'password_hash' => $newPassword
        ]);


        return redirect()->to('/attendance')->with('success', 'Password changed successfully.');
    }






}
