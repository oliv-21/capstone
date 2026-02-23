<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PaymentModel;
use App\Models\NotificationModel;
use App\Models\StudentModel;
use App\Models\TuitionPlanModel;
use App\Models\Admission_Model;
use App\Models\OpeningModel;
use App\Models\AuditLogModel;
use App\Models\ClassModel;
use App\Models\PaymentScheduleModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use CodeIgniter\HTTP\RedirectResponse;
use Dompdf\Dompdf;

class Payment extends Controller
{
    private $paymongo_secret_key = 'sk_test_2DXNKUByRmwvaxbGzzAXGyE3';

    public function create_payment_link()
    {
        $request = service('request');
        $session = session();

        // Collect inputs
        $amount_php     = $request->getPost('amount');
        $fullname       = $request->getPost('fullname');
        $email          = $request->getPost('email');
        $number         = $request->getPost('number');
        $paymentMethod  = $request->getPost('paymentMethod'); // ex: card, gcash, dob
        $paymenttype    = $request->getPost('paymentOption');
        $card_number    = $request->getPost('cardNumber');
        $exp_month      = (int) $request->getPost('expiryMonth'); 
        $exp_year       = (int) $request->getPost('expiryYear');
        $cvc            = $request->getPost('cvv');
        $bank_code      = $request->getPost('accountName');

        // Log inputs
        log_message('info', 'Payment Data: amount={amount}, fullname={fullname}, email={email}, number={number}, method={method}, type={type}, card={card}, exp_month={month}, exp_year={year}, cvc={cvc}, bank_code={bank}', [
            'amount'   => $amount_php,
            'fullname' => $fullname,
            'email'    => $email,
            'number'   => $number,
            'method'   => $paymentMethod,
            'type'     => $paymenttype,
            'card'     => $card_number,
            'month'    => $exp_month,
            'year'     => $exp_year,
            'cvc'      => $cvc,
            'bank'     => $bank_code,
        ]);

       
        
        $studentId = $session->get('user_id');
        if (!$studentId) {
            return redirect()->to('/login');
        }

        $amount_cents = (int) $amount_php * 100;

        // STEP 1: Create Payment Intent
        $intentPayload = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_cents,
                    'payment_method_allowed' => [$paymentMethod],
                    'currency' => 'PHP',
                    'capture_type' => 'automatic',
                    'send_email_receipt' => true,
                    'receipt_email' => $email,
                    'description' => 'Student Payment',
                    'statement_descriptor' => 'StudentPay'
                ]
            ]
        ];

        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($intentPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $intentResponse = curl_exec($ch);
        curl_close($ch);
        $intentData = json_decode($intentResponse, true);

        if (!isset($intentData['data']['id'])) {
            return "Error creating payment intent: <pre>" . print_r($intentData, true) . "</pre>";
        }

        $intent_id  = $intentData['data']['id'];
        $client_key = $intentData['data']['attributes']['client_key'];

        // STEP 2: Create Payment Method
        if ($paymentMethod == 'card') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'card',
                        'details' => [
                            'card_number' => $card_number,
                            'exp_month'   => $exp_month,
                            'exp_year'    => $exp_year,
                            'cvc'         => $cvc,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } elseif ($paymentMethod == 'dob') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'dob',
                        'details' => [
                            'bank_code' => $bank_code,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } else {
            // Other redirect methods (gcash, paymaya, grab_pay, etc.)
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => $paymentMethod,
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                            'phone' => $number,
                        ]
                    ]
                ]
            ];
        }

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($methodPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $methodResponse = curl_exec($ch);
        curl_close($ch);
        $methodData = json_decode($methodResponse, true);

        if (!isset($methodData['data']['id'])) {
            return "Error creating payment method: <pre>" . print_r($methodData, true) . "</pre>";
        }

        $payment_method_id = $methodData['data']['id'];

        // STEP 3: Attach Payment Method to Intent
        $attachPayload = [
            'data' => [
                'attributes' => [
                    'payment_method' => $payment_method_id,
                    'client_key'     => $client_key,
                    'return_url'     => base_url('payment/success')
                ]
            ]
        ];

        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/$intent_id/attach");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($attachPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $attachResponse = curl_exec($ch);
        curl_close($ch);
        $attachData = json_decode($attachResponse, true);

        // Handle redirect or success
        $status     = $attachData['data']['attributes']['status'] ?? null;
        $nextAction = $attachData['data']['attributes']['next_action']['redirect']['url'] ?? null;

        $session->set([
            'payment_amount'     => $amount_php,
            'payment_intent_id'  => $intent_id,
            'paymenttype'        => $paymenttype,
            'email'              => $email
        ]);

        if ($nextAction) {
            // Redirect-based payments
            return redirect()->to($nextAction);
        } elseif ($status === 'succeeded') {
            // Card paid immediately
            return redirect()->to(base_url('payment/success'));
        } else {
            return redirect()->to(base_url('payment/failed'));

            return "Error attaching payment method: <pre>" . print_r($attachData, true) . "</pre>";
        }
    }


    public function success()
    {
        $session = session();
        $studentId = $session->get('user_id');
        $amountPaid = $session->get('payment_amount');
        $paymenttype = $session->get('paymenttype');
        $email = $session->get('email');


        if (!$studentId || !$amountPaid) {
            session()->setFlashdata('error', 'Please check your account. If money was deducted, report it to the admin immediately');
            return redirect()->to('/student-paymentInfo');
        }

        $paymentModel = new PaymentModel();

        $today = date('Y-m-d');
        $lastMonth = date('F Y', strtotime('first day of last month'));
        $currentMonth = date('F Y');

        // Check if last month is already paid
        $lastMonthPaid = $paymentModel->where([
            'user_id' => $studentId,
            'month' => $lastMonth,
            'status' => 'Paid',
            'method' => 'online'
        ])->first();

        // Check if there is any unpaid record for last month
        $lastMonthUnpaid = $paymentModel->where([
            'user_id' => $studentId,
            'month' => $lastMonth,
            'status' => 'unpaid',
            'method' => 'online'
        ])->first();

        // Determine target month based on unpaid record existence
        if ($lastMonthPaid) {
            // Last month already paid, so pay current month
            $targetMonth = $currentMonth;
        } else {
            // Last month not paid
            if ($lastMonthUnpaid) {
                // There is unpaid record for last month, pay last month
                $targetMonth = $lastMonth;
            } else {
                // No unpaid record for last month, pay current month
                $targetMonth = $currentMonth;
            }
        }

        // Delete unpaid record for the target month if exists
        $paymentModel->where([
            'user_id' => $studentId,
            'month' => $targetMonth,
            'status' => 'unpaid',
            
        ])->delete();

        // Avoid duplicate insert
        $existing = $paymentModel->where([
            'user_id' => $studentId,
            'month' => $targetMonth,
            'payment_date' => $today,
            'method' => 'online'
        ])->first();

        if (!$existing) {
            if ($paymenttype == 'remaining'){
                 $paymentModel->insert([
                'user_id'     => $studentId,
                'month'       => $targetMonth,
                'amount_due'  => $amountPaid,
                'payment_type' => 'remaining',
                'amount_paid' => $amountPaid,
                'status'      => 'Paid',
                'payment_date'=> $today,
                'method' => 'online'
            ]);

            }else{
                $paymentModel->insert([
                    'user_id'     => $studentId,
                    'month'       => $targetMonth,
                    'amount_due'  => $amountPaid,
                    'payment_type' => 'tuition',
                    'amount_paid' => $amountPaid,
                    'status'      => 'Paid',
                    'payment_date'=> $today,
                    'method' => 'online'
                ]);
            }
        }
         
            $model = new \App\Models\Admin_Model();
        if (empty($email)) {
            $admission = $model->where('user_id', $studentId)->first();
            $email = $admission->email ?? null;
        }
        
        if (!empty($email)) {
            $emailService = \Config\Services::email();

            $emailService->setTo($email);
            $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
            $emailService->setSubject('Payment Receipt - ' . $targetMonth); // Dynamic subject
            $emailService->setMailType('html');

            // HTML message body (same as before, but mentions PDF attachment)
            $emailBody = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Payment Receipt</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { text-align: center; background: #f4f4f4; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                    .payment-details { background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0; }
                    .fee-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
                    .total { font-weight: bold; font-size: 1.2em; background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px; }
                    .note { background: #fff3cd; padding: 10px; border-left: 4px solid #ffc107; margin-top: 20px; }
                    .pdf-note { background: #d1ecf1; padding: 10px; border-left: 4px solid #17a2b8; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Payment Receipt - Thank You!</h2>
                    <p>Dear Parent/Guardian,</p>
                    <p>Your payment for ' . esc($targetMonth) . ' has been successfully processed.</p>
                </div>

                <div class="payment-details">
                    <h3>Payment Summary:</h3>
                    <div class="fee-item"><span>Month:</span><span>' . esc($targetMonth) . '</span></div>
                    <div class="fee-item"><span>Payment Type:</span><span>' . esc(ucfirst($paymenttype)) . '</span></div>
                    <div class="fee-item"><span>Amount Paid:</span><span>₱' . number_format($amountPaid, 2) . '</span></div>
                    <div class="fee-item"><span>Payment Date:</span><span>' . esc($today) . '</span></div>
                    <div class="fee-item"><span>Method:</span><span>Online</span></div>
                    <div class="fee-item"><span>Status:</span><span>Paid</span></div>
                </div>

                <h3>Tuition Fee Breakdown (Annual Reference):</h3>
                <div class="fee-item"><span>Monthly Tuition Fee (₱2,500 × 10 months)</span><span>₱25,000</span></div>
                <div class="fee-item"><span>School Modules</span><span>Included</span></div>
                <div class="fee-item"><span>Learning Materials</span><span>Included</span></div>
                <div class="fee-item"><span>Instructional Tools & Supplies</span><span>Included</span></div>
                <div class="fee-item"><span>Montessori Apparatus</span><span>Included</span></div>
                <div class="fee-item"><span>Registration Fee</span><span>₱0</span></div>
                <div class="fee-item"><span>Miscellaneous Fee</span><span>₱0</span></div>
                <div class="fee-item"><span>Communication Notebook</span><span>Included</span></div>
                <div class="fee-item"><span>Writing Notebook</span><span>Included</span></div>
                <div class="fee-item"><span>Academic Notebook</span><span>Included</span></div>
                <div class="fee-item"><span>Arts & Crafts Project Materials</span><span>Included</span></div>
                <div class="fee-item"><span>Sensory Materials</span><span>Included</span></div>
                <div class="fee-item"><span>Energy Fee</span><span>Included</span></div>
                <div class="fee-item"><span>Health & Sanitation Fee</span><span>Included</span></div>
                <div class="fee-item"><span>Operational Fee</span><span>Included</span></div>

                <div class="total">
                    <span>Total Annual Tuition (Monthly Option):</span>
                    <span>₱2,500 per month</span>
                </div>

                <div class="pdf-note">
                    <strong>PDF Receipt Attached:</strong> A printable PDF version of this receipt is attached to this email for your records.
                </div>

                <div class="note">
                    <strong>Note:</strong> For any queries, please contact the school administration. Keep this for your records.
                </div>

                <p>Thank you for your payment!<br>Best regards,<br>School Admin</p>
            </body>
            </html>';

            $emailService->setMessage($emailBody);

            // Generate PDF (using similar content as email body)
            $pdf = new Dompdf();
            $pdfHtml = '
            <h1>Payment Receipt - ' . esc($targetMonth) . '</h1>
            <p><strong>Payment Summary:</strong></p>
            <ul>
                <li>Month: ' . esc($targetMonth) . '</li>
                <li>Payment Type: ' . esc(ucfirst($paymenttype)) . '</li>
                <li>Amount Paid: ₱' . number_format($amountPaid, 2) . '</li>
                <li>Payment Date: ' . esc($today) . '</li>
                <li>Method: Online</li>
                <li>Status: Paid</li>
            </ul>
            <p><strong>Tuition Fee Breakdown:</strong></p>
            <ul>
                <li>Monthly Tuition Fee (₱2,500 × 10 months): ₱25,000</li>
                <li>School Modules: Included</li>
                <li>Learning Materials: Included</li>
                <li>Instructional Tools & Supplies: Included</li>
                <li>Montessori Apparatus: Included</li>
                <li>Registration Fee: ₱0</li>
                <li>Miscellaneous Fee: ₱0</li>
                <li>Communication Notebook: Included</li>
                <li>Writing Notebook: Included</li>
                <li>Academic Notebook: Included</li>
                <li>Arts & Crafts Project Materials: Included</li>
                <li>Sensory Materials: Included</li>
                <li>Energy Fee: Included</li>
                <li>Health & Sanitation Fee: Included</li>
                <li>Operational Fee: Included</li>
            </ul>
            <p><strong>Total Annual Tuition (Monthly Option):</strong> ₱2,500 per month</p>
            <p>Generated on: ' . esc($today) . '<br>School Admin</p>';
            
            $pdf->loadHtml($pdfHtml);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $pdfOutput = $pdf->output(); // Get PDF as binary string

            // Attach PDF to email
            $filename = 'tuition_receipt_' . $targetMonth . '_' . date('Y-m-d') . '.pdf';
            $emailService->attach($pdfOutput, 'application/pdf', $filename, 'attachment');

            // Send email
            if (!$emailService->send()) {
                session()->setFlashdata('error', 'Email sending failed. Please check your account, and if any amount was deducted, report it to the admin immediately.');
                log_message('error', 'Email sending failed for user_id: ' . $studentId . ' to ' . $email . ': ' . print_r($emailService->printDebugger(['headers']), true));
            } else {
                log_message('info', 'Payment receipt email with PDF sent successfully to: ' . $email . ' for user_id: ' . $studentId);
            }
        } else {
            session()->setFlashdata('error', 'Email sending failed. Please check your account, and if any amount was deducted, report it to the admin immediately.');
            log_message('warning', 'No email found for user_id: ' . $studentId . ' - Email and PDF not sent.');
        }

        // Clean up session
        $session->remove(['payment_amount', 'payment_intent_id', 'paymenttype', 'email']);

        // Redirect with success message
        session()->setFlashdata('success', 'Payment successful! Check your email for receipt and PDF attachment.');
        return redirect()->to('/student-paymentInfo')->with('success', 'Payment successful! Check your email for receipt and PDF attachment.');
    }





    public function failed()
    {
        session()->setFlashdata('error', 'Please check your account, and if any amount was deducted, report it to the admin immediately.');
        return redirect()->to('/student-paymentInfo')->with('error', 'Please check your account, and if any amount was deducted, report it to the admin immediately');
       
    }
   


    public function payCash()
    {
        $request = service('request');
        $studentId   = $request->getPost('student_id');
        $amount_php  = $request->getPost('amount');
        $paymentType = $request->getPost('payment_type');
        $today = date('Y-m-d');
        $lastMonth = date('F Y', strtotime('first day of last month'));
        $currentMonth = date('F Y');
        $paymentModel = new \App\Models\PaymentModel();
        $notification = new \App\Models\NotificationModel();

        
        if (in_array($paymentType, ['full',  'remaining'])) {
            $paymentModel->insert([
                'user_id'      => $studentId,
                'month'        => $currentMonth,
                'amount_due'   => $amount_php,
                'amount_paid'  => $amount_php,
                'status'       => 'paid',
                'payment_type' => $paymentType,
                'payment_date' => $today,
                'method'       =>'cash'
            ]);
            // Delete all unpaid records for this student
            $paymentModel->where('user_id', $studentId)
                        ->where('status', 'unpaid')
                        ->delete();

            
             $notification->insert([
                'user_id' => $studentId, 
                'title'   => 'Payment',
                'message' => 'Your school payment has been received and confirmed. Thank you.',
                'type'    => 'payment', 
                'is_read' => 0
            ]);

            return redirect()->back()->with('message', ucfirst($paymentType) . ' payment recorded successfully.');
        }
       
        if  (in_array($paymentType, ['miscellaneous',  'regfee'])) {
            // Insert the full payment
            $paymentModel->insert([
                'user_id'      => $studentId,
                'month'        => $currentMonth,
                'amount_due'   => $amount_php,
                'amount_paid'  => $amount_php,
                'status'       => 'paid',
                'payment_type' => $paymentType,
                'payment_date' => $today,
                'method'       =>'cash'
            ]);
             $notification->insert([
                'user_id' => $studentId, 
                'title'   => 'Payment',
                'message' => 'Your school payment has been received and confirmed. Thank you.',
                'type'    => 'payment', 
                'is_read' => 0
            ]);

            
            return redirect()->back()->with('message', 'Full payment recorded successfully, unpaid records cleared.');
        }


        // Check unpaid record for this student
        $unpaid = $paymentModel->where('user_id', $studentId)
                            ->where('status', 'unpaid')
                            ->first();

            

        if ($unpaid) {
            // Update the unpaid record
            $paymentModel->update($unpaid['id'], [
                'amount_paid'  => $amount_php,
                'status'       => 'paid',
                'payment_type' => 'tuition',
                'payment_date' => $today,
                'method'       =>'cash'

            ]);
             $notification->insert([
                'user_id' => $studentId, 
                'title'   => 'Payment',
                'message' => 'Your school payment has been received and confirmed. Thank you.',
                'type'    => 'payment', 
                'is_read' => 0
            ]);

            return redirect()->back()->with('message', 'Payment recorded successfully.');
        } else {
            return redirect()->back()->with('error', 'No unpaid record found for this student.');
        }
    }
    public function getHistory($studentId)
    {
        $paymentModel = new \App\Models\PaymentModel();
        $history = $paymentModel->getPaymentHistoryByStudent($studentId);

        return $this->response->setJSON($history);
    }

    public function printpayment()
    {
        
       $reportModel = new \App\Models\Admin_Model();

       
     $data = [
        'reports' => $reportModel->generateReport()
    ];


        return view('admin/paymentReport', $data);
    }

    public function payCashEnrollment()
    {
       //12345
        $admissionId = $this->request->getPost('student_id');
        $amountPaid  = $this->request->getPost('amount');
        $paymentType = $this->request->getPost('payment_type');
        $paymentDate = $this->request->getPost('payment_date');
        $userId      = $this->request->getPost('user_id');
         $adminName = session()->get('full_name Admin');

        $scheduleModel = new \App\Models\PaymentScheduleModel();
        $StudentModel = new \App\Models\StudentModel();
        $openingmodel = new \App\Models\OpeningModel();
        $class_model = new ClassModel();

         $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];

        $result = $StudentModel->processCashPayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId);
         $description = "Pay Registration paid: ₱$amountPaid via $paymentType.";
        $MonthyTuition  = $class_model -> getMonthyTuitionFee($admissionId); 
        $MonthyTuitionFee = $MonthyTuition->monthly_payment ?? 0;
        log_message('info', "Monthly tuition fee for admission ID {$admissionId}: {$MonthyTuitionFee}");

        $result = $scheduleModel->createMonthlyScheduleForChildEnrollment($admissionId,$MonthyTuitionFee);
        
        $notification = new \App\Models\NotificationModel();
            $notification->insert([
                'user_id' => $userId, 
                'title'   => 'Admission',
                'message' => 'Your child is officialy enrolled',
                'type'    => 'admission', 
                'is_read' => 0
            ]);

        $audit = new \App\Models\AuditLogModel();
            $audit->insert([
                'admission_id' => $admissionId,
                'action'       => 'payment Miscellaneous',
                'description'  => $description,
                'done_by'      => $adminName, // FULLNAME FROM SESSION
                'status'      => 'success',
            ]);
        session()->setFlashdata('success', 'Payment successfully.');
        return redirect('admin-dashboard')->with('success', 'Payment successfully.');
        
    }
    public function payment_link()
    {
        $request = service('request');
        $session = session();

        // Collect inputs
        $amount_php     = $request->getPost('payamount');
        $paymentDate     = $request->getPost('payment_date');
        $fullname       = $request->getPost('fullname');
    
        $email          = $request->getPost('email');
        $number         = $request->getPost('number');
        $paymentMethod  = $request->getPost('paymentMethod'); // ex: card, gcash, dob
        $paymenttype    = $request->getPost('paymentOption');
        $card_number    = $request->getPost('cardNumber');
        $exp_month      = (int) $request->getPost('expiryMonth'); 
        $exp_year       = (int) $request->getPost('expiryYear');
        $cvc            = $request->getPost('cvv');
        $bank_code      = $request->getPost('accountName');

        // Log inputs
        log_message('info', 'Payment Data: amount={amount}, fullname={fullname}, email={email}, number={number}, method={method}, type={type}, card={card}, exp_month={month}, exp_year={year}, cvc={cvc}, bank_code={bank}', [
            'amount'   => $amount_php,
            'fullname' => $fullname,
            'email'    => $email,
            'number'   => $number,
            'method'   => $paymentMethod,
            'type'     => $paymenttype,
            'card'     => $card_number,
            'month'    => $exp_month,
            'year'     => $exp_year,
            'cvc'      => $cvc,
            'bank'     => $bank_code,
        ]);

       
        
        $studentId = $session->get('user_id');
        if (!$studentId) {
            return redirect()->to('/login');
        }

        $amount_cents = (int) $amount_php * 100;

        // STEP 1: Create Payment Intent
        $intentPayload = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_cents,
                    'payment_method_allowed' => [$paymentMethod],
                    'currency' => 'PHP',
                    'capture_type' => 'automatic',
                    'send_email_receipt' => true,
                    'receipt_email' => $email,
                    'description' => 'Student Payment',
                    'statement_descriptor' => 'StudentPay'
                ]
            ]
        ];

        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($intentPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $intentResponse = curl_exec($ch);
        curl_close($ch);
        $intentData = json_decode($intentResponse, true);

        if (!isset($intentData['data']['id'])) {
            return "Error creating payment intent: <pre>" . print_r($intentData, true) . "</pre>";
        }

        $intent_id  = $intentData['data']['id'];
        $client_key = $intentData['data']['attributes']['client_key'];

        // STEP 2: Create Payment Method
        if ($paymentMethod == 'card') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'card',
                        'details' => [
                            'card_number' => $card_number,
                            'exp_month'   => $exp_month,
                            'exp_year'    => $exp_year,
                            'cvc'         => $cvc,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } elseif ($paymentMethod == 'dob') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'dob',
                        'details' => [
                            'bank_code' => $bank_code,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } else {
            // Other redirect methods (gcash, paymaya, grab_pay, etc.)
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => $paymentMethod,
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                            'phone' => $number,
                        ]
                    ]
                ]
            ];
        }

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($methodPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $methodResponse = curl_exec($ch);
        curl_close($ch);
        $methodData = json_decode($methodResponse, true);

     if (isset($methodData['errors'])) {
    $errorMessage = addslashes($methodData['errors'][0]['detail'] ?? 'Payment error occurred.');

    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Payment Error</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                text: '$errorMessage',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>
    ";
    exit;
}

if (!isset($methodData['data']['id'])) {
    return 'Error creating payment method: <pre>' . print_r($methodData, true) . '</pre>';
}

        $payment_method_id = $methodData['data']['id'];

        // STEP 3: Attach Payment Method to Intent
        $attachPayload = [
            'data' => [
                'attributes' => [
                    'payment_method' => $payment_method_id,
                    'client_key'     => $client_key,
                    'return_url'     => base_url('payment/redirect')
                ]
            ]
        ];

        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/$intent_id/attach");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($attachPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $attachResponse = curl_exec($ch);
        curl_close($ch);
        $attachData = json_decode($attachResponse, true);

        // Handle redirect or success
        //$result = $StudentModel->processCashPayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId);
        $status     = $attachData['data']['attributes']['status'] ?? null;
        $nextAction = $attachData['data']['attributes']['next_action']['redirect']['url'] ?? null;

        $session->set([
            'payment_amount'     => $amount_php,
            'payment_intent_id'  => $intent_id,
            'paymenttype'        => $paymenttype,
            'email'              => $email,
            'paymentDate'        => $paymentDate,
            'paymentMethod'      => 'Online',
            'statusPayment'      =>  $status
            
            
        ]);
        

        if ($nextAction) {
            // Redirect-based payments
            return redirect()->to($nextAction);
        } elseif ($status === 'succeeded') {
            // Card paid immediately
            return redirect()->to(base_url('registration/success'));
        } else {
            return redirect()->to(base_url('payment/failed'));

            return "Error attaching payment method: <pre>" . print_r($attachData, true) . "</pre>";
        }
    }
    
    public function payOnlineEnrollment()
    {   //123PAYMENT
        $session = session();
        $admissionId = $session->get('admissionID');
        $amountPaid  = $session->get('payment_amount');
        $paymentType = $session->get('paymentMethod');
        $paymentDate = $session->get('paymentDate');
        $userId      = $session->get('user_id');
         $email       = $session->get('email');
       
          $today       = date('F d, Y');


       
        
        $scheduleModel = new \App\Models\PaymentScheduleModel();
        $StudentModel = new \App\Models\StudentModel();
         $openingmodel = new \App\Models\OpeningModel();
          $class_model = new ClassModel();
         $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];

        $result = $StudentModel->processOnlinePayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId);
         $MonthyTuition  = $class_model -> getMonthyTuitionFee($admissionId); 
        $MonthyTuitionFee = $MonthyTuition->monthly_payment ?? 0;
        $result = $scheduleModel->createMonthlyScheduleForChildEnrollment($admissionId,$MonthyTuitionFee);

        $notification = new \App\Models\NotificationModel();
        $notification->insert([
            'user_id' => $userId, 
            'title'   => 'Admission',
            'message' => 'admission Updated status',
            'type'    => 'admission', 
            'is_read' => 0
        ]);


         if (!empty($email)) {
        // Get student & guardian info WITHOUT payments
        $student = $StudentModel->getPaymentDetails($admissionId); // your method WITHOUT payment info
        $studentFullName = $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'];
        $guardianName   = $student['guardianfull_name'];

        // Prepare registration-only PDF
        $pdfHtml = '
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8"/>
            <style>
                body { font-family: DejaVu Sans, Arial, sans-serif; color:#222; font-size:12px; }
                .header { display:flex; align-items:center; gap:12px; margin-bottom:8px; }
                .logo { width:72px; }
                .school { font-weight:700; font-size:16px; }
                .address { font-size:11px; color:#444; }
                .title { text-align:center; margin:8px 0 6px; font-size:14px; font-weight:700; }
                table { width:100%; border-collapse:collapse; margin-top:8px; }
                th, td { border:1px solid #ddd; padding:6px; }
                th { background:#f4f4f4; text-align:left; }
                .right { text-align:right; }
                .center { text-align:center; }
                .total-row td { font-weight:700; }
                .section { margin-top:12px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div><img src="' . base_url('assets/img/logoicon.png') . '" class="logo" alt="logo"></div>
                <div>
                    <div class="school">Brightside Learning Center</div>
                    <div class="address">Barangay, Bagumbayan, Santa Cruz, Laguna</div>
                </div>
            </div>

            <div class="title">OFFICIAL PAYMENT RECEIPT</div>

            <div style="font-size:12px; margin-bottom:6px;">
                <strong>Parent Name:</strong> ' . esc($guardianName) . ' &nbsp; | &nbsp;
                <strong>Student Name:</strong> ' . esc($studentFullName) . ' &nbsp; | &nbsp;
                <strong>Date:</strong> ' . esc($today) . '
            </div>

            <div class="section">
                <table>
                    <thead>
                        <tr>
                            <th style="width:4%;">#</th>
                            <th style="width:36%;">Student Name</th>
                            <th style="width:18%;" class="center">Fee Type</th>
                            <th style="width:14%;" class="right">Amount Paid (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">1</td>
                            <td>' . esc($studentFullName) . '</td>
                            <td class="center">Registration</td>
                            <td class="right">' . number_format($amountPaid, 2) . '</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="right">TOTAL</td>
                            <td class="right">' . number_format($amountPaid, 2) . '</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="section">
                <h4 style="margin:8px 0 6px;">Registration Fee Breakdown</h4>
                <ul style="margin:0; padding-left:18px; line-height:1.4;">
                    <li>Registration Fee: ₱' . number_format($amountPaid, 2) . '</li>
                </ul>
            </div>

            <div style="margin-top:12px;">
                <p>Thank you for your payment.</p>
            </div>
        </body>
        </html>
        ';

        // Generate PDF
        $pdf = new Dompdf();
        $pdf->loadHtml($pdfHtml);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdfOutput = $pdf->output();

        // Send email
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('ecohaven28@gmail.com', 'School Admin');
        $emailService->setSubject('Registration Payment Receipt');
        $emailService->setMailType('html');
        $emailService->setMessage($pdfHtml);
        $filename = 'registration_receipt_' . date('Ymd') . '.pdf';
        $emailService->attach($pdfOutput, 'application/pdf', $filename, 'attachment');

        if (!$emailService->send()) {
            session()->setFlashdata('error', 'Email sending failed. Please report to admin.');
            log_message('error', 'Email failed for user_id: ' . $userId . ' to ' . $email . ': ' . print_r($emailService->printDebugger(['headers']), true));
        } else {
            log_message('info', 'Registration receipt email with PDF sent to: ' . $email . ' for user_id: ' . $userId);
        }
    }
       
       session()->setFlashdata('success', 'Enrolled successfully.');
        return redirect('guardian/dashboard')->with('success', 'Enrolled successfully.');
        
    }
    public function payment_linkMiscellaneous()
    {
        $request = service('request');
        $session = session();

        
        $children = $this->request->getPost('children');
        $planID      = (int) $request->getPost('plan_id'); 
        $amount_php     = $request->getPost('payamount');
        $paymentDate    = date('Y-m-d');
        $fullname       = $request->getPost('fullname');
        $email          = $request->getPost('email');
        $number         = $request->getPost('number');
        $paymentMethod  = $request->getPost('paymentMethod'); // ex: card, gcash, dob
        $paymenttype    = $request->getPost('paymentOption');
        $card_number    = $request->getPost('cardNumber');
        $exp_month      = (int) $request->getPost('expiryMonth'); 
        $exp_year       = (int) $request->getPost('expiryYear');
        $cvc            = $request->getPost('cvv');
        $bank_code      = $request->getPost('accountName');
       if ($amount_php < 100) {
    return redirect()
        ->back()
        ->withInput()
        ->with('error', 'Minimum payment amount is ₱1.00');
        session()->setFlashdata('error', 'Minimum payment amount is ₱1.00');
}


       
        log_message('info', 'Payment Data: amount={amount}, fullname={fullname}, email={email}, number={number}, method={method}, type={type}, card={card}, exp_month={month}, exp_year={year}, cvc={cvc}, bank_code={bank}, childern={children}, planId={planID}', [
            'amount'   => $amount_php,
            'fullname' => $fullname,
            'email'    => $email,
            'number'   => $number,
            'method'   => $paymentMethod,
            'type'     => $paymenttype,
            'card'     => $card_number,
            'month'    => $exp_month,
            'year'     => $exp_year,
            'cvc'      => $cvc,
            'bank'     => $bank_code,
            'children' => json_encode($children),
            'planID'   => $planID,
        ]);

       
        
        $studentId = $session->get('user_id');
        if (!$studentId) {
            return redirect()->to('/login');
        }

        $amount_cents = (int) $amount_php * 100;

        // STEP 1: Create Payment Intent
        $intentPayload = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_cents,
                    'payment_method_allowed' => [$paymentMethod],
                    'currency' => 'PHP',
                    'capture_type' => 'automatic',
                    'send_email_receipt' => true,
                    'receipt_email' => $email,
                    'description' => 'Student Payment',
                    'statement_descriptor' => 'StudentPay'
                ]
            ]
        ];

        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($intentPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $intentResponse = curl_exec($ch);
        curl_close($ch);
        $intentData = json_decode($intentResponse, true);

        if (!isset($intentData['data']['id'])) {
            return "Error creating payment intent: <pre>" . print_r($intentData, true) . "</pre>";
        }

        $intent_id  = $intentData['data']['id'];
        $client_key = $intentData['data']['attributes']['client_key'];

        // STEP 2: Create Payment Method
        if ($paymentMethod == 'card') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'card',
                        'details' => [
                            'card_number' => $card_number,
                            'exp_month'   => $exp_month,
                            'exp_year'    => $exp_year,
                            'cvc'         => $cvc,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } elseif ($paymentMethod == 'dob') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'dob',
                        'details' => [
                            'bank_code' => $bank_code,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } else {
            // Other redirect methods (gcash, paymaya, grab_pay, etc.)
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => $paymentMethod,
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                            'phone' => $number,
                        ]
                    ]
                ]
            ];
        }

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($methodPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $methodResponse = curl_exec($ch);
        curl_close($ch);
        $methodData = json_decode($methodResponse, true);

         if (isset($methodData['errors'])) {
            $errorMessage = addslashes($methodData['errors'][0]['detail'] ?? 'Payment error occurred.');

            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <title>Payment Error</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: '$errorMessage',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.history.back();
                    });
                </script>
            </body>
            </html>
            ";
            exit;
        }

        if (!isset($methodData['data']['id'])) {
            return 'Error creating payment method: <pre>' . print_r($methodData, true) . '</pre>';
        }

        $payment_method_id = $methodData['data']['id'];

        // STEP 3: Attach Payment Method to Intent
        $attachPayload = [
            'data' => [
                'attributes' => [
                    'payment_method' => $payment_method_id,
                    'client_key'     => $client_key,
                    'return_url'     => base_url('payment/redirect-miscellaneous')
                ]
            ]
        ];

        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/$intent_id/attach");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($attachPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $attachResponse = curl_exec($ch);
        curl_close($ch);
        $attachData = json_decode($attachResponse, true);

        // Handle redirect or success
        //$result = $StudentModel->processCashPayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId);
        $status     = $attachData['data']['attributes']['status'] ?? null;
        $nextAction = $attachData['data']['attributes']['next_action']['redirect']['url'] ?? null;

        $session->set([
            'payment_amount'     => $amount_php,
            'payment_intent_id'  => $intent_id,
            'paymenttype'        => $paymenttype,
            'email'              => $email,
            'paymentDate'        => $paymentDate,
            'paymentMethod'      => 'Online',
            'planId'             => $planID,
            'children'           => $children,
            'fullname'           => $fullname
            
        ]);

        if ($nextAction) {
            // Redirect-based payments
            return redirect()->to($nextAction);
        } elseif ($status === 'succeeded') {
            // Card paid immediately
            return redirect()->to(base_url('miscellaneous/success'));
        } else {
            return redirect()->to(base_url('payment/failed'));

            return "Error attaching payment method: <pre>" . print_r($attachData, true) . "</pre>";
        }
    }
    public function payOnline()
    {   
        $session = session();
        $children    = $session->get('children');
        $admissionId = $session->get('admissionID');
        $amountPaid  = $session->get('payment_amount');
        $paymentType = $session->get('paymentMethod');
        $paymentDate = $session->get('paymentDate');
        $planID      = $session->get('planId');
        $email      = $session->get('email');
        

        $PaymentModel = new \App\Models\PaymentModel();
         $openingmodel = new \App\Models\OpeningModel();
         $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];
       if ($planID == 3){

            $result = $PaymentModel->payonlinemiscellaneousCash($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        }
        elseif ($planID == 4)
        {
            $result = $PaymentModel->payonlinefulltuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        }
        elseif ($planID == 5)
        {
            $result = $PaymentModel->payonlinepartialtuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        }
        if ($result === true || $result === false || $result === null) {
            // no detailed processed data returned — build a simple placeholder entry
            $processed = $result;
            $processed = [
                [
                    'student_id' => $admissionId ?? null,
                    'student_name' =>$children,
                    'parent_email' => $email,
                    'plan_id' => $planID,
                    'plan_name' => 'Tuition Plan',
                    'amount_paid' => (float)$amountPaid,
                    'remaining_balance' => null,
                    'payment_method' => $paymentType,
                    'payment_date' => $paymentDate,
                    'status' => 'Paid'
                ]
            ];
        }

        // If nothing processed
        if (empty($processed)) {
            return redirect('guardian/dashboard')->with('error', 'Payment failed or nothing processed.');
        }

        // === BUILD PDF HTML ===
        try {
            // Totals
            $totalPaid = 0.0;
            foreach ($processed as $p) {
                $totalPaid += floatval($p['amount_paid'] ?? 0);
            }

            // School info / logo
            $schoolName = "Brightside Learning Center";
            $schoolAddress = "Your School Address Here"; // change if needed
            $logoUrl = base_url('assets/img/logoicon.png'); // your provided logo path

            // Transaction reference
            $transactionRef = 'OR-' . date('YmdHis');

            // Build student rows HTML
            $rowsHtml = '';
            $i = 1;
            foreach ($processed as $p) {
                $studentName = esc($p['student_name'] ?? 'Student');
                $planName = esc($p['plan_name'] ?? $p['plan_id']);
                $amount = number_format(floatval($p['amount_paid'] ?? 0), 2);
                $remaining = isset($p['remaining_balance']) ? number_format(floatval($p['remaining_balance']), 2) : '-';
                $status = esc($p['status'] ?? '');
                $rowsHtml .= "
                    <tr>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$i</td>
                        <td style='padding:6px; border:1px solid #ddd;'>$studentName</td>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$planName</td>
                        <td style='text-align:right; padding:6px; border:1px solid #ddd;'>$amount</td>
                        <td style='text-align:right; padding:6px; border:1px solid #ddd;'>$remaining</td>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$status</td>
                    </tr>";
                $i++;
            }

            // Breakdown list (BUL1)
            $breakdownItems = [
                 "Communication Notebook",
                "Writing Notebook",
                "Academic Notebook",
                "Arts & Crafts Project Materials",
                "Sensory Materials",
                "Energy Fee",
                "Health & Sanitation Fee",
                "Operational Fee"
                
            ];
            $breakdownHtml = '<ul style="margin:0; padding-left:18px; line-height:1.4;">';
            foreach ($breakdownItems as $it) {
                $breakdownHtml .= '<li style="margin-bottom:4px;">' . esc($it) . '</li>';
            }
            $breakdownHtml .= '</ul>';

            // Compose PDF HTML
            $pdfHtml = '
            <!doctype html>
            <html>
            <head>
                <meta charset="utf-8"/>
                <style>
                    body { font-family: DejaVu Sans, Arial, sans-serif; color:#222; font-size:12px; }
                    .header { display:flex; align-items:center; gap:12px; margin-bottom:8px; }
                    .logo { width:72px; }
                    .school { font-weight:700; font-size:16px; }
                    .address { font-size:11px; color:#444; }
                    .title { text-align:center; margin:8px 0 6px; font-size:14px; font-weight:700; }
                    table { width:100%; border-collapse:collapse; margin-top:8px; }
                    th, td { border:1px solid #ddd; padding:6px; }
                    th { background:#f4f4f4; text-align:left; }
                    .right { text-align:right; }
                    .center { text-align:center; }
                    .total-row td { font-weight:700; }
                    .section { margin-top:12px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div><img src="' . esc($logoUrl) . '" class="logo" alt="logo"></div>
                    <div>
                        <div class="school">' . esc($schoolName) . '</div>
                        <div class="address">' . esc($schoolAddress) . '</div>
                    </div>
                </div>

                <div class="title">OFFICIAL PAYMENT RECEIPT</div>

                <div style="font-size:12px; margin-bottom:6px;">
                    <strong>Receipt No:</strong> ' . esc($transactionRef) . ' &nbsp; | &nbsp;
                    <strong>Date:</strong> ' . esc(date('F d, Y H:i')) . '
                </div>

                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:4%;">#</th>
                                <th style="width:36%;">Student Name</th>
                                <th style="width:18%;" class="center">Plan / Month</th>
                                <th style="width:14%;" class="right">Amount Paid (₱)</th>
                                <th style="width:14%;" class="right">Remaining Balance (₱)</th>
                                <th style="width:14%;" class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $rowsHtml . '
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="right">TOTAL</td>
                                <td class="right">₱' . number_format($totalPaid, 2) . '</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Placement B: Breakdown AFTER total -->
                <div class="section">
                    <h4 style="margin:8px 0 6px;">Breakdown of Fees</h4>
                    ' . $breakdownHtml . '
                </div>

                <div style="margin-top:12px;">
                    <p>Thank you for your payment.</p>
                </div>
            </body>
            </html>
            ';

            // === GENERATE PDF via Dompdf ===
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($pdfHtml);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfOutput = $dompdf->output();

            // === SEND EMAIL with PDF ATTACHMENT ===
            if (!empty($email)) {
                try {
                    $emailService = \Config\Services::email();
                    $emailService->setFrom('ecohaven28@gmail.com', $schoolName);
                    $emailService->setTo($email);
                    $emailService->setSubject('Official Payment Receipt - ' . $transactionRef);
                    $emailService->setMailType('html');

                    // Build simple email HTML (you can use a view if preferred)
                    $studentLabel = (count($processed) === 1) ? esc($processed[0]['student_name']) : 'Multiple Children';
                    $emailMessage = '
                        <div style="font-family:Arial, sans-serif; color:#333; line-height:1.4;">
                            <div style="text-align:center;">
                                <img src="' . esc($logoUrl) . '" width="80" style="display:block;margin:6px auto;">
                                <h2 style="margin:6px 0;">' . esc($schoolName) . '</h2>
                                <p style="margin:0 0 8px 0;"><strong>Official Payment Receipt</strong></p>
                            </div>
                            <p>Good day,</p>
                            <p>This email is to confirm the payment for <strong>' . $studentLabel . '</strong>.</p>
                            <table style="width:100%; font-size:13px; margin-top:6px;">
                                <tr><td><strong>Amount Paid:</strong></td><td style="text-align:right;">₱' . number_format($totalPaid, 2) . '</td></tr>
                                <tr><td><strong>Payment Method:</strong></td><td style="text-align:right;">' . esc($paymentType) . '</td></tr>
                                <tr><td><strong>Payment Date:</strong></td><td style="text-align:right;">' . esc($paymentDate) . '</td></tr>
                                <tr><td><strong>Receipt No:</strong></td><td style="text-align:right;">' . esc($transactionRef) . '</td></tr>
                            </table>
                            <p style="margin-top:10px;">A printable copy of the official receipt is attached as a PDF for your records.</p>
                            <p>Thank you,<br><strong>' . esc($schoolName) . '</strong></p>
                        </div>
                    ';

                    $emailService->setMessage($emailMessage);
                    // attach raw pdf binary (filename and mime)
                    $filename = 'Official_Receipt_' . $transactionRef . '.pdf';
                    $emailService->attach($pdfOutput, 'application/pdf', $filename, 'attachment');

                    if (!$emailService->send()) {
                        log_message('error', 'Email sending failed: ' . print_r($emailService->printDebugger(['headers']), true));
                        session()->setFlashdata('warning', 'Payment processed but sending receipt email failed.');
                    } else {
                        log_message('info', 'Payment receipt PDF emailed to: ' . $email);
                        session()->setFlashdata('success', 'Payment completed and receipt sent to your email.');
                    }
                } catch (\Throwable $e) {
                    log_message('error', 'Email exception: ' . $e->getMessage());
                    session()->setFlashdata('warning', 'Payment processed but an error occurred while sending the receipt.');
                }
            } else {
                log_message('warning', 'No recipient email found; PDF generated but not emailed. Ref: ' . $transactionRef);
                session()->setFlashdata('success', 'Payment processed but no email provided for receipt.');
            }

        } catch (\Throwable $e) {
            log_message('error', 'PDF generation exception: ' . $e->getMessage());
            session()->setFlashdata('warning', 'Payment processed but failed to generate receipt. Contact admin.');
        }

       
       
        return redirect('guardian/dashboard')->with('success', 'Payment successfully.');
        
    }
    
    
    public function payment_linkTuition()
    {
        $request = service('request');
        $session = session();

        
        $children = $this->request->getPost('children');
        $planID      = (int) $request->getPost('plan_id'); 
        $amount_php     = $request->getPost('payamount');
        $paymentDate    = date('Y-m-d');
        $fullname       = $request->getPost('fullname');
        $email          = $request->getPost('email');
        $number         = $request->getPost('number');
        $paymentMethod  = $request->getPost('paymentMethod'); // ex: card, gcash, dob
        $paymenttype    = $request->getPost('paymentOption');
        $card_number    = $request->getPost('cardNumber');
        $exp_month      = (int) $request->getPost('expiryMonth'); 
        $exp_year       = (int) $request->getPost('expiryYear');
        $cvc            = $request->getPost('cvv');
        $bank_code      = $request->getPost('accountName');
        $pay_type      = $request->getPost('pay_type');

       
        log_message('info', 'Payment Data: amount={amount}, fullname={fullname}, email={email}, number={number}, method={method}, type={type}, card={card}, exp_month={month}, exp_year={year}, cvc={cvc}, bank_code={bank}, childern={children}, planId={planID},pay_type={pay_type},paymentDate{paymentDate}', [
            'amount'   => $amount_php,
            'fullname' => $fullname,
            'email'    => $email,
            'number'   => $number,
            'method'   => $paymentMethod,
            'type'     => $paymenttype,
            'card'     => $card_number,
            'month'    => $exp_month,
            'year'     => $exp_year,
            'cvc'      => $cvc,
            'bank'     => $bank_code,
            'children' => json_encode($children),
            'planID'   => $planID,
            'pay_type' =>$pay_type,
            'paymentDate' =>$paymentDate
        ]);

       
        
        $studentId = $session->get('user_id');
        if (!$studentId) {
            return redirect()->to('/login');
        }

        $amount_cents = (int) $amount_php * 100;

        // STEP 1: Create Payment Intent
        $intentPayload = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_cents,
                    'payment_method_allowed' => [$paymentMethod],
                    'currency' => 'PHP',
                    'capture_type' => 'automatic',
                    'send_email_receipt' => true,
                    'receipt_email' => $email,
                    'description' => 'Student Payment',
                    'statement_descriptor' => 'StudentPay'
                ]
            ]
        ];

        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($intentPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $intentResponse = curl_exec($ch);
        curl_close($ch);
        $intentData = json_decode($intentResponse, true);

        if (!isset($intentData['data']['id'])) {
            return "Error creating payment intent: <pre>" . print_r($intentData, true) . "</pre>";
        }

        $intent_id  = $intentData['data']['id'];
        $client_key = $intentData['data']['attributes']['client_key'];

        // STEP 2: Create Payment Method
        if ($paymentMethod == 'card') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'card',
                        'details' => [
                            'card_number' => $card_number,
                            'exp_month'   => $exp_month,
                            'exp_year'    => $exp_year,
                            'cvc'         => $cvc,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } elseif ($paymentMethod == 'dob') {
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => 'dob',
                        'details' => [
                            'bank_code' => $bank_code,
                        ],
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                        ]
                    ]
                ]
            ];
        } else {
            // Other redirect methods (gcash, paymaya, grab_pay, etc.)
            $methodPayload = [
                'data' => [
                    'attributes' => [
                        'type' => $paymentMethod,
                        'billing' => [
                            'name'  => $fullname,
                            'email' => $email,
                            'phone' => $number,
                        ]
                    ]
                ]
            ];
        }

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($methodPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $methodResponse = curl_exec($ch);
        curl_close($ch);
        $methodData = json_decode($methodResponse, true);

        if (!isset($methodData['data']['id'])) {
            return "Error creating payment method: <pre>" . print_r($methodData, true) . "</pre>";
        }

        $payment_method_id = $methodData['data']['id'];

        // STEP 3: Attach Payment Method to Intent
        $attachPayload = [
            'data' => [
                'attributes' => [
                    'payment_method' => $payment_method_id,
                    'client_key'     => $client_key,
                    'return_url'     => base_url('payment/redirect-tuition')
                ]
            ]
        ];

        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/$intent_id/attach");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($attachPayload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $attachResponse = curl_exec($ch);
        curl_close($ch);
        $attachData = json_decode($attachResponse, true);

        // Handle redirect or success
        //$result = $StudentModel->processCashPayment($admissionId, $amountPaid, $paymentType, $paymentDate,$openingId);
        $status     = $attachData['data']['attributes']['status'] ?? null;
        $nextAction = $attachData['data']['attributes']['next_action']['redirect']['url'] ?? null;

        $session->set([
            'payment_amount'     => $amount_php,
            'payment_intent_id'  => $intent_id,
            'paymenttype'        => $paymenttype,
            'email'              => $email,
            'paymentDate'        => $paymentDate,
            'paymentMethod'      => 'Online',
            'planId'             => $planID,
            'children'           => $children,
            'pay_type'           => $pay_type,
            'fullname'           => $fullname,
            
        ]);

        if ($nextAction) {
            // Redirect-based payments
            return redirect()->to($nextAction);
        } elseif ($status === 'succeeded') {
            // Card paid immediately
            return redirect()->to(base_url('payment/redirect-tuition'));
        } else {
            return redirect()->to(base_url('payment/failed'));

            return "Error attaching payment method: <pre>" . print_r($attachData, true) . "</pre>";
        }
    }
    public function payOnlineTuition()
    {   
        //123
        $session = session();
        $children    = $session->get('children');
        $admissionId = $session->get('admissionID');
        $amountPaid  = $session->get('payment_amount');
        $paymentType = $session->get('paymentMethod');
        $paymentDate = $session->get('paymentDate');
        $planID      = $session->get('planId');
        $pay_type      = $session->get('pay_type');
        $email      = $session->get('email');
        $fullname      = $session->get('fullname');

        $PaymentModel = new \App\Models\PaymentModel();
        $openingmodel = new \App\Models\OpeningModel();
        $schedulemodel = new \App\Models\PaymentScheduleModel();
         $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];


        if($pay_type == 'full')
        {
            $result = $PaymentModel->payonlinefulltuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
             $schedulemodel->whereIn('user_id', $children)->delete();
        }elseif($pay_type == 'monthly')
        {

             $existing = $schedulemodel
                ->whereIn('user_id', $children)
                ->countAllResults();
            // Always apply payment to the remaining balances (partial or advance)
            $schedulemodel->payFlexibleForChildren($children, $amountPaid);

            $result = $PaymentModel->paycashTuitionMonthly($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);

        
        }else{
            
           $existing = $schedulemodel
                ->whereIn('user_id', $children)
                ->countAllResults();

            if ($existing == 0) {
                // First time tuition plan → create fixed 10 months with 2,500 each
                $schedulemodel->createMonthlyScheduleForChildren($children, $planID, $amountPaid, $paymentDate);
            }
            //123
            // Always apply payment to the remaining balances (partial or advance)
            $schedulemodel->payFlexibleForChildrenTuition($children, $amountPaid);

            $result = $PaymentModel->paycashTuitionpartial($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        }
        if ($result === true || $result === false || $result === null) {
            // no detailed processed data returned — build a simple placeholder entry
            $processed = $result;
            $processed = [
                [
                    'student_id' => $admissionId ?? null,
                    'student_name' => $fullname,
                    'parent_email' => $email,
                    'plan_id' => $planID,
                    'plan_name' => 'Tuition Plan',
                    'amount_paid' => (float)$amountPaid,
                    'remaining_balance' => null,
                    'payment_method' => $paymentType,
                    'payment_date' => $paymentDate,
                    'status' => 'Paid'
                ]
            ];
        }

        // If nothing processed
        if (empty($processed)) {
            return redirect('guardian/dashboard')->with('error', 'Payment failed or nothing processed.');
        }

        // === BUILD PDF HTML ===
        try {
            // Totals
            $totalPaid = 0.0;
            foreach ($processed as $p) {
                $totalPaid += floatval($p['amount_paid'] ?? 0);
            }

            // School info / logo
            $schoolName = "Brightside Learning Center";
            $schoolAddress = "Barangay, Bagumbayan, Santa Cruz, Laguna"; // change if needed
            $logoUrl = base_url('assets/img/logoicon.png'); // your provided logo path

            // Transaction reference
            $transactionRef = 'OR-' . date('YmdHis');

            // Build student rows HTML
            $rowsHtml = '';
            $i = 1;
            foreach ($processed as $p) {
                $studentName = esc($p['student_name'] ?? 'Student');
                $planName = esc($p['plan_name'] ?? $p['plan_id']);
                $amount = number_format(floatval($p['amount_paid'] ?? 0), 2);
                $remaining = isset($p['remaining_balance']) ? number_format(floatval($p['remaining_balance']), 2) : '-';
                $status = esc($p['status'] ?? '');
                $rowsHtml .= "
                    <tr>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$i</td>
                        <td style='padding:6px; border:1px solid #ddd;'>$studentName</td>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$planName</td>
                        <td style='text-align:right; padding:6px; border:1px solid #ddd;'>$amount</td>
                        <td style='text-align:right; padding:6px; border:1px solid #ddd;'>$remaining</td>
                        <td style='text-align:center; padding:6px; border:1px solid #ddd;'>$status</td>
                    </tr>";
                $i++;
            }

            // Breakdown list (BUL1)
            $breakdownItems = [
                "School Modules",
                "Learning Materials",
                "Instructional Tools & Supplies",
                "Montessori Apparatus",
                
            ];
            $breakdownHtml = '<ul style="margin:0; padding-left:18px; line-height:1.4;">';
            foreach ($breakdownItems as $it) {
                $breakdownHtml .= '<li style="margin-bottom:4px;">' . esc($it) . '</li>';
            }
            $breakdownHtml .= '</ul>';

            // Compose PDF HTML
            $pdfHtml = '
            <!doctype html>
            <html>
            <head>
                <meta charset="utf-8"/>
                <style>
                    body { font-family: DejaVu Sans, Arial, sans-serif; color:#222; font-size:12px; }
                    .header { display:flex; align-items:center; gap:12px; margin-bottom:8px; }
                    .logo { width:72px; }
                    .school { font-weight:700; font-size:16px; }
                    .address { font-size:11px; color:#444; }
                    .title { text-align:center; margin:8px 0 6px; font-size:14px; font-weight:700; }
                    table { width:100%; border-collapse:collapse; margin-top:8px; }
                    th, td { border:1px solid #ddd; padding:6px; }
                    th { background:#f4f4f4; text-align:left; }
                    .right { text-align:right; }
                    .center { text-align:center; }
                    .total-row td { font-weight:700; }
                    .section { margin-top:12px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div><img src="' . esc($logoUrl) . '" class="logo" alt="logo"></div>
                    <div>
                        <div class="school">' . esc($schoolName) . '</div>
                        <div class="address">' . esc($schoolAddress) . '</div>
                    </div>
                </div>

                <div class="title">OFFICIAL PAYMENT RECEIPT</div>

                <div style="font-size:12px; margin-bottom:6px;">
                    <strong>Receipt No:</strong> ' . esc($transactionRef) . ' &nbsp; | &nbsp;
                    <strong>Date:</strong> ' . esc(date('F d, Y H:i')) . '
                </div>

                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:4%;">#</th>
                                <th style="width:36%;">Student Name</th>
                                <th style="width:18%;" class="center">Plan / Month</th>
                                <th style="width:14%;" class="right">Amount Paid (₱)</th>
                                <th style="width:14%;" class="right">Remaining Balance (₱)</th>
                                <th style="width:14%;" class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $rowsHtml . '
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="right">TOTAL</td>
                                <td class="right">₱' . number_format($totalPaid, 2) . '</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Placement B: Breakdown AFTER total -->
                <div class="section">
                    <h4 style="margin:8px 0 6px;">Breakdown of Fees</h4>
                    ' . $breakdownHtml . '
                </div>

                <div style="margin-top:12px;">
                    <p>Thank you for your payment.</p>
                </div>
            </body>
            </html>
            ';

            // === GENERATE PDF via Dompdf ===
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($pdfHtml);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfOutput = $dompdf->output();

            // === SEND EMAIL with PDF ATTACHMENT ===
            if (!empty($email)) {
                try {
                    $emailService = \Config\Services::email();
                    $emailService->setFrom('ecohaven28@gmail.com', $schoolName);
                    $emailService->setTo($email);
                    $emailService->setSubject('Official Payment Receipt - ' . $transactionRef);
                    $emailService->setMailType('html');

                    // Build simple email HTML (you can use a view if preferred)
                    $studentLabel = (count($processed) === 1) ? esc($processed[0]['student_name']) : 'Multiple Children';
                    $emailMessage = '
                        <div style="font-family:Arial, sans-serif; color:#333; line-height:1.4;">
                            <div style="text-align:center;">
                                <img src="' . esc($logoUrl) . '" width="80" style="display:block;margin:6px auto;">
                                <h2 style="margin:6px 0;">' . esc($schoolName) . '</h2>
                                <p style="margin:0 0 8px 0;"><strong>Official Payment Receipt</strong></p>
                            </div>
                            <p>Good day,</p>
                            <p>This email is to confirm the payment for <strong>' . $studentLabel . '</strong>.</p>
                            <table style="width:100%; font-size:13px; margin-top:6px;">
                                <tr><td><strong>Amount Paid:</strong></td><td style="text-align:right;">₱' . number_format($totalPaid, 2) . '</td></tr>
                                <tr><td><strong>Payment Method:</strong></td><td style="text-align:right;">' . esc($paymentType) . '</td></tr>
                                <tr><td><strong>Payment Date:</strong></td><td style="text-align:right;">' . esc($paymentDate) . '</td></tr>
                                <tr><td><strong>Receipt No:</strong></td><td style="text-align:right;">' . esc($transactionRef) . '</td></tr>
                            </table>
                            <p style="margin-top:10px;">A printable copy of the official receipt is attached as a PDF for your records.</p>
                            <p>Thank you,<br><strong>' . esc($schoolName) . '</strong></p>
                        </div>
                    ';

                    $emailService->setMessage($emailMessage);
                    // attach raw pdf binary (filename and mime)
                    $filename = 'Official_Receipt_' . $transactionRef . '.pdf';
                    $emailService->attach($pdfOutput, 'application/pdf', $filename, 'attachment');

                    if (!$emailService->send()) {
                        log_message('error', 'Email sending failed: ' . print_r($emailService->printDebugger(['headers']), true));
                        session()->setFlashdata('warning', 'Payment processed but sending receipt email failed.');
                    } else {
                        log_message('info', 'Payment receipt PDF emailed to: ' . $email);
                        session()->setFlashdata('success', 'Payment completed and receipt sent to your email.');
                    }
                } catch (\Throwable $e) {
                    log_message('error', 'Email exception: ' . $e->getMessage());
                    session()->setFlashdata('warning', 'Payment processed but an error occurred while sending the receipt.');
                }
            } else {
                log_message('warning', 'No recipient email found; PDF generated but not emailed. Ref: ' . $transactionRef);
                session()->setFlashdata('success', 'Payment processed but no email provided for receipt.');
            }

        } catch (\Throwable $e) {
            log_message('error', 'PDF generation exception: ' . $e->getMessage());
            session()->setFlashdata('warning', 'Payment processed but failed to generate receipt. Contact admin.');
        }
        
        return redirect('guardian/dashboard')->with('success', 'Payment successful.');
        
    }
    public function payCashMics()
    {   
        $request = service('request');

        $children     = $request->getPost('children');
        $amountPaid   = $request->getPost('payamount');
        $email        = $request->getPost('email');
        $paymentType  = $request->getPost('paymentOption');
        $paymentDate  = date('Y-m-d');
        $planID       = (int) $request->getPost('plan_id'); 
         $adminName = session()->get('full_name Admin');

        log_message('info', 'payCashMics called. PlanID: {planID}, AmountPaid: {amount}, Email: {email}, PaymentType: {ptype}, Children: {children}', [
            'planID'   => $planID,
            'amount'   => $amountPaid,
            'email'    => $email,
            'ptype'    => $paymentType,
            'children' => json_encode($children)
        ]);

        $PaymentModel  = new \App\Models\PaymentModel();
        $OpeningModel  = new \App\Models\OpeningModel();

        $opening = $OpeningModel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            log_message('error', 'payCashMics: No active opening found.');
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }

        $openingId = $opening['id'];
        log_message('info', 'Active opening ID: {id}', ['id' => $openingId]);
        
        if ($planID == 3) {
            log_message('info', 'Executing payonlinemiscellaneous for PlanID 3.');
            $result = $PaymentModel->payonlinemiscellaneousCash($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
              $description = "Pay Miscellaneous paid: ₱$amountPaid via $paymentType.";
        } elseif ($planID == 4) {
            log_message('info', 'Executing payonlinefulltuition for PlanID 4.');
            $result = $PaymentModel->payonlinefulltuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        } elseif ($planID == 5) {
            log_message('info', 'Executing payonlinepartialtuition for PlanID 5.');
            $result = $PaymentModel->payonlinepartialtuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        } else {
            log_message('warning', 'Unknown planID: {planID}', ['planID' => $planID]);
        }

        log_message('info', 'Payment processing completed for PlanID {planID}', ['planID' => $planID]);
        //12345
            $audit = new \App\Models\AuditLogModel();
            $audit->insert([
                'admission_id' => $children[0],
                'action'       => 'payment Miscellaneous',
                'description'  => $description,
                'done_by'      => $adminName, // FULLNAME FROM SESSION
                'status'      => 'success',
            ]);

        session()->setFlashdata('success', 'Payment successfully.');
        return redirect('admin-payment')->with('success', 'Payment successfully.');
    }
    public function payCashTuition()
    {   
        //123
        $request = service('request');
        $children     = $request->getPost('children');
        $amountPaid   = $request->getPost('payamount');
        $email        = $request->getPost('email');
        $paymentType  = $request->getPost('paymentOption');
        $paymentDate  = date('Y-m-d');
        $planID       = (int) $request->getPost('plan_id');
        $pay_type    = $request->getPost('pay_type');
         $adminName = session()->get('full_name Admin');

        $PaymentModel = new \App\Models\PaymentModel();
        $openingmodel = new \App\Models\OpeningModel();
        $schedulemodel = new \App\Models\PaymentScheduleModel();
        $opening = $openingmodel->orderBy('id', 'DESC')->first();
        if (!$opening) {
            return redirect()->to('admin-admission')->with('error', 'No active opening found.');
        }
        $openingId = $opening['id'];


        if($pay_type == 'full')
        {
            $result = $PaymentModel->payonlinefulltuition($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
            $schedulemodel->whereIn('user_id', $children)->delete();
             $description = "Full tuition paid: ₱$amountPaid via $paymentType.";
            
        }elseif($pay_type == 'monthly')
        {

             $existing = $schedulemodel
                ->whereIn('user_id', $children)
                ->countAllResults();
            
            $schedulemodel->payFlexibleForChildren($children, $amountPaid);
              $description = "Monthly tuition paid: ₱$amountPaid via $paymentType.";

            $result = $PaymentModel->paycashTuitionMonthly($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
          

        

        }else{
            
           $existing = $schedulemodel
                ->whereIn('user_id', $children)
                ->countAllResults();

            if ($existing == 0) {
                // First time tuition plan → create fixed 10 months with 2,500 each
                $schedulemodel->createMonthlyScheduleForChildren($children, $planID, $amountPaid, $paymentDate);
            }

            // Always apply payment to the remaining balances (partial or advance)
            $schedulemodel->payFlexibleForChildrenTuition($children, $amountPaid);
            $description = "Partial tuition payment: ₱$amountPaid via $paymentType.";

            $result = $PaymentModel->paycashTuitionpartial($children, $amountPaid, $paymentType, $paymentDate, $openingId, $planID);
        }
        
        $audit = new \App\Models\AuditLogModel();
            $audit->insert([
                'admission_id' => $children[0],
                'action'       => 'payment Tuition',
                'description'  => $description,
                'done_by'      => $adminName, // FULLNAME FROM SESSION
                'status'      => 'success',
            ]);

        return redirect('admin-payment')->with('success', 'Payment successfully.');
        
        
    }

    public function redirectpayment()
    {
        $request = service('request');
        $intentId = $request->getGet('payment_intent_id');

        if (!$intentId) {
            return redirect()->to(base_url('registration/failed'));
        }

        // Get status from PayMongo API
        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/" . $intentId);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        $status = $data['data']['attributes']['status'] ?? 'failed';

        if (in_array($status, ['failed', 'expired', 'canceled'])) {
            return redirect()->to(base_url('registration/failed'));
        }

        if ($status === 'succeeded') {
            return redirect()->to(base_url('registration/success'));
        }

        return redirect()->to(base_url('registration/failed'));
    }
    public function redirectpaymentMicelenious()
    {
        $request = service('request');
        $intentId = $request->getGet('payment_intent_id');

        if (!$intentId) {
            return redirect()->to(base_url('registration/failed'));
        }

        // Get status from PayMongo API
        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/" . $intentId);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        $status = $data['data']['attributes']['status'] ?? 'failed';

        if (in_array($status, ['failed', 'expired', 'canceled'])) {
            return redirect()->to(base_url('registration/failed'));
        }

        if ($status === 'succeeded') {
            return redirect()->to(base_url('miscellaneous/success'));
        }

        return redirect()->to(base_url('registration/failed'));
    }
    public function redirectpaymentTuition()
    {
        $request = service('request');
        $intentId = $request->getGet('payment_intent_id');

        if (!$intentId) {
            return redirect()->to(base_url('registration/failed'));
        }

        // Get status from PayMongo API
        $ch = curl_init("https://api.paymongo.com/v1/payment_intents/" . $intentId);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->paymongo_secret_key . ':')
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        $status = $data['data']['attributes']['status'] ?? 'failed';

        if (in_array($status, ['failed', 'expired', 'canceled'])) {
            return redirect()->to(base_url('registration/failed'));
        }

        if ($status === 'succeeded') {
            return redirect()->to(base_url('tuition/success'));
        }

        return redirect()->to(base_url('registration/failed'));
    }





    







}
