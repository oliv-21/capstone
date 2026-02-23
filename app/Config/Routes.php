<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// website
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/classes', 'Home::classes');
$routes->get('/teacher', 'Home::teacher');
$routes->get('/contact', 'Home::contact');
$routes->post('/send-contact-message', 'Home::sendContactMessage');


$routes->get('/admission', 'Home::admission');
$routes->post('/admission', 'Home::admission');


$routes->get('/signup', 'Home::signup');
$routes->post('/signupPost', 'Home::signupPost');

//reset pass
$routes->get('/resetPassword', 'AuthController::resetPassword');

//post pass
$routes->post('/selectaccountPost', 'AuthController::getUserName');


$routes->get('/select-account', 'AuthController::selectAccount');
$routes->post('/forgotpassword/getEmail', 'AuthController::getEmail');

//change password
$routes->get('forgotpassword/resetPasswordForm/(:any)', 'AuthController::resetPasswordForm/$1');

$routes->post('forgotpassword/resetPasswordSubmit','AuthController::resetPasswordSubmit');







//auth
$routes->get('/login', 'AuthController::login');
$routes->post('/loginPost', 'AuthController::loginPost');

$routes->post('/logout', 'AuthController::logoutPost');





//admin
$routes->get('/admin-dashboard', 'AdminController::admindashbord');
$routes->get('/admin-admission', 'AdminController::AdminAdmission');
$routes->post('/admin-admissionpost', 'AdminController::updateAdmissionStatus');
$routes->post('admin/enrollStudent', 'AdminController::enrollStudent');

//bago
$routes->post('admin/updateStatusInterview', 'AdminController::updateStatusInterView');


$routes->get('/admin-enrolled', 'AdminController::enrolledStudents');
$routes->post('/update-student-enrolled', 'AdminController::studentEditPostEnrolled');

$routes->get('/admin-archived', 'AdminController::archived');

//admin-archvie
$routes->post('/admin-archived-restore', 'AdminController::restore');

//admin-summary attendance
$routes->get('/admin-attendance', 'AdminController::attendance');

//admin-chat
$routes->get('/admin-chats', 'MessageController::indexAdmin');
$routes->get('/admin-chats/(:num)', 'MessageController::indexAdmin/$1');
$routes->post('student-chat/send-admin', 'MessageController::sendAdmin');

//admin-accountManagement
$routes->get('/admin-accountManagement', 'AdminController::accountManagement');
$routes->post('/admin-accountManagementpost', 'AdminController::accountManagementPost');
$routes->post('/admin-accountManagementTeacherpost', 'AdminController::teacherpdatePost');
   
$routes->post('/admin-addTeacher', 'AdminController::addTeacher');

$routes->get('admin/getGuardianDetails/(:num)', 'AdminController::studentDetails/$1');

$routes->get('admin/getTeacherDetails/(:num)', 'AdminController::teacherDetails/$1');




//admin-announcement  announcement
$routes->get('/admin-announcement', 'AdminController::announcement');
$routes->post('/admin-announcementPost', 'AdminController::announcementPost');
    
$routes->post('admin/updateAnnouncement', 'AdminController::updateAnnouncement');
$routes->post('admin/deleteAnnouncement/(:num)', 'AdminController::deleteAnnouncement/$1');


//admin-settings
$routes->get('/admin-settings', 'AdminController::settings');
$routes->post('/settings/customize', 'AdminController::settingPost');



//admin-payment
$routes->get('/admin-payment', 'AdminController::payment');

$routes->post('admin/saveCashPayment','Payment::payCash');
$routes->get('payments/history/(:num)', 'Payment::getHistory/$1');
$routes->get('/student-paycash/(:num)', 'AdminController::studentpay/$1');
$routes->post('/admin/payment_cash','Payment::payCashEnrollment');

// $routes->get('/guardian-report/(:num)', 'GuardianAccountController::generatereport/$1');




//admin-open admission
$routes->get('/admin-openAdmission', 'AdminController::openAdmission');
$routes->post('/admission/save', 'AdminController::save');

//admin-prifle
$routes->get('/adminProfile', 'AdminController::adminProfile');
$routes->post('admin/updateProfile', 'AdminController::adminProfilepost');
$routes->post('admin/changePassword', 'AdminController::resetPasswordPost');

//admin  print
$routes->get('admin/print-student/(:num)', 'AdminController::printStudent/$1');

//admin print payment
$routes->get('admin/generateReport' , 'Payment::printpayment');

$routes->post('admin/print_report', 'AdminController::printReport');


//admin generate id
$routes->get('admin/generateId/(:num)', 'AdminController::generateId/$1');




//user-students
$routes->get('/student-dashboard', 'StudentsController::DasboardUser');
$routes->get('/student-guardiansetup', 'StudentsController::GuardianSetup');
$routes->post('/user/GuardianSetupPost', 'StudentsController::GuardianSetupPost');

$routes->post('guardian/remove/(:num)', 'StudentsController::GuardianSetupDelete/$1');


//student-payment
$routes->get('/student-paymentInfo', 'StudentsController::paymentInfo');



//student-learningmaterial
$routes->get('/student-interactive-learning', 'StudentsController::InteractiveLearning');

$routes->get('/student-coloring-game', 'StudentsController::coloringGame');

$routes->get('/student-shape-game', 'StudentsController::shapeGame');

$routes->get('/student-animal-game', 'StudentsController::animalGame');

$routes->get('/student-number-game', 'StudentsController::numberGame');

$routes->get('/student-color-game', 'StudentsController::colorGame');


//student-classes
$routes->get('/student-classes', 'StudentsController::classes');


//elca add
$routes->get('/student-attendance', 'StudentsController::attendance');
$routes->get('/student-resetPassword', 'StudentsController::resetPassword');
$routes->post('/reset-password', 'StudentsController::resetPasswordPost');
$routes->get('/student-profile', 'StudentsController::profile');
$routes->post('/update_profilepost', 'StudentsController::profileipdate'); 

$routes->get('/student-progress-report', 'StudentsController::progressreport');

//user-chat
$routes->get('student-chat', 'MessageController::index');
$routes->get('student-chat/(:num)', 'MessageController::index/$1');
$routes->post('student-chat/send', 'MessageController::send');




//attendance-monitor

$routes->get('/attendance', 'AttendanceController::attendance');
$routes->post('/attendance/mark-arrival', 'AttendanceController::markArrival');
$routes->post('attendance/mark-pickup', 'AttendanceController::markPickup');
$routes->get('guardians/(:num)', 'AttendanceController::getGuardiansByUserId/$1');
$routes->get('/mark-absentees', 'AttendanceController::markDailyAbsentees');


//staffprofile
$routes->get('/staffprofile', 'AttendanceController::staffprofile');
$routes->post('staff/updateProfile', 'AttendanceController::staffprofilepost');
$routes->post('staff/chage-password', 'AttendanceController::resetPasswordPost');




//payment 
$routes->post('payment/create_payment_link', 'Payment::create_payment_link');
$routes->get('payment/success', 'Payment::success');

$routes->get('payment/failed', 'Payment::failed');



$routes->post('user/create_payment_link', 'Payment::payment_link');
$routes->get('registration/success', 'Payment::payOnlineEnrollment');
$routes->get('registration/failed', 'GuardianAccountController::payOnlineEnrollmentFailed');


//qrscanner
$routes->get('qrscanner', 'QrScannerController::scanner');
$routes->post('qrscanner/processScan', 'QrScannerController::processScan');
$routes->post('attendance/mark-arrivalqr', 'AttendanceController::markArrivalqrcode');
$routes->post('attendance/mark-pickupqr', 'AttendanceController::pickupQRcode');


$routes->post('attendance/mark-scan', 'AttendanceController::markArrival');



//teacher


$routes->get('/teacher-dashboard', 'TeacherController::teacherDashboard');

$routes->get('/teacher-annoucement', 'TeacherController::teacherAnnouncement');
$routes->post('/teacher-announcementPost', 'TeacherController::announcementPost');

$routes->post('teacher/updateAnnouncement', 'TeacherController::updateAnnouncement');
$routes->post('teacher/deleteAnnouncement/(:num)', 'TeacherController::deleteAnnouncement/$1');

$routes->get('/teacher-grades', 'TeacherController::teacherGrades');

$routes->get('/teacher-materials', 'TeacherController::teacherMaterial');
$routes->post('/uploadClassRoom', 'TeacherController::classroomPost');
$routes->get('teacher/deleteMaterial/(:num)', 'TeacherController::deleteMaterial/$1');

$routes->get('/teacher-students', 'TeacherController::teacherStudents');

$routes->get('/teacher-progress-report/(:num)', 'TeacherController::teacherprogressreport/$1');
$routes->post('/teacher-progress-report-post/(:num)', 'TeacherController::teacher_progress_report_post/$1');


$routes->get('/teacherProfile', 'TeacherController::teacherProfile');
$routes->post('/teacherUpdateProfile', 'TeacherController::adminProfilepostTeacher');
$routes->post('/teacherChangePassword', 'TeacherController::teacherResetPasswordPost');

$routes->get('/teacher-interactive-learning', 'TeacherController::InteractiveLearning');
$routes->get('/teacher-coloring-game', 'TeacherController::coloringGame');
$routes->get('/teacher-shape-game', 'TeacherController::shapeGame');
$routes->get('/teacher-animal-game', 'TeacherController::animalGame');
$routes->get('/teacher-number-game', 'TeacherController::numberGame');
$routes->get('/teacher-color-game', 'TeacherController::colorGame');

$routes->get('/teacher-chats', 'MessageController::indexTeacher');
$routes->get('/teacher-chats/(:num)', 'MessageController::indexTeacher/$1');
$routes->post('teacher-chat/teacher-send', 'MessageController::sendTeacher');

$routes->get('/teacher-student-highlight/(:num)', 'TeacherController::teacherUploadHighlight/$1');
$routes->post('/photo-wall/save', 'TeacherController::saveUpload');
$routes->post('/photo-wall/delete', 'TeacherController::DeleteUpload');

$routes->get('/teacherProfile-info', 'TeacherController::teacherProfileInfo');
$routes->post('/update_profilepost-teacher', 'TeacherController::profileipdateTeacher'); 

//Guardian

$routes->get('/guardian-account/(:num)', 'Home::guardianAccount/$1');

$routes->get('/guardian/dashboard', 'GuardianAccountController::mainDashboard');
$routes->get('/guardian/dashboard/(:num)', 'GuardianAccountController::mainFromStudentDashboard/$1');

$routes->get('/guardian/dashboard-highlight/(:num)', 'GuardianAccountController::studentViewDashboardHighlight/$1');


$routes->get('/guardian-admission', 'GuardianAccountController::GuardianAdmission');
$routes->get('/guardian/edit-student/(:num)', 'GuardianAccountController::studentEdit/$1');
$routes->post('/guardianadmission', 'Home::admission');


$routes->post('/admissionpost', 'GuardianAccountController::AdmissionPost');
$routes->get('/Studentview/(:num)', 'GuardianAccountController::studentView/$1');
$routes->get('/guardian/delete-student/(:num)', 'GuardianAccountController::deleteStudent/$1');
$routes->get('/StudentviewDashboard/(:num)', 'GuardianAccountController::studentViewDashboard/$1');

$routes->post('guardian/update-student/(:num)', 'GuardianAccountController::studentEditPost/$1');

$routes->get('/payment-history/(:num)', 'GuardianAccountController::Parenthistory/$1');

$routes->get('/guardian-resetPassword', 'GuardianAccountController::resetPassword');
$routes->post('/guardian-reset-password', 'GuardianAccountController::resetPasswordPostGuardian');

$routes->get('payment/redirect' , 'Payment::redirectpayment');
$routes->get('payment/redirect-miscellaneous' , 'Payment::redirectpaymentMicelenious');
$routes->get('payment/redirect-tuition' , 'Payment::redirectpaymentTuition');

$routes->get('/guardian-report/(:num)', 'GuardianAccountController::generatereport/$1');


//payment
$routes->get('/parent-paymentInfo/(:num)', 'GuardianAccountController::paymenParent/$1');
$routes->get('/get-payments/(:num)/(:num)', 'GuardianAccountController::getPaymentsByPlan/$1/$2');
$routes->get('/get-paymentsutition/(:num)/(:num)', 'GuardianAccountController::tuition/$1/$2');

//guardian payment
$routes->post('pay-miscellaneous', 'Payment::processBulkPayment');
$routes->post('payment-link-miscellaneous' , 'Payment::payment_linkMiscellaneous');
$routes->get('miscellaneous/success', 'Payment::payOnline');


$routes->post('payment-link-Tuition' , 'Payment::payment_linkTuition');
$routes->get('tuition/success', 'Payment::payOnlineTuition');


$routes->get('/parent-paymentInfo-tuituin/(:num)', 'GuardianAccountController::paymenParentTuition/$1');

$routes->post('computation' , 'GuardianAccountController::compute_totals');
$routes->post('/parent-paymentInfo-tuituin/computation', 'GuardianAccountController::compute_totals');

$routes->get('/admin-paymentInfo/(:num)', 'AdminController::paymentMiscCash/$1');
$routes->post('payment-Miscellaneous' , 'Payment::payCashMics');

$routes->get('/admin-paymentTuition/(:num)', 'AdminController::paymentTuitioncCash/$1');
$routes->post('payment-Tuition' , 'Payment::payCashTuition');


$routes->get('/guardian-Profile', 'GuardianAccountController::ProfileEdit');
$routes->post('/gardian-update-profilepost', 'GuardianAccountController::updateProfile'); 

$routes->get('/guardian-announcement/(:num)', 'GuardianAccountController::guardianAnnouncement/$1');


$routes->get('notifications/markAsRead/(:num)', 'AdminController::markAsRead/$1');


$routes->get('/admin-add-admin-account', 'AdminController::AddAdminAccount');
$routes->post('/add-admin-account', 'AdminController::AddAdminAccountPost');

$routes->get('admin/getAdminDetails', 'AdminController::adminDetails');
$routes->get('admin/getAdminDetails/(:num)', 'AdminController::getAdminDetails/$1');
$routes->post('admin/updateAdminAccount/(:num)', 'AdminController::editAdmin/$1');




//===dec4
$routes->post('/set-opening-id', 'GuardianAccountController::setOpeningId');
