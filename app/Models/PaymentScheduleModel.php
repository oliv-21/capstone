<?php
namespace App\Models;
use CodeIgniter\Model;

class PaymentScheduleModel extends Model
{
    protected $table = 'paymentschedule';
    protected $primaryKey = 'schedule_id';
    protected $allowedFields = [
        'user_id',
        'plan_id',
        'due_date',
        'amount_due',
        'remaining_balance',
        'status',
        'late_fee'
    ];

    // Kunin lahat ng payment schedules
    public function getAllSchedules()
    {
        return $this->orderBy('due_date', 'ASC')->findAll();
    }

    // Kunin schedule by user
    public function getSchedulesByUser($user_id)
    {
        return $this->where('user_id', $user_id)
                    ->orderBy('due_date', 'ASC')
                    ->findAll();
    }

    // Kunin schedule by plan
    public function getSchedulesByPlan($plan_id)
    {
        return $this->where('plan_id', $plan_id)
                    ->orderBy('due_date', 'ASC')
                    ->findAll();
    }

    // Kunin overdue schedules
    public function getOverdueSchedules()
    {
        return $this->where('status', 'Overdue')
                    ->orderBy('due_date', 'ASC')
                    ->findAll();
    }
    public function createMonthlyScheduleForChildren(array $child_ids, $planId, $totalAmount, $startDate = null)
    {
        $monthlyDue = 2500;
        $startDate = $startDate ?? date('Y-m-01');
        $numMonths = 10;

        foreach ($child_ids as $child_id) {

            // ✅ Skip if child already has schedule
            $existing = $this->where('user_id', $child_id)->countAllResults();
            if ($existing > 0) {
                continue;
            }

            for ($i = 0; $i < $numMonths; $i++) {
                $this->insert([
                    'user_id' => $child_id,
                    'plan_id' => $planId,
                    'due_date' => date('Y-m-d', strtotime("+$i month", strtotime($startDate))),
                    'amount_due' => $monthlyDue,
                    'remaining_balance' => $monthlyDue,
                    'status' => 'Pending',
                    'late_fee' => 0
                ]);
            }
        }

        return "Schedules created successfully.";
    }

     /**
     * Apply a single total payment across multiple children
     * Handles partial payments and advance payments
     * @param array $child_ids
     * @param float $totalPaymentAmount
     */
    public function payFlexibleForChildren(array $child_ids, $totalPaymentAmount)
    {
        // Get all schedules for all children in order of due_date
        $allSchedules = $this->whereIn('user_id', $child_ids)
                            ->where('remaining_balance >', 0)
                            ->orderBy('due_date', 'ASC')
                            ->findAll();

        $remainingPayment = $totalPaymentAmount;

        foreach ($allSchedules as $schedule) {
            if ($remainingPayment <= 0) break;

            $remaining = $schedule['remaining_balance'];

            if ($remainingPayment >= $remaining) {
                // Fully pay this month
                $remainingPayment -= $remaining;
                $this->update($schedule['schedule_id'], [
                    'remaining_balance' => 0,
                    'status' => 'Paid'
                ]);
            } else {
                // Partial payment
                $newRemaining = $remaining - $remainingPayment;
                $this->update($schedule['schedule_id'], [
                    'remaining_balance' => $newRemaining,
                    'status' => 'Pending'
                ]);
                $remainingPayment = 0;
            }
        }

        return "Payment of {$totalPaymentAmount} applied across all selected children!";
    }

    public function getPaymentScheduleByUser($userId)
    {
        $builder = $this->db->table('paymentschedule p');
        $builder->select("
            p.due_date,
            p.amount_due,
            p.remaining_balance,
            p.status,
            a.admission_id,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');

        return $builder->get()->getResultArray();
    }
    public function createMonthlyScheduleForChildEnrollment($child_id,$MonthyTuitionFee)
    {
        
        $planId = 4; 
        $startDate = date('Y-m-d');
        $numMonths = 10;

    
        $existing = $this->where('user_id', $child_id)->countAllResults();
        if ($existing > 0) {
            return "Schedule already exists for this child.";
        }

        for ($i = 0; $i < $numMonths; $i++) {
            $this->insert([
                'user_id' => $child_id,
                'plan_id' => $planId,
                'due_date' => date('Y-m-d', strtotime("+$i month", strtotime($startDate))),
                'amount_due' => $MonthyTuitionFee,
                'remaining_balance' => $MonthyTuitionFee,
                'status' => 'Pending',
                'late_fee' => 0
            ]);
        }
        log_message('info', "Monthly schedule successfully created for child ID: {$child_id}");

        return "Schedule created successfully for child ID: {$child_id}.";
    }
    public function payFlexibleForChildrenTuition(array $child_ids, $totalPaymentAmount)
    {
        // Divide payment equally per child
        $perChildPayment = $totalPaymentAmount / count($child_ids);

        foreach ($child_ids as $childId) {

            $remainingPayment = $perChildPayment;

            // Get this child's schedules only
            $schedules = $this->where('user_id', $childId)
                            ->where('remaining_balance >', 0)
                            ->orderBy('due_date', 'ASC')
                            ->findAll();

            foreach ($schedules as $sched) {

                if ($remainingPayment <= 0)
                    break;

                $remaining = $sched['remaining_balance'];

                if ($remainingPayment >= $remaining) {
                    // FULL PAYMENT for this schedule
                    $remainingPayment -= $remaining;

                    $this->update($sched['schedule_id'], [
                        'remaining_balance' => 0,
                        'status' => 'Paid'
                    ]);
                } else {
                    // PARTIAL PAYMENT
                    $newRemaining = $remaining - $remainingPayment;

                    $this->update($sched['schedule_id'], [
                        'remaining_balance' => $newRemaining,
                        'status' => 'Pending'
                    ]);

                    $remainingPayment = 0;
                }
            }
        }

        return "Flexible payment of {$totalPaymentAmount} applied successfully!";
    }
    //==============================new Function==================================
    public function getPaymentScheduleByUserOpening($userId, $openingId)
    {
        $builder = $this->db->table('paymentschedule p');
        $builder->select("
            p.due_date,
            p.amount_due,
            p.remaining_balance,
            p.status,
            a.admission_id,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name
        ");
        $builder->join('admissions a', 'a.admission_id = p.user_id', 'inner');
        $builder->where('a.user_id', $userId);
        $builder->where('a.status', 'Enrolled');

        return $builder->get()->getResultArray();
    }





    


}
