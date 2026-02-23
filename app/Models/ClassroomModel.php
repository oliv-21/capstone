<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassroomModel extends Model
{
    protected $table = 'classroom';      
    protected $primaryKey = 'id';       
    protected $allowedFields = [
        'user_id',
        'class_level',
        'file',
        'title',
        'description',
        'openingclosing_id'
    ];

   
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

  
    

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer'  => 'User ID must be a number'
        ],
        'title' => [
            'required' => 'Title is required',
            'max_length' => 'Title cannot exceed 250 characters'
        ],
        
    ];

    public function classroomData($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    public function deleteMaterial($materialId)
    {
        // Find the material record
        $material = $this->find($materialId);

        if (!$material) {
            return false; // Material not found
        }

       
        $filePath = FCPATH . 'public/assets/uploadedfile/' . $material['file'];

        
        if (is_file($filePath)) {
            unlink($filePath);
        }

        
        return $this->delete($materialId);
    }
    //==============newly added function for filtering by opening/closing id=================
    public function classroomDataOpening($userId, $openingId)
    {
        return $this->where('user_id', $userId)
                    ->where('openingclosing_id', $openingId)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    
}
