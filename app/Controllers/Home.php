<?php

namespace App\Controllers;
use App\Models\Admission_Model;
use App\Models\ClassModel;
use App\Models\NotificationModel;
use CodeIgniter\Email\Email;
use App\Models\UserModel;
use App\Models\GuardiansAccountModel;
use App\Models\OpeningModel;

class Home extends BaseController
{
     protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
   public function index(): string
	{
		$openingModel = new OpeningModel();
		$isAdmissionOpen = $openingModel->isAdmissionOpen();

		$data = [
			'isAdmissionOpen' => $isAdmissionOpen 
		];

		return view('index', $data);
	}

	
	public function about(): string
    {
        return view('website/about');
    }
	public function classes(): string
    {
        return view('website/class');
    }
	public function teacher(): string
    {
        return view('website/teacher');
    }
	public function contact(): string
    {
        return view('website/contact');
    }
	public function sendContactMessage()
	{
		$name = $this->request->getPost('name');
		$email = $this->request->getPost('email');
		$subject = $this->request->getPost('subject');
		$message = $this->request->getPost('message');

		// Validate inputs (optional but recommended)
		if (!$name || !$email || !$subject || !$message) {
			return redirect()->back()->with('error', 'Please fill all fields.');
		}

		$emailService = \Config\Services::email();

		$emailService->setFrom($email, $name);
		$emailService->setTo('ecohaven28@gmail.com');
		$emailService->setSubject($subject);
		
		$body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
		$emailService->setMessage($body);

		if ($emailService->send()) {
			return redirect()->back()->with('success', 'Message sent successfully!');
		} else {
			// To debug email errors, uncomment this line:
			// log_message('error', $emailService->printDebugger(['headers']));
			return redirect()->back()->with('error', 'Failed to send message. Please try again.');
		}
	}
	public function login(): string
    {
        return view('website/login');
    }
	public function admission()
    {
        $session = session();
        $openingModel = new OpeningModel();
        $isAdmissionOpen = $openingModel->isAdmissionOpen();

        $admission_model = new Admission_Model();
        $class_model = new \App\Models\ClassModel();
        $notification = new NotificationModel();

        // Prepare data for the view
        $data = [
            'isAdmissionOpen' => $isAdmissionOpen,
            'classes' => $class_model->findAll()
        ];

        if ($this->request->is('post') && $isAdmissionOpen) {
            $post = $this->request->getPost([
                'first_name', 'middle_name', 'last_name', 'nickname',
                'nationality', 'gender', 'birthday', 'age', 'class_applied',
                'father_name', 'father_occupation', 'mother_name', 'mother_occupation',
                'contact_number', 'email','municipality','barangay','street'
            ]);

            $post = array_map(fn($val) => trim(strip_tags($val)), $post);

            // Handle file upload
            $pictureFile = $this->request->getFile('picture');
            if ($pictureFile && $pictureFile->isValid() && !$pictureFile->hasMoved()) {
                $newName = $pictureFile->getRandomName();
                $pictureFile->move('public/assets/profilepic', $newName);
                $post['picture'] = $newName;
            }

            $rules = [
                'first_name' => 'required|regex_match[/^[A-Za-z\s\-]{2,100}$/]',
                'last_name' => 'required|regex_match[/^[A-Za-z\s\-]{2,100}$/]',
                'nationality' => 'required|regex_match[/^[A-Za-z\s\-]{2,100}$/]',
                'gender' => 'required|in_list[male,female,other]',
                'birthday' => 'required|valid_date[Y-m-d]',
                'age' => 'required|integer|greater_than[0]',
                'class_applied' => 'required',
                'father_name' => 'required|regex_match[/^[A-Za-z\s\-]{2,100}$/]',
                'mother_name' => 'required|regex_match[/^[A-Za-z\s\-]{2,100}$/]',
                'contact_number' => 'required|numeric|min_length[10]|max_length[11]',
                'email' => 'required|valid_email'
            ];

            if (!$this->validate($rules)) {
                $data['validate_msg'] = $this->validator;
            } else {
                $admission_model->save($post);

                $notification->insert([
                    'user_id' => 1,
                    'title' => 'New Admission',
                    'message' => 'A new admission has been submitted by ' . $post['first_name'] . ' ' . $post['last_name'],
                    'type' => 'admission',
                    'is_read' => 0
                ]);

                $session->setFlashdata('msg_success', '✅ Admission successfully submitted! Please wait for email.');
                return redirect()->to('admission');
            }
        }

        return view('website/admission', $data);
    }
    public function signup(): string
    {
        return view('website/signup');
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
   
    public function signupPost()
    {
        $guardianModel = new GuardiansAccountModel();
        $userModel     = new \App\Models\UserModel();
        $db            = \Config\Database::connect();

        $request = service('request');
        $username = trim($request->getPost('username'));
        $first_name  = trim($request->getPost('first_name'));
        $middle_name = trim($request->getPost('middle_name'));
        $last_name   = trim($request->getPost('last_name'));
        $relationship = $request->getPost('relationship') === 'Other' 
                        ? $request->getPost('other_relationship') 
                        : $request->getPost('relationship');
        $contact_number = trim($request->getPost('contact_number'));
        $email = trim($request->getPost('email'));
        $password = $request->getPost('password');
        $confirm_password = $request->getPost('confirm_password');
        $municipality = $request->getPost('municipality');
        $barangay = $request->getPost('barangay');
        $street = trim($request->getPost('street'));

        // Password match check
        if ($password !== $confirm_password) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        // Check if user exists
        $existing = $userModel
            ->where('email', $email)
            ->first();

        if ($existing) {
            $userId = $existing['id'];
            return redirect()->to(base_url('/guardian-account/' . $userId))
                            ->with('info', 'Email or username already registered. Continue setting up guardian account.');
        }

        try {
            // Start transaction
            $db->transStart();

            // Generate unique username
            $username = $this->generateUniqueUsername($username);

            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert into users table
            $userData = [
                'username'      => $username,
                'password_hash' => $password, 
                'email'         => $email,
                'role'          => 'parent',
                'status'        => 'pending'
            ];
            $userModel->insert($userData);
            $userId = $db->insertID();

            log_message('info', 'User inserted with ID: {id}', ['id' => $userId]);

            // Insert into guardians table
            $guardianData = [
                'user_id' => $userId,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'relationship' => $relationship,
                'contact_number' => $contact_number,
                'email' => $email,
                'municipality' => $municipality,
                'barangay' => $barangay,
                'street' => $street,
                'profile_pic' => 'default.webp'
            ];
            $guardianModel->insert($guardianData);

            // Commit transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Rollback if transaction failed
                throw new \Exception('Database transaction failed.');
            }

            // Send email (optional, does not affect DB transaction)
            if ($email) {
                $emailService = \Config\Services::email();

                $emailService->setTo($email);
                $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
                $emailService->setSubject('Account Created');
                $emailService->setMailType('html');
                $emailService->setMessage("
                    <p>Dear " . esc($first_name) . " " . esc($last_name) . ",</p>
                    <p>Your guardian account has been successfully created.</p>
                    <p><strong>Username:</strong> {$username}</p>
                    <p><strong>Password:</strong> {$password}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p>You may now log in to the system using your credentials.</p>
                    <p>Please update your account immediately.</p>
                    <p>– School Admin</p>
                ");

                if (!$emailService->send()) {
                    log_message('error', 'Guardian email failed: ' . print_r($emailService->printDebugger(['headers']), true));
                } else {
                    log_message('info', 'Guardian email sent to: {email}', ['email' => $email]);
                }
            }

            // Set session
            session()->set('user_id', $userId);
            session()->set('role','parent');
            session()->set('username',$username);
            session()->set('guardian_name', $first_name);

            log_message('info', 'Guardian record inserted for user ID: {id}', ['id' => $userId]);

            return redirect()->to(base_url('guardian/dashboard'))
                            ->with('success', 'Account created successfully!');

        } catch (\Exception $e) {
            // Rollback transaction if any exception occurs
            $db->transRollback();
            log_message('error', 'Error in signupPost: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Error to register.');
        }
    }

    public function guardianAccount($user_id)
    {
        $userModel = new \App\Models\UserModel();
        $guardianModelAccount = new \App\Models\GuardiansAccountModel();

        // Get the user data by ID
        $user = $userModel->find($user_id);
        $guardianDataAccount = $guardianModelAccount->find($user_id);

        // Pass data to the view
        $data = [
            'user' => $user,
            'guardianData' => $guardianDataAccount
        ];

        return view('website/guardianAccount', $data);
    }


    

	
	
}
