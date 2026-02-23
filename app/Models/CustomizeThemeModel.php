<?php
namespace App\Models;

use CodeIgniter\Model;

class CustomizeThemeModel extends Model
{
    protected $table = 'customize_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sms_enabled', 'email_enabled'];
    protected $useTimestamps = true; 


     public function getSettings()
    {
        return $this->db->table($this->table)
            ->select("sms_enabled, email_enabled")
            ->get()
            ->getRowArray(); 
    }
    public function SettingsMessage()
    {
        return $this->asArray()
                    ->select('sms_enabled, email_enabled')
                    ->first();
    }


}
