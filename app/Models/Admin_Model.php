<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_Model extends Model
{
    protected $table = 'admissions';
    protected $primaryKey = 'admission_id';
    protected $allowedFields = [
        'admission_id ',
        'first_name',
        'middle_name',
        'last_name',
        'nickname',
        'nationality',
        'gender',
        'birthday',
        'age',
        'class',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'contact_number',
        'email',
        'status',
        'picture',
        'user_id',
        'psa',
        'reason',
        'openingclosing_id'
        // add other fields as per your table schema
    ];
    protected $returnType = "object";

    
    //=====================================================New Dashboard Functions=====================================================//
    public function getTotalStudentsOpining($openingId)
    {
        return $this->db->table('students')
            ->join('admissions a', 'students.admission_id = a.admission_id', 'inner')
            ->where('a.openingclosing_id', $openingId)
            ->countAllResults(); 
    }
     public function getTotalApplicantsOpening($openingId)
    {
        return $this->db->table('admissions')
        ->whereIn('status', ['Pending', 'Approved'])
        ->where('openingclosing_id', $openingId)
        ->countAllResults();

    }
     public function getActiveClassesOpening($openingId)
    {
        return $this->db->table('classes')
                        ->where('class_id', $openingId)
                        ->countAllResults();
    }
    public function getAllAdmissionsOpening($openingId)
    {
        // Subquery to get latest audit_log per admission (only 'Update Status' actions)
        $subQuery = $this->db->table('audit_log')
            ->select('audit_log.*')
            ->join('(SELECT admission_id, MAX(created_at) AS latest_audit 
                    FROM audit_log 
                    WHERE action = "Update Status"
                    GROUP BY admission_id) latest', 
                'audit_log.admission_id = latest.admission_id AND audit_log.created_at = latest.latest_audit', 
                'inner', false)
            ->getCompiledSelect();

        return $this->db->table($this->table . ' a')
            ->select("
                a.*,      
                CONCAT(a.last_name, ', ', a.first_name, ' ', 
                                IF(a.middle_name IS NOT NULL AND a.middle_name != '', LEFT(a.middle_name, 1), '')
                            , '.') AS full_name,
                a.status,
                CONCAT_WS(' ', a.municipality, a.barangay, a.street) AS address,
                al.action,
                al.description,
                al.done_by AS approve_by,
                al.status AS audit_status,
                al.created_at AS audit_created_at,
                al.updated_at AS audit_updated_at
            ")
            ->join("($subQuery) al", 'al.admission_id = a.admission_id', 'left', false)
            ->where('a.admission_id IS NOT NULL')
            ->where('a.openingclosing_id', $openingId)
            ->groupStart()
                ->where('a.status !=', 'Enrolled')
                ->where('a.status !=', 'Disapproved')
                ->where('a.status !=', 'Interview Failed')
            ->groupEnd()
            ->get()
            ->getResult();
    }
    public function alldisapprovedOpening($openingId)
    { 
        return $this->db->table($this->table)
            ->select("*, CONCAT_WS(' ', last_name, first_name, middle_name) AS full_name, status,CONCAT_WS(' ', municipality, barangay, street) AS address")
            ->where('admission_id IS NOT NULL')
            ->where('openingclosing_id', $openingId)
            ->groupStart()
                ->where('status', 'Disapproved')
                ->orWhere('status', 'Interview Failed')
            ->groupEnd()
            ->get()
            ->getResult();
    }
    public function getEnrolledStudentsWithAdmissionOpening($openingId)
    {
        $builder = $this->db->table('students s');
        $builder->select("
            s.*,
            ad.*,
            ad.nickname,
            ad.middle_name,
            ad.nationality,
            ad.gender,
            ad.birthday as admission_birthday,
            ad.age,
            ad.father_name,
            ad.father_occupation,
            ad.mother_name,
            ad.mother_occupation,
            ad.contact_number,
            ad.email,
            ad.picture,
            en.openingclosing_id,
            ad.municipality,
            ad.barangay,
            ad.street,
             CONCAT(ad.municipality, ' ', ad.barangay, ' ', ad.street) AS address,
            
            
           CONCAT(
                s.last_name, ', ',
                s.first_name,
                IF(s.middle_name IS NOT NULL AND s.middle_name != '', 
                    CONCAT(' ', LEFT(s.middle_name, 1), '.'),
                    ''
                )
            ) AS full_name
        ");
        $builder->where('ad.openingclosing_id', $openingId);
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');
        $builder->join('enrollment en', 'en.student_id = s.user_id');
        return $builder->get()->getResult(); 

    }
    public function generateReportOpening($openingId)
    {
        return $this->db->table('admissions a')
            ->select("
                CONCAT(a.first_name, ' ', a.last_name) AS student_name,
                a.admission_id,
                a.user_id AS admission_user_id,
                a.status,
                g.user_id AS guardian_user_id,
                CONCAT(g.first_name, ' ', g.last_name) AS guardian_name,
                g.contact_number,
                g.email,
                CONCAT(g.municipality, ', ', g.barangay, ', ', g.street) AS address,
                p.payment_id,
                p.amount_paid,
                p.remaining_balance,
                p.payment_method,
                p.payment_date,
                p.plan_id,
                p.status
            ")
            ->join('payments p', 'a.admission_id = p.user_id', 'inner')
            ->join('guardiansAccount g', 'g.user_id = a.user_id', 'inner')
             ->where('a.openingclosing_id', $openingId)
            ->where('a.status', 'Enrolled')
            ->get()
            ->getResultArray(); // return as array for view
    }
    

    //======================================================================================================================================//


    public function getTotalStudents()
    {
        return $this->db->table('students')->countAllResults(); 
    }
    
    public function getTotalApplicants()
    {
        return $this->db->table('admissions')
        ->whereIn('status', ['Pending', 'Approved'])
        ->countAllResults();

    }

    public function getActiveClasses()
    {
        return $this->db->table('classes')->countAllResults(); // adjust condition
    }

    // public function getRecentActivities()
    // {
    //     return $this->db->table('activities')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray(); // adjust table
    // }
    public function getAllAdmissions()
    {
        // Subquery to get latest audit_log per admission (only 'Update Status' actions)
        $subQuery = $this->db->table('audit_log')
            ->select('audit_log.*')
            ->join('(SELECT admission_id, MAX(created_at) AS latest_audit 
                    FROM audit_log 
                    WHERE action = "Update Status"
                    GROUP BY admission_id) latest', 
                'audit_log.admission_id = latest.admission_id AND audit_log.created_at = latest.latest_audit', 
                'inner', false)
            ->getCompiledSelect();

        return $this->db->table($this->table . ' a')
            ->select("
                a.*,      
                CONCAT(a.last_name, ', ', a.first_name, ' ', 
                                IF(a.middle_name IS NOT NULL AND a.middle_name != '', LEFT(a.middle_name, 1), '')
                            , '.') AS full_name,
                a.status,
                CONCAT_WS(' ', a.municipality, a.barangay, a.street) AS address,
                al.action,
                al.description,
                al.done_by AS approve_by,
                al.status AS audit_status,
                al.created_at AS audit_created_at,
                al.updated_at AS audit_updated_at
            ")
            ->join("($subQuery) al", 'al.admission_id = a.admission_id', 'left', false)
            ->where('a.admission_id IS NOT NULL')
            ->groupStart()
                ->where('a.status !=', 'Enrolled')
                ->where('a.status !=', 'Disapproved')
                ->where('a.status !=', 'Interview Failed')
            ->groupEnd()
            ->get()
            ->getResult();
    }


    public function getEnrolledStudentsWithAdmission()
    {
        $builder = $this->db->table('students s');
        $builder->select("
            s.*,
            ad.*,
            ad.nickname,
            ad.middle_name,
            ad.nationality,
            ad.gender,
            ad.birthday as admission_birthday,
            ad.age,
            ad.father_name,
            ad.father_occupation,
            ad.mother_name,
            ad.mother_occupation,
            ad.contact_number,
            ad.email,
            ad.picture,
            en.openingclosing_id,
            ad.municipality,
            ad.barangay,
            ad.street,
             CONCAT(ad.municipality, ' ', ad.barangay, ' ', ad.street) AS address,
            
            
           CONCAT(
                s.last_name, ', ',
                s.first_name,
                IF(s.middle_name IS NOT NULL AND s.middle_name != '', 
                    CONCAT(' ', LEFT(s.middle_name, 1), '.'),
                    ''
                )
            ) AS full_name
        ");
        $builder->join('admissions ad', 'ad.admission_id = s.admission_id');
        $builder->join('enrollment en', 'en.student_id = s.user_id');
        return $builder->get()->getResult(); 

    }
    
    


    public function alldisapproved()
    { 
        return $this->db->table($this->table)
            ->select("*, CONCAT_WS(' ', last_name, first_name, middle_name) AS full_name, status,CONCAT_WS(' ', municipality, barangay, street) AS address")
            ->where('admission_id IS NOT NULL')
            ->groupStart()
                ->where('status', 'Disapproved')
                ->orWhere('status', 'Interview Failed')
            ->groupEnd()
            ->get()
            ->getResult();
    }

    public function recentactivity()
    {
        $sql = "
            SELECT 
                'New student enrolled' AS activity_type,
                CONCAT('New student enrolled: ', first_name) AS activity_text,
                submitted_at AS date
            FROM admissions

            UNION ALL

            SELECT 
                'Attendance update' AS activity_type,
                CONCAT('Attendance recorded for nickname ', students.last_name) AS activity_text,
                date
            FROM attendance
            JOIN students ON students.user_id = attendance.user_id

            UNION ALL

            SELECT 
                'Payment made' AS activity_type,
                CONCAT('Payment   Php ', amount_paid) AS activity_text,
                payment_date AS date
            FROM payments

            ORDER BY date DESC
            LIMIT 20
        ";

        $query = $this->db->query($sql);
        return $query->getResult();
        }

    public function getAllUsers()
{
    $sql = "
        SELECT 
             CONCAT(
            UPPER(LEFT(g.last_name,1)), LOWER(SUBSTRING(g.last_name,2)), ', ',
            UPPER(LEFT(g.first_name,1)), LOWER(SUBSTRING(g.first_name,2)), ' ',
            IF(g.middle_name IS NOT NULL AND g.middle_name != '',
                CONCAT(UPPER(LEFT(g.middle_name,1)), '.'),
                ''
            )
        ) AS Name,
            'Guardian' AS Role,
            g.email AS Email,
            g.user_id,
            g.id AS admission_id,
            NULL AS birthday,
            NULL AS gender,
            NULL AS civil_status,
            g.municipality,
            g.barangay,
            g.street,
            g.contact_number,
            g.relationship AS specialization,
            NULL AS teacher_department,
            g.profile_pic
        FROM guardiansAccount g

        UNION

        SELECT 
            CONCAT(
                t.last_name, ', ', 
                t.first_name, ' ', 
                IF(t.middle_name IS NOT NULL AND t.middle_name != '', LEFT(t.middle_name, 1), '')
            , '.') AS Name,
            u.role AS Role,
            t.email AS Email,
            t.user_id,
            t.id AS admission_id,
            t.birthday,
            t.gender,
            t.civil_status,
            t.municipality,
            t.barangay,
            t.street,
            t.contact_number,
            t.specialization,
            t.teacher_department,
            t.profile_pic
        FROM teachers t
        INNER JOIN users u ON u.id = t.user_id
    ";

    return $this->db->query($sql)->getResult();
}

    public function getGuardianWithUserId($userId)
    {
        $builder = $this->db->table('guardiansAccount g');
        $builder->select("
            g.*,
            CONCAT(g.municipality, ' ', g.barangay, ' ', g.street) AS address,
            CONCAT(g.last_name, ' ', g.first_name, ' ', COALESCE(g.middle_name, '')) AS full_name
        ");
        
        // Apply filter
        $builder->where('g.user_id', $userId);

        return $builder->get()->getResult();
    }

    
    public function getTeacher($userId)
    {
        $builder = $this->db->table('teachers t');
        $builder->select("
            t.*,
            CONCAT(t.last_name, ' ', t.first_name, ' ', COALESCE(t.middle_name, '')) AS full_name
        ");
        $builder->where('t.user_id', $userId);

        return $builder->get()->getResult();
    }
    public function generateReport()
    {
        return $this->db->table('admissions a')
            ->select("
                CONCAT(a.first_name, ' ', a.last_name) AS student_name,
                a.admission_id,
                a.user_id AS admission_user_id,
                a.status,
                g.user_id AS guardian_user_id,
                CONCAT(g.first_name, ' ', g.last_name) AS guardian_name,
                g.contact_number,
                g.email,
                CONCAT(g.municipality, ', ', g.barangay, ', ', g.street) AS address,
                p.payment_id,
                p.amount_paid,
                p.remaining_balance,
                p.payment_method,
                p.payment_date,
                p.plan_id,
                p.status
            ")
            ->join('payments p', 'a.admission_id = p.user_id', 'inner')
            ->join('guardiansAccount g', 'g.user_id = a.user_id', 'inner')
            ->where('a.status', 'Enrolled')
            ->get()
            ->getResultArray(); // return as array for view
    }








        
}
