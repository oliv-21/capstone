<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressCriteriaModel extends Model
{
    protected $table            = 'progress_criteria';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'category_id',
        'criteria'
    ];
    protected $useTimestamps    = false;
}
