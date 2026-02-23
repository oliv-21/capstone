<?php
namespace App\Models;
use App\Models\Admission_Model;
use App\Models\TuitionPlanModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = [
        'user_id', 'plan_id', 'amount_paid', 'remaining_balance', 'payment_method', 'payment_date','status'
    ];

    public function getChildPaymentHistory($parent_id, $limit = 25, $offset = 0)
    {
        $parent_id = (int) $parent_id;

        $builder = $this->select([
                'CONCAT(a.last_name, ", ", a.first_name) AS name',
                't.plan_name AS FeeType',
                'pay.amount_paid',
                'pay.remaining_balance',
                't.total_amount', 
                'pay.payment_date',
                'CASE WHEN pay.remaining_balance = 0 THEN "Paid" ELSE "Pending" END AS Status'
            ], false)
        ->from('payments pay')
        ->join('admissions a', 'pay.user_id = a.user_id')
        ->join('tuitionplans t', 'pay.plan_id = t.plan_id')
        ->where('a.user_id', $parent_id)
        ->orderBy('pay.payment_date', 'DESC')
        ->limit($limit, $offset);
        return $builder->get()->getResult();
    }
    public function getChildPaymentHistoryPayment($parent_id, $limit = 25, $offset = 0)
    {
        $parent_id = (int) $parent_id;

        $builder = $this->select([
                'CONCAT(a.last_name, ", ", a.first_name) AS name',
                't.plan_name AS FeeType',
                'pay.amount_paid',
                'pay.remaining_balance',
                't.total_amount', 
                'pay.payment_date',
                'CASE WHEN pay.remaining_balance = 0 THEN "Paid" ELSE "Pending" END AS Status'
            ], false)
        ->from('payments pay')
        ->join('admissions a', 'pay.user_id = a.admission_id')
        ->join('tuitionplans t', 'pay.plan_id = t.plan_id')
        ->where('a.admission_id', $parent_id)
        ->orderBy('pay.payment_date', 'DESC')
        ->limit($limit, $offset);
        return $builder->get()->getResult();
    }
    //========== letche ==========
    public function getChildPaymentHistoryPaymentNew($parent_id, $limit = 25, $offset = 0)
    {
        $parent_id = (int) $parent_id;

        $builder = $this->select([
                'CONCAT(a.last_name, ", ", a.first_name) AS name',
                 'a.admission_id',
                't.plan_name AS FeeType',
                'pay.amount_paid',
                'pay.remaining_balance',
                't.total_amount', 
                'pay.payment_date',
                'CASE WHEN pay.remaining_balance = 0 THEN "Paid" ELSE "Pending" END AS Status'
            ], false)
        ->from('payments pay')
        ->join('admissions a', 'pay.user_id = a.admission_id')
        ->join('tuitionplans t', 'pay.plan_id = t.plan_id')
        ->where('a.admission_id', $parent_id)
        ->orderBy('pay.payment_date', 'DESC')
        ->limit($limit, $offset);

        return $builder->get()->getResultArray();
    }

    //=======================================
    public function getGuardianPayments($guardianId,$planId,$micellaneousFee)
    {
       
        //123
        $builder = $this->db->table('admissions a');

        // Subquery: get latest payment_id per student for this plan
        $subQuery = "
            SELECT user_id, MAX(payment_id) AS latest_payment_id
            FROM payments
            WHERE plan_id = {$planId}
            GROUP BY user_id
        ";

        $builder->select([
            'COALESCE(p.amount_paid, 0) as amount_paid',
            "COALESCE(p.remaining_balance, {$micellaneousFee}) AS remaining_balance",
            'a.user_id as guardian_id',
            'a.admission_id',
            'COALESCE(p.status, "Not Paid") as status',
            'CONCAT(a.last_name, " ", a.first_name) as full_name'
        ]);

        $builder->join("($subQuery) lp", 'lp.user_id = a.admission_id', 'left');
        $builder->join('payments p', 'p.payment_id = lp.latest_payment_id', 'left');
        $builder->where('a.user_id', $guardianId);
         $builder->where('a.status', 'Enrolled');

        return $builder->get()->getResultArray();

       
    }
    public function getGuardianPaymenmisc($guardianId, $planId)
    {
        //123
        $builder = $this->db->table('admissions a');

        // Subquery: latest payment per student for this plan
        $subQuery = "
            SELECT user_id, MAX(payment_id) AS latest_payment_id
            FROM payments
            WHERE plan_id = {$planId}
            GROUP BY user_id
        ";

        $builder->select([
            'COALESCE(p.amount_paid, 0) AS amount_paid',
            'COALESCE(p.remaining_balance, c.miscellaneous) AS remaining_balance',
            'a.user_id AS guardian_id',
            'a.admission_id',
            'COALESCE(p.status, "Pending") AS status',
            'CONCAT(a.last_name, " ", a.first_name) AS full_name',
            'c.miscellaneous AS miscellaneous',
            

        ]);

        $builder->join("($subQuery) lp", 'lp.user_id = a.admission_id', 'left');
        $builder->join('payments p', 'p.payment_id = lp.latest_payment_id', 'left');

        // JOIN class level
        $builder->join('students s', 's.student_id = a.admission_id');
        $builder->join('classes c', 'c.classname = s.class_level');

        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');

        return $builder->get()->getResultArray();
    }
    
    public function payonlinemiscellaneous($childrens, $amountPaid, $paymentType, $paymentDate, $openingId, $planID)
    {
        
        log_message('info', '--- START: payonlinefulltuition ---');
        log_message('info', 'Incoming Data: Children: {childs}, AmountPaid: {paid}, PlanID: {plan}, Method: {method}', [
        'childs' => json_encode($childrens),
        'paid' => $amountPaid,
        'plan' => $planID,
        'method' => $paymentType
    ]);

    $TuitionPlanModel = new TuitionPlanModel();
    $plan = $TuitionPlanModel->getPlanById((int) $planID);

    log_message('info', 'Plan Retrieved: Total Amount {tot}', ['tot' => $plan['total_amount']]);

    $totalChildren = count($childrens);
    $perChildAmount = $amountPaid / $totalChildren;

    log_message('info', 'Per Child Computation: {perchild}', ['perchild' => $perChildAmount]);

    foreach ($childrens as $studentId) {

        log_message('info', 'Processing ChildID: {id}', ['id' => $studentId]);

        // 1. Get latest record
        $existing = $this->where('user_id', $studentId)
                         ->where('plan_id', $planID)
                         ->orderBy('payment_id', 'DESC')
                         ->first();

        if ($existing) {
            log_message('info', 'Existing Payment Found: Remaining {remain}', ['remain' => $existing['remaining_balance']]);
            $remainingBalance = max(0, $existing['remaining_balance'] - $perChildAmount);
        } else {
            log_message('info', 'NO Previous Payment Found. Using Full Plan Amount {full}', ['full' => $plan['total_amount']]);
            $remainingBalance = max(0, $plan['total_amount'] - $perChildAmount);
        }

        log_message('info', 'Computed Remaining for Child {id}: {remain}', [
            'id' => $studentId,
            'remain' => $remainingBalance
        ]);

        $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

        // 4. Save record
        $insert = [
            'user_id'           => $studentId,
            'plan_id'           => $planID,
            'amount_paid'       => $perChildAmount,
            'remaining_balance' => $remainingBalance,
            'payment_method'    => $paymentType,
            'payment_date'      => $paymentDate,
            'status'            => $status
        ];

        $this->insert($insert);

        log_message('info', 'INSERTED PAYMENT: {data}', ['data' => json_encode($insert)]);
    }

    log_message('info', '--- END: payonlinefulltuition ---');

    }
    public function getGuardianPaymentstuition($guardianId, $planId)
    {
        //123
        $builder = $this->db->table('admissions a');

        // Subquery: latest payment per student for this plan
        $subQuery = "
            SELECT user_id, MAX(payment_id) AS latest_payment_id
            FROM payments
            WHERE plan_id = {$planId}
            GROUP BY user_id
        ";

        $builder->select([
            'COALESCE(p.amount_paid, 0) AS amount_paid',
            'COALESCE(p.remaining_balance, c.tuitionfee) AS remaining_balance',
            'a.user_id AS guardian_id',
            'a.admission_id',
            'COALESCE(p.status, "Pending") AS status',
            'CONCAT(a.last_name, " ", a.first_name) AS full_name',
            'c.tuitionfee AS tuition_fee',
            'c.monthly_payment AS monthly_payment'

        ]);

        $builder->join("($subQuery) lp", 'lp.user_id = a.admission_id', 'left');
        $builder->join('payments p', 'p.payment_id = lp.latest_payment_id', 'left');

        // JOIN class level
        $builder->join('students s', 's.student_id = a.admission_id');
        $builder->join('classes c', 'c.classname = s.class_level');

        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');

        return $builder->get()->getResultArray();
    }


    public function payonlinefulltuition($childrens, $amountPaid, $paymentType, $paymentDate, $openingId, $planID)
{
    $TuitionPlanModel = new TuitionPlanModel();
    $plan = $TuitionPlanModel->getPlanById((int) $planID);

    log_message('info', 'Starting online misc payment. PlanID: {planID}, TotalAmountPaid: {paid}, ChildrenCount: {count}', [
        'planID' => $planID,
        'paid'   => $amountPaid,
        'count'  => count($childrens)
    ]);

    $totalChildren  = count($childrens);
    $perChildAmount = $amountPaid / $totalChildren;

    foreach ($childrens as $studentId) {

        $remainingBalance = max(0, $plan['total_amount'] - $perChildAmount);
        $status           = $remainingBalance <= 0 ? 'Paid' : 'Pending';

        log_message('info', 'Inserting payment for Child {child}. PerChildAmount: {per}, Remaining: {remain}, Status: {status}', [
            'child'  => $studentId,
            'per'    => $perChildAmount,
            'remain' => $remainingBalance,
            'status' => $status
        ]);

        $this->insert([
            'user_id'           => $studentId,
            'plan_id'           => $planID,
            'amount_paid'       => $perChildAmount,
            'remaining_balance' => 0,
            'payment_method'    => $paymentType,
            'payment_date'      => $paymentDate,
            'status'            => 'Paid'
        ]);
    }
}


    public function payonlinetuition($childrens, $amountPaid, $paymentType, $paymentDate, $openingId, $planID)
    {
        
        $TuitionPlanModel = new TuitionPlanModel();
        $plan = $TuitionPlanModel->getPlanById((int) $planID);

        log_message('info', 'Starting online misc payment. PlanID: {planID}, TotalAmountPaid: {paid}, ChildrenCount: {count}', [
            'planID' => $planID,
            'paid' => $amountPaid,
            'count' => count($childrens)
        ]);

        $totalChildren = count($childrens);
        $perChildAmount = $amountPaid / $totalChildren;

        foreach ($childrens as $studentId) {

            $remainingBalance = max(0, $plan['total_amount'] - $perChildAmount);
            $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

            log_message('info', 'Inserting payment for Child {child}. PerChildAmount: {per}, Remaining: {remain}, Status: {status}', [
                'child'  => $studentId,
                'per'    => $perChildAmount,
                'remain' => $remainingBalance,
                'status' => $status
            ]);

            $this->insert([
                'user_id'          => $studentId,
                'plan_id'          => $planID,
                'amount_paid'      => $perChildAmount,
                'remaining_balance'=> $remainingBalance,
                'payment_method'   => $paymentType,
                'payment_date'     => $paymentDate,
                'status'           => $status
            ]);
        }

    }
    public function getPaymentHistory($userId, $planId = 4)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('p.plan_id', $planId);
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function getAllPaymentHistory($userId)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.payment_id,
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            p.plan_id,
            CONCAT(a.first_name, ' ', a.last_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');
        $builder->orderBy('p.payment_id', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function getPaymentForTuition($userId)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);

        $builder->where('a.status', 'Enrolled');
         $builder->where('p.plan_id', '2');
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function paymentMischistory($userId, $planId = 3)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.payment_id,
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('p.plan_id', $planId);
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function paymentTuitionhistory($userId, $planId = 4)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.payment_id,
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('p.plan_id', $planId);
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function paymentReceipt($paymentID)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.*,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name,
            CONCAT(g.last_name, ' ', g.first_name) AS guardianfull_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');   
        $builder->join('guardiansaccount g', 'g.user_id = a.user_id', 'left');
        $builder->where('p.payment_id', $paymentID);

        return $builder->get()->getRowArray();
    }
    public function paycashTuitionMonthly($childrens, $amountPaid, $paymentType, $paymentDate, $openingId)
    {
        log_message('info', '--- START: paycashTuitionMonthly ---');

        log_message('info', 'Incoming Children: {childs}', [
            'childs' => json_encode($childrens)
        ]);

        // Load class model
        $classModel = new \App\Models\ClassModel();

        foreach ($childrens as $studentId) {

            log_message('info', 'Processing ChildID: {id}', ['id' => $studentId]);

            // Get student's class info
            $student = $classModel->PayTuitioncash($studentId);
            if (!$student) {
                log_message('error', "NO CLASS found for Student $studentId");
                continue;
            }

            $tuition = $student['tuitionfee'];
            $monthly = $student['monthly_payment'];
            $misc = $student['miscellaneous'];

            log_message('info', "Class Info: Tuition=$tuition Monthly=$monthly Misc=$misc");

            // Latest payment record
            $existing = $this->where('user_id', $studentId)
                            ->orderBy('payment_id', 'DESC')
                            ->where('plan_id', 4) // Assuming plan_id 4 is for monthly tuition
                            ->first();

            if ($existing) {
                $remainingBalance = max(0, $existing['remaining_balance'] - $monthly);

                log_message('info', "Existing Payment: OldRemain={$existing['remaining_balance']} NewRemain=$remainingBalance");

            } else {
                // First time: tuition + misc
                $totalAmountDue = $tuition;
                $remainingBalance = max(0, $totalAmountDue - $monthly);

                log_message('info', "First Payment: TotalDue=$totalAmountDue NewRemain=$remainingBalance");
            }

            $status = $remainingBalance <= 0 ? 'Paid' : 'Pending';

            // Insert payment (monthly)
            $insert = [
                'user_id'           => $studentId,
                'amount_paid'       => $monthly,      // ALWAYS MONTHLY PAYMENT
                'remaining_balance' => $remainingBalance,
                'payment_method'    => $paymentType,
                'payment_date'      => $paymentDate,
                'status'            => $status,
                'opening_id'        => $openingId,
                'plan_id'           => 4 // Monthly Tuition Plan
            ];

            $this->insert($insert);

            log_message('info', 'Inserted Payment: {data}', ['data' => json_encode($insert)]);
        }

        log_message('info', '--- END: paycashTuitionMonthly ---');
    }
    public function paycashTuitionpartial($childrens, $amountPaid, $paymentType, $paymentDate, $openingId)
    {
        log_message('info', '--- START: paycashTuitionMonthly (DIVIDED) ---');

        log_message('info', 'Incoming Children: {childs}', [
            'childs' => json_encode($childrens)
        ]);

        $classModel = new \App\Models\ClassModel();

        // Step 1: base division
        $perChildBase = $amountPaid / count($childrens);
        $perChild = $perChildBase;  // may adjust later

        log_message('info', "Total Paid = {$amountPaid}, Per Child = {$perChild}");

        // Step 2: get ALL children remaining balances first
        $childrenData = [];

        foreach ($childrens as $studentId) {

            $student = $classModel->PayTuitioncash($studentId);
            if (!$student) continue;

            // get latest payment
            $existing = $this->where('user_id', $studentId)
                            ->orderBy('payment_id', 'DESC')
                            ->where('plan_id', 4)
                            ->first();

            if ($existing) {
                $remaining = $existing['remaining_balance'];
            } else {
                $remaining = $student['tuitionfee'];
            }

            $childrenData[] = [
                'id' => $studentId,
                'remaining' => $remaining
            ];
        }

        // Step 3: loop again and apply equal payments with redistribution
        $activeChildren = count($childrenData);

        foreach ($childrenData as &$child) {

            $studentId = $child['id'];
            $remaining = $child['remaining'];

            if ($remaining <= $perChild) {

                // this child will be fully paid
                $actualPaid = $remaining;  // only pay what they owe
                $child['remaining'] = 0;

                // redistribute extra
                $extra = $perChild - $actualPaid;
                $activeChildren--;

                if ($activeChildren > 0) {
                    $perChild += ($extra / $activeChildren);
                }

                log_message('info', "Child $studentId FULLY PAID. Extra redistributed.");

            } else {

                // normal divided payment
                $actualPaid = $perChild;
                $child['remaining'] = $remaining - $perChild;
            }

            // Insert payment record
            $insert = [
                'user_id'           => $studentId,
                'amount_paid'       => $actualPaid,
                'remaining_balance' => $child['remaining'],
                'payment_method'    => $paymentType,
                'payment_date'      => $paymentDate,
                'status'            => ($child['remaining'] <= 0 ? 'Paid' : 'Pending'),
                'opening_id'        => $openingId,
                'plan_id'           => 4
            ];

            $this->insert($insert);

            log_message('info', 'Inserted Payment: {data}', ['data' => json_encode($insert)]);
        }

        log_message('info', '--- END: paycashTuitionMonthly (DIVIDED) ---');
    }
    public function payonlinemiscellaneousCash($childrens, $amountPaid, $paymentType, $paymentDate, $openingId, $planID)
    {
        
        log_message('info', '--- START: paycashTuitionMonthly (DIVIDED) ---');

        log_message('info', 'Incoming Children: {childs}', [
            'childs' => json_encode($childrens)
        ]);

        $classModel = new \App\Models\ClassModel();

        // Step 1: base division
        $perChildBase = $amountPaid / count($childrens);
        $perChild = $perChildBase;  // may adjust later

        log_message('info', "Total Paid = {$amountPaid}, Per Child = {$perChild}");

        // Step 2: get ALL children remaining balances first
        $childrenData = [];

        foreach ($childrens as $studentId) {

            $student = $classModel->PayTuitioncash($studentId);
            if (!$student) continue;

            // get latest payment
            $existing = $this->where('user_id', $studentId)
                            ->orderBy('payment_id', 'DESC')
                            ->where('plan_id', 3)
                            ->first();

            if ($existing) {
                $remaining = $existing['remaining_balance'];
            } else {
                $remaining = $student['miscellaneous'];
            }

            $childrenData[] = [
                'id' => $studentId,
                'remaining' => $remaining
            ];
        }

        // Step 3: loop again and apply equal payments with redistribution
        $activeChildren = count($childrenData);

        foreach ($childrenData as &$child) {

            $studentId = $child['id'];
            $remaining = $child['remaining'];

            if ($remaining <= $perChild) {

                // this child will be fully paid
                $actualPaid = $remaining;  // only pay what they owe
                $child['remaining'] = 0;

                // redistribute extra
                $extra = $perChild - $actualPaid;
                $activeChildren--;

                if ($activeChildren > 0) {
                    $perChild += ($extra / $activeChildren);
                }

                log_message('info', "Child $studentId FULLY PAID. Extra redistributed.");

            } else {

                // normal divided payment
                $actualPaid = $perChild;
                $child['remaining'] = $remaining - $perChild;
            }

            // Insert payment record
            $insert = [
                'user_id'           => $studentId,
                'amount_paid'       => $actualPaid,
                'remaining_balance' => $child['remaining'],
                'payment_method'    => $paymentType,
                'payment_date'      => $paymentDate,
                'status'            => ($child['remaining'] <= 0 ? 'Paid' : 'Pending'),
                'opening_id'        => $openingId,
                'plan_id'           => 3
            ];

            $this->insert($insert);

            log_message('info', 'Inserted Payment: {data}', ['data' => json_encode($insert)]);
        }

        log_message('info', '--- END: paycashTuitionMonthly (DIVIDED) ---');

    }
    // ========== new METHODS BELOW ==========
    public function paymentTuitionhistorOpening($userId, $planId = 4, $openingId)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.payment_id,
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('p.plan_id', $planId);
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');
        $builder->where('a.openingclosing_id', $openingId);
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function getPaymentForTuitionOpening($userId, $openingId)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);
        
        $builder->where('a.status', 'Enrolled');
        $builder->where('a.openingclosing_id', $openingId);
        $builder->where('p.plan_id', '2');
        $builder->orderBy('p.payment_date', 'DESC');

        return $builder->get()->getResultArray();
    }
    //============new methods below===========
    public function getAllPaymentHistoryOpening($userId,$openingId)
    {
        $builder = $this->db->table('payments p');
        
        $builder->select("
            p.payment_id,
            p.amount_paid,
            p.payment_method,
            p.payment_date,
            p.plan_id,
            CONCAT(a.first_name, ' ', a.last_name) AS full_name
        ");
        
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);
        $builder->where('a.openingclosing_id', $openingId);
        $builder->where('a.status', 'Enrolled');
        $builder->orderBy('p.payment_id', 'DESC');

        return $builder->get()->getResultArray();
    }

}




