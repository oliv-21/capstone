<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressAssessmentModel extends Model
{
    protected $table            = 'progress_assessments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'criteria_id',
        'quarter',
        'school_year',
        'assessment',
        'created_at'
    ];
    protected $useTimestamps    = false;

    public function getAllAssessments($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('quarter, criteria_id')
                    ->findAll(); // Returns array of all rows
    }
    public function saveOrUpdateAssessment($data)
    {
        $existing = $this->where([
            'user_id' => $data['user_id'],
            'criteria_id' => $data['criteria_id'],
            'quarter' => $data['quarter']
        ])->first();

        if ($existing) {
           
            return $this->update($existing[$this->primaryKey], $data);
        } else {
           
            return $this->insert($data);
        }
    }
    public function studentGrade($userId)
    {
        return $this->select('progress_assessments.*, progress_criteria.*')
                    ->join('progress_criteria', 'progress_criteria.id = progress_assessments.criteria_id')
                    ->where('progress_assessments.user_id', $userId)
                    ->findAll();
    }

    



}



