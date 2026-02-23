<?php
namespace App\Models;
use CodeIgniter\Model;

class TuitionPlanModel extends Model
{
    protected $table = 'tuitionplans';
    protected $primaryKey = 'plan_id';
    protected $allowedFields = [
        'class_id',
        'plan_name',
        'payment_type',
        'total_amount',
        'discount'
    ];

    // Method para kunin lahat ng plans
    public function getAllPlans()
    {
        return $this->orderBy('plan_name', 'ASC')->findAll();
    }

    // Method para kunin plan by ID
    public function getPlanById($plan_id)
    {
        return $this->where('plan_id', $plan_id)->first();
    }

    // Optional: method para makuha plans by class
    public function getPlansByClass($class_id)
    {
        return $this->where('class_id', $class_id)->orderBy('plan_name', 'ASC')->findAll();
    }
    
}
