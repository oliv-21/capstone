<?php
namespace App\Models;
use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $allowedFields = ['class_id', 'classname', 'tuitionfee','monthly_payment', 'miscellaneous','status'];


    public function gettuition()
    {
        $user_id = session()->get('user_id');

        $builder = $this->db->table('students');
        $builder->select('students.class_level, classes.tuitionfee');
        $builder->join('classes', 'students.class_level = classes.classname');
        $builder->where('students.user_id', $user_id);

        return $builder->get()->getRow(); // Or ->get()->getResult() for multiple
    }

    public function allstudenttuition($user_id)
    {
        $builder = $this->db->table('students');
        $builder->select('students.class_level, classes.tuitionfee, classes.monthly_payment');
        $builder->join('classes', 'students.class_level = classes.classname');
        $builder->where('students.user_id', $user_id);

        return $builder->get()->getRow(); // returns object with tuitionfee
    }
    public function getMiscellaneous($user_id)
    {
        $builder = $this->db->table('admissions AS a');
        $builder->select('c.miscellaneous');
        $builder->join('students AS s', 'a.admission_id = s.student_id');
        $builder->join('classes AS c', 's.class_level = c.classname');
        $builder->where('a.user_id', $user_id);

        return $builder->get()->getRow();
    }
    public function getTuitionFee($user_id)
    {
        $builder = $this->db->table('admissions AS a');
        $builder->select('c.tuitionfee');
        $builder->join('students AS s', 'a.admission_id = s.student_id');
        $builder->join('classes AS c', 's.class_level = c.classname');
        $builder->where('a.user_id', $user_id);
        $builder->where('a.status', 'Enrolled'); // optional

        return $builder->get()->getResultArray(); 
    }
    public function getTuitionFeeComputation($user_id)
    {
        $builder = $this->db->table('admissions AS a');
        $builder->select('c.tuitionfee');
        $builder->join('students AS s', 'a.admission_id = s.student_id');
        $builder->join('classes AS c', 's.class_level = c.classname');
        $builder->where('a.admission_id', $user_id);
        $builder->where('a.status', 'Enrolled'); // optional

        return $builder->get()->getResultArray(); 
    }

    public function getMonthyTuitionFee($user_id)
    {
        // Log the method call
        log_message('info', "getMonthyTuitionFee called for user_id: {$user_id}");

        $builder = $this->db->table('admissions AS a');
        $builder->select('c.monthly_payment');
        $builder->join('students AS s', 'a.admission_id = s.student_id');
        $builder->join('classes AS c', 's.class_level = c.classname');
        $builder->where('a.admission_id', $user_id);

        $result = $builder->get()->getRow();

        // Optional: log the result
        log_message('info', "Monthly tuition fee retrieved: " . ($result->monthly_payment ?? '0'));

        return $result;
    }
    public function PayTuitioncash($user_id)
    {
        $builder = $this->db->table('students');
        $builder->select('students.class_level, classes.tuitionfee, classes.monthly_payment, classes.miscellaneous');
        $builder->join('classes', 'students.class_level = classes.classname');
        $builder->where('students.user_id', $user_id);

        return $builder->get()->getRowArray(); // return as ARRAY
    }
    public function getActiveClassNames()
    {
        return $this->select('classname')
                    ->where('status', 'active')
                    ->findAll(); // returns array of objects or arrays depending on model settings
    }
    //=======================================================================New Data dec 4============================================================================
    public function getActiveClassNamesOpining($openingID)    
    {
        return $this->select('classname')
                    
                    ->where('class_id =', $openingID) 
                    ->findAll(); // returns array of objects or arrays depending on model settings
    }






    
}
