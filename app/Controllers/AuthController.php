<?php

namespace App\Controllers;
use App\Models\GuardianModel;
use App\Models\Teacher_Model;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login(): string
    {
        return view('website/login');
    }

    public function loginPost()
    {
        $session = session();
        $figurdian = new GuardianModel();
        $userModel = new UserModel();
        $teacherModel = new \App\Models\Teacher_Model();
         $adminStaffModel  = new \App\Models\AdminStaffModel();
        $openingModel = new \App\Models\OpeningModel();
        $opening = $openingModel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }

        //set session properly
       $session->set(['opening_id' => $opening['id']]);

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (!$this->validate([
            'username' => 'required|min_length[1]|max_length[50]',
            'password' => 'required|min_length[3]'
        ])) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }

        $user = $userModel->where('username', $username)->first();

        // if ($user && password_verify($password, $user['password_hash'])) {
        if ($user && $password === $user['password_hash']) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true
            ]);

            if ($user['role'] == 'admin') {
                $adminStaff = $adminStaffModel->where('user_id', $user['id'])->first();

                // Build full name
                $fullName = $adminStaff['firstname'] 
                        . (!empty($adminStaff['middlename']) ? ' ' . $adminStaff['middlename'] : '') 
                        . ' ' . $adminStaff['lastname'];
                if ($adminStaff['status'] !== 'active') {
                    return redirect()->back()->with('error', 'Your admin account is not active.');
                }

                // Set session
                $session->set([
                    
                    'admin_role'     => $adminStaff['role'],
                    'can_access_all' => ($adminStaff['role'] === 'Admin'), 
                    'full_name Admin'      => $fullName, 
                    'profile_pic'    => $adminStaff['profilepic'], 
                    'logged_in'      => true
                ]);

                return redirect()->to('/admin-dashboard');
               
            } elseif ($user['role'] == 'student') {
                
                $guardian = $figurdian->findguardian($user['id']);

                if (!empty($guardian)) {
                    return redirect()->to('/student-dashboard');
                } else {
                    return redirect()->to('/student-guardiansetup');
                }

            } elseif ($user['role'] == 'attendance_monitor') {
                return redirect()->to('/attendance');
            } elseif ($user['role'] == 'teacher') {
                // ✅ Check if teacher profile is incomplete
                if ($teacherModel->isProfileIncomplete($user['id'])) {
                    return redirect()->to('/teacherProfile-info');
                } else {
                    return redirect()->to('/teacher-dashboard');
                }
            } elseif ($user['role'] == 'parent') {

                return redirect()->to('/guardian/dashboard');
            } else {
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Invalid username or password.');
             log_message('debug', 'Invalid username or password');
        
            return redirect()->to('/login');
        }
    }

    public function admindashbord(): string
    {
        return view ('admin/dashboard');
    }
    

    //pang email
    public function resetPassword(): string
    {
        return view('website/forgot-password');
    }


    public function getUserName()
    {
        $email = $this->request->getPost('resetEmail');
        $userModel = new \App\Models\UserModel();
        $usernames = $userModel->getUsernamesByEmail($email);

        if ($usernames) {
            return view('website/select_account', [
                'users' => $usernames,
                'email' => $email
            ]);
        } else {
            return redirect('resetPassword')->back()->with('error', 'Email not found.');
        }
    }
    private function generateUniqueToken($userModel)
    {
        do {
            $token = bin2hex(random_bytes(50));
            $existing = $userModel->where('reset_token', $token)->first();
        } while ($existing); 

        return $token;
    }

    
    public function getEmail()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $userModel = new \App\Models\UserModel();
        $emailRow = $userModel->getEmailByUsername($username);

        if ($emailRow && isset($emailRow['email'])) {
            $email = $emailRow['email'];
            $token = $this->generateUniqueToken($userModel);
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            
            $userModel->saveResetToken($username, $token, $expiry);

            $resetLink = base_url("forgotpassword/resetPasswordForm/$token");

            
            $emailService = \Config\Services::email();
            $emailService->setFrom('ecohaven28@gmail.com', 'Brightside');
            $emailService->setTo($email);
            $emailService->setMailType('html'); // Important!
            
           $message = '
                <div style="font-family: Nunito, sans-serif; color:rgb(253, 216, 238); background-color: #ffffff; padding: 30px; border-radius: 10px;">
                    <h2 style="color: #ff6b6b; text-shadow: 1px 1px #000;"> Password Reset</h2>
                    <p style="color: #555;">Hello <strong style="color: #c14444;">' . esc($username) . '</strong>,</p>
                    <p style="color: #666;">You requested a password reset. Click the link below to continue:</p>

                    <div style="text-align: center; margin: 20px 0;">
                        <a href="' . $resetLink . '" style="
                            color:rgb(0, 0, 0);
                            text-decoration: underline;
                            font-weight: bold;
                            word-wrap: break-word;
                        ">' . $resetLink . '</a>
                    </div>

                    <p style="color: #888;">This link will expire in <strong>1 hour</strong>.</p>
                    <p style="color: #999;">Thanks,<br><strong style="color: #ff6b6b;">Brightside Team</strong></p>
                </div>
                ';


            $emailService->setMessage($message);


            if ($emailService->send()) {
                $session = session();
                
                $session->setFlashdata('intraction', 'Please check your email for password reset instructions.');
                return redirect()->to('/login');
            } else {
                 
                $session->setFlashdata('error', 'Please contact the Admin  of the school');
                return redirect()->to('/login');
            }
        } else {
                $session->setFlashdata('error', 'Please check your email');
                return redirect()->to('/login');
        }
    }

    public function resetPasswordForm($token)
    {
        $userModel = new \App\Models\UserModel();
        $tokenData = $userModel->getResetTokenData($token);
        $usernameData = $userModel->getUsernameData($token);
        $username = $usernameData['username'] ?? '';

        $data = [
            'token' => $token,
            'username' =>$username,
        ];

        if ($tokenData && isset($tokenData['token_expiry']) && strtotime($tokenData['token_expiry']) > time()) {
            return view('website/reset-password', $data);
        } else {
            // Token is expired or invalid
            return redirect('login')->back()->with('error', 'Password request has expired. Please try again.');
        }
    }

	public function selectAccount(): string
    {
        return view('website/select_account');
    }

    public function resetPasswordSubmit()
    {
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $userModel = new \App\Models\UserModel();
        $tokenData = $userModel->getResetTokenData($token);

        if (!$tokenData || strtotime($tokenData['token_expiry']) < time()) {
             return redirect('/login')->back()->with('error', 'Passwords reuest is expired please try again.');
        }

        // Hash and save new password
        // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $userModel->update($tokenData['id'], ['password_hash' => $newPassword, 'reset_token' => null, 'token_expiry' => null]);
        return redirect()->to('/login')->with('successful', 'Password successfully updated.');
    }
    public function logoutPost()
    {
        $session = session();

        $session->destroy();

        return redirect()->to('/login')
            ->with('success', 'You have been logged out successfully.');
    }





}
