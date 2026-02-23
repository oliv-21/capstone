<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressCategoryModel extends Model
{
    protected $table            = 'progress_categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name'
    ];
    protected $useTimestamps    = false;
}
