<?php
namespace App\Models;
use CodeIgniter\Model;

class Admission_Model extends Model
{
    protected $table = "admissions";
    protected $primaryKey = "admission_id"; 
    protected $allowedFields = [
        'first_name', 'middle_name', 'last_name', 'nickname',
        'nationality', 'gender', 'birthday', 'age', 'class_applied', 
        'father_name', 'father_occupation', 'mother_name', 'mother_occupation', 
        'contact_number', 'email','municipality','barangay','street','picture','user_id','psa','status','reason','openingclosing_id',
    ];	
    protected $useTimestamps = false;
	
    protected $returnType = "object";


    public function getStudent($admissionId)
    {
        return $this->select("*,admission_id, CONCAT(
                                UPPER(LEFT(last_name,1)), LOWER(SUBSTRING(last_name,2)), ', ',
                                UPPER(LEFT(first_name,1)), LOWER(SUBSTRING(first_name,2)), ' ',
                                UPPER(LEFT(middle_name,1)), LOWER(SUBSTRING(middle_name,2))
                            ) AS full_name , CONCAT('Laguna ,' ,' ',municipality, ', ', barangay, ' , ', street) AS address")
                    ->where('admission_id', $admissionId)
                    ->first();
    }
    public function getStudentWithStudentInfo($admissionId)
    {
        return $this->db->table('admissions')
             ->select('admissions.*, students.*, 
                  CONCAT(
            UPPER(LEFT(admissions.last_name,1)), LOWER(SUBSTRING(admissions.last_name,2)), ", ",
            UPPER(LEFT(admissions.first_name,1)), LOWER(SUBSTRING(admissions.first_name,2)), " ",
            UPPER(LEFT(admissions.middle_name,1)), LOWER(SUBSTRING(admissions.middle_name,2))
        ) AS full_name, 
                  CONCAT_WS(" ",admissions.street, admissions.barangay, admissions.municipality," ","Laguna" ) AS address')
            ->join('students', 'students.admission_id = admissions.admission_id')
            ->where('admissions.admission_id', $admissionId)
            ->get()
            ->getRow();
    }
    public function getStudentData($userId)
    {
        return $this->select("*, admission_id,CONCAT(
                                    UPPER(LEFT(last_name,1)), LOWER(SUBSTRING(last_name,2)), ', ',
                                    UPPER(LEFT(first_name,1)), LOWER(SUBSTRING(first_name,2)), ' ',
                                    UPPER(LEFT(middle_name,1)), LOWER(SUBSTRING(middle_name,2))
                                ) AS full_name")
                    ->where('user_id', $userId)
                    ->get()
                    ->getResult(); 
    }
    public function getStudentWithStudentInfoToPayment($user_id)
    {
        return $this->db->table('admissions')
            ->select('admissions.*, 
                    CONCAT(
                        UPPER(LEFT(admissions.first_name,1)), LOWER(SUBSTRING(admissions.first_name,2)), " ",
                        UPPER(LEFT(admissions.middle_name,1)), LOWER(SUBSTRING(admissions.middle_name,2)), " ",
                        UPPER(LEFT(admissions.last_name,1)), LOWER(SUBSTRING(admissions.last_name,2))
                    ) AS full_name')
            ->where('admissions.user_id', $user_id)
            ->where('admissions.status', 'Enrolled')
            ->get()
            ->getResultArray(); 
    }
    public function getStatuses($user_id)
    {
        return $this->db->table('admissions')
            ->select('status')  // Only select the status column
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }

    public function getChildrenByGuardian($guardianId)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("a.user_id AS guardian_id, a.admission_id, CONCAT(a.first_name, ' ', a.last_name) AS full_name, s.profile_pic");
        $builder->join('guardiansaccount g', 'g.user_id = a.user_id', 'left');
        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->where('a.user_id', $guardianId);
         $builder->where('a.status', 'Enrolled');
        $query = $builder->get();
        $result = $query->getResult(); // returns array of objects
        

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }
    public function getAll($user_id)
    {
        return $this->db->table('admissions')
            ->select('*')  
            ->where('admission_id', $user_id)
            ->get()
            ->getResultArray();
    }
    public function deleteStudent($admissionId)
    {
        // Optionally check if the student exists first
        $student = $this->find($admissionId);
        if (!$student) {
            log_message('error', 'Attempted to delete non-existent student with ID: ' . $admissionId);
            return false;
        }

        // Delete student
        $deleted = $this->delete($admissionId);
        if ($deleted) {
            log_message('info', 'Deleted student with ID: ' . $admissionId);
            return true;
        } else {
            log_message('error', 'Failed to delete student with ID: ' . $admissionId);
            return false;
        }
    }
    public function getChildrenByGuardianWithRemaining($guardianId,$micellaneousFee)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("
            a.user_id AS guardian_id,
            a.admission_id,
            CONCAT(a.last_name, ' ', a.first_name) AS full_name,
            s.profile_pic,
           COALESCE(p.remaining_balance, {$micellaneousFee}) AS remaining_balance
        ");
        
        $builder->join('guardiansaccount g', 'g.user_id = a.user_id', 'left');
        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->join('payments p', "p.user_id = a.admission_id AND p.plan_id = 3", 'left');

        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');

        $query = $builder->get();
        $result = $query->getResult();

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }

        public function getChildrenByGuardianWithRemainingMisc($guardianId)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("
            a.user_id AS guardian_id,
            a.admission_id,
            CONCAT(a.first_name, ' ', a.last_name) AS full_name,
            s.profile_pic,
            COALESCE(p.remaining_balance, c.miscellaneous) AS remaining_balance
        ");

        // Latest payment record based on MAX(id)
    $builder->join("
        (SELECT user_id, remaining_balance
        FROM payments p1
        WHERE p1.payment_id = (
            SELECT MAX(p2.payment_id)
            FROM payments p2
            WHERE p2.user_id = p1.user_id
            AND p2.plan_id = 3
        )
        ) AS p",
        "p.user_id = a.admission_id",
        "left"
    );

        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->join('classes c', 'c.classname = s.class_level', 'left');

        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');

        $query = $builder->get();
        $result = $query->getResult();

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }




    //=======================================================================New Data dec 4============================================================================
    public function getStudentDataNew($userId,$openinigID)
    {
        return $this->select("*, admission_id,CONCAT(
                                    UPPER(LEFT(last_name,1)), LOWER(SUBSTRING(last_name,2)), ', ',
                                    UPPER(LEFT(first_name,1)), LOWER(SUBSTRING(first_name,2)), ' ',
                                    UPPER(LEFT(middle_name,1)), LOWER(SUBSTRING(middle_name,2))
                                ) AS full_name")
                    ->where('user_id', $userId)
                    ->where('openingclosing_id', $openinigID)
                    ->get()
                    ->getResult(); 
    }
    public function getChildrenByGuardianNew($guardianId,$openinigID)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("a.user_id AS guardian_id, a.admission_id, CONCAT(a.first_name, ' ', a.last_name) AS full_name, s.profile_pic");
        $builder->join('guardiansaccount g', 'g.user_id = a.user_id', 'left');
        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');
        $builder->where('a.openingclosing_id', $openinigID);
        $query = $builder->get();
        $result = $query->getResult(); // returns array of objects
        

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }

     public function getChildrenByGuardianWithRemainingMiscOpening($guardianId,$openinigID)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("
            a.user_id AS guardian_id,
            a.admission_id,
            CONCAT(a.first_name, ' ', a.last_name) AS full_name,
            s.profile_pic,
            COALESCE(p.remaining_balance, c.miscellaneous) AS remaining_balance
        ");

        // Latest payment record based on MAX(id)
    $builder->join("
        (SELECT user_id, remaining_balance
        FROM payments p1
        WHERE p1.payment_id = (
            SELECT MAX(p2.payment_id)
            FROM payments p2
            WHERE p2.user_id = p1.user_id
            AND p2.plan_id = 3
        )
        ) AS p",
        "p.user_id = a.admission_id",
        "left"
    );

        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->join('classes c', 'c.classname = s.class_level', 'left');

        $builder->where('a.user_id', $guardianId);
        $builder->where('a.status', 'Enrolled');
        $builder->where('a.openingclosing_id', $openinigID);

        $query = $builder->get();
        $result = $query->getResult();

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }
    public function getChildrenByGuardianopening($guardianId,$openingId)
    {
        log_message('debug', 'Fetching children for guardian ID: ' . $guardianId);

        $builder = $this->db->table('admissions a');
        $builder->select("a.user_id AS guardian_id, a.admission_id, CONCAT(a.first_name, ' ', a.last_name) AS full_name, s.profile_pic");
        $builder->join('guardiansaccount g', 'g.user_id = a.user_id', 'left');
        $builder->join('students s', 's.user_id = a.admission_id', 'left');
        $builder->where('a.user_id', $guardianId);
         $builder->where('a.status', 'Enrolled');
          $builder->where('a.openingclosing_id', $openingId);
        $query = $builder->get();
        $result = $query->getResult(); // returns array of objects
        

        log_message('debug', 'Number of children found: ' . count($result));
        log_message('debug', 'Children data: ' . print_r($result, true));

        return $result;
    }





        




    

}
