<?php
namespace App\Controllers;
use App\Models\MessageModel;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\GuardianModel;
use App\Models\NotificationModel;
use App\Models\GuardiansAccountModel;
use App\Models\AdminStaffModel;
use App\Models\Admission_Model;
use App\Models\Teacher_Model;
use CodeIgniter\Controller;

class MessageController extends BaseController
{
    public function index($receiverId = null)
    {
        helper('time'); // assuming your file is named TimeHelper.php

        $session = session();
        $currentUserId = $session->get('user_id');
        $role = $session->get('role');

        $messageModel = new MessageModel();
        $userModel = new UserModel();
        $studentModel = new \App\Models\GuardiansAccountModel();
        $notificationmodel = new \App\Models\NotificationModel();
        $guardianModel      = new GuardiansAccountModel();
        $teacherModel = new \App\Models\Teacher_Model();
        $adminStaffModel = new \App\Models\AdminStaffModel();
        $admissionModel    = new Admission_Model();
        $studentinfo         = $guardianModel      -> getGuardiandata($currentUserId);
        $childrens           = $admissionModel     -> getChildrenByGuardian($currentUserId);

        $contacts = $messageModel->getContacts($currentUserId, $role);
        log_message('info', 'Retrieved contacts for user_id ' . var_export($currentUserId, true) . ' | Contacts: ' . print_r($contacts, true));


        $messages = $receiverId ? $messageModel->getMessages($currentUserId, $receiverId) : [];
        $receiver = null;
        if ($receiverId) {
            $receiver = $studentModel->GuardianInfo($receiverId)
                ?? $teacherModel->profileFullname($receiverId)
                ?? $adminStaffModel->profileandfullname($receiverId);
        }
       

        return view('guardian/guardian-chat', [
            'childrens'           => $admissionModel     -> getChildrenByGuardian($currentUserId),
            'unread_announcement'  => $notificationmodel -> countAnnoucment($currentUserId),
            'contacts' => $contacts,
            'messages' => $messages,
            'receiver' => $receiver,
            'students' => $studentinfo,
        ]);
    }

    public function send()
    {
        $session = session();
        $messageModel = new MessageModel();

        $receiver_id = $this->request->getPost('receiver_id');

        $messageModel->save([
            'sender_id' => $session->get('user_id'),
            'receiver_id' => $receiver_id,
            'message' => $this->request->getPost('message'),
            // 'sent_at' => date('Y-m-d H:i:s') // if you're using manual timestamping
        ]);

        return redirect()->to('student-chat/' . $receiver_id);
    }



    // public function indexAdmin($receiverId = null)
    // {
    //     helper('time'); // assuming your file is named TimeHelper.php

    //     $session = session();
    //     $currentUserId = $session->get('user_id');
    //     $role = $session->get('role');

    //     $messageModel = new MessageModel();
    //     $userModel = new UserModel();
    //     $StudentModel = new StudentModel();
    //      $profilepicModel = new \App\Models\AdminStaffModel();
        
        

    //     $contacts = $messageModel->getContacts($currentUserId,$role);
    //     log_message('info', 'Retrieved contacts for user_id ' . var_export($currentUserId, true) . ' | Contacts: ' . print_r($contacts, true));


    //     $messages = $receiverId ? $messageModel->getMessages($currentUserId, $receiverId) : [];

    //     $receiver = $receiverId ? $StudentModel->profileandfullname($receiverId) : null;
    //     $profilepic = $profilepicModel ->profilepic();
        
    //     return view('admin/chat', [
    //         'contacts' => $contacts,
    //         'messages' => $messages,
    //         'receiver' => $receiver,
    //         'profilepic' => $profilepic,
    //     ]);
    // }
    public function indexAdmin($receiverId = null)
    {
        helper('time');

        $session = session();
        $currentUserId = $session->get('user_id');
        $role = $session->get('role');

        $messageModel = new \App\Models\MessageModel();
        $userModel = new \App\Models\UserModel();
        $studentModel = new \App\Models\GuardiansAccountModel();
        $teacherModel = new \App\Models\Teacher_Model();
        $adminStaffModel = new \App\Models\AdminStaffModel();

        // ✅ Fetch contacts based on role (students, teachers, admin)
        $contacts = $messageModel->getContacts($currentUserId, $role);
        log_message('info', 'Retrieved contacts for user_id ' . var_export($currentUserId, true) . ' | Contacts: ' . print_r($contacts, true));

        // ✅ Get conversation messages
        $messages = $receiverId ? $messageModel->getMessages($currentUserId, $receiverId) : [];

        // ✅ Identify receiver details (student → teacher → admin)
        $receiver = null;
        if ($receiverId) {
            $receiver = $studentModel->GuardianInfo($receiverId)
                ?? $teacherModel->profileFullname($receiverId)
                ?? $adminStaffModel->profileandfullname($receiverId);
        }

        // ✅ Get the logged-in user’s profile picture
        $profilepic = $adminStaffModel->profilepic();

        return view('admin/chat', [
            'contacts'   => $contacts,
            'messages'   => $messages,
            'receiver'   => $receiver,
            'profilepic' => $profilepic,
        ]);
    }

    public function sendAdmin()
    {
        $session = session();
        $messageModel = new MessageModel();

        $receiver_id = $this->request->getPost('receiver_id');

        $messageModel->save([
            'sender_id' => $session->get('user_id'),
            'receiver_id' => $receiver_id,
            'message' => $this->request->getPost('message'),
           
        ]);

        return redirect()->to('admin-chats/' . $receiver_id);
    }

    public function indexTeacher($receiverId = null)
    {
        helper('time');

        $session = session();
        $currentUserId = $session->get('user_id');
        $role = $session->get('role');

        $messageModel = new \App\Models\MessageModel();
        $userModel = new \App\Models\UserModel();
        $studentModel = new \App\Models\GuardiansAccountModel();
        $teacherModel = new \App\Models\Teacher_Model();
        $adminStaffModel = new \App\Models\AdminStaffModel();
        $profilepicModel = new \App\Models\Teacher_Model();

        // ✅ Fetch contacts based on role (students, teachers, admin)
        $contacts = $messageModel->getContacts($currentUserId, $role);
        log_message('info', 'Retrieved contacts for user_id ' . var_export($currentUserId, true) . ' | Contacts: ' . print_r($contacts, true));

        // ✅ Get conversation messages
        $messages = $receiverId ? $messageModel->getMessages($currentUserId, $receiverId) : [];

        // ✅ Identify receiver details (student → teacher → admin)
        $receiver = null;
        if ($receiverId) {
            $receiver = $studentModel->GuardianInfo($receiverId)
                ?? $teacherModel->profileFullname($receiverId)
                ?? $adminStaffModel->profileandfullname($receiverId);
        }

        // ✅ Get the logged-in user’s profile picture
        $profilepic = $adminStaffModel->profilepic();

        return view('teacher/teacher-chat', [
            'teacher' => $profilepicModel ->teacherData($currentUserId),
            'profilepics' => $profilepicModel ->profilepic(),
            'contacts'   => $contacts,
            'messages'   => $messages,
            'receiver'   => $receiver,
            'profilepic' => $profilepic,
        ]);
    }
    public function sendTeacher()
    {
        $session = session();
        $messageModel = new MessageModel();

        $receiver_id = $this->request->getPost('receiver_id');

        $messageModel->save([
            'sender_id' => $session->get('user_id'),
            'receiver_id' => $receiver_id,
            'message' => $this->request->getPost('message'),
           
        ]);

        return redirect()->to('teacher-chats/' . $receiver_id);
    }



}
