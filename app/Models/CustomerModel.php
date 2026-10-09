<?php
namespace App\Models;
use CodeIgniter\Model;
class CustomerModel extends Model
{
    protected $table='customers'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['full_name','email','phone']; protected $useTimestamps=true;
    protected $validationRules=['full_name'=>'required|min_length[2]|max_length[100]','email'=>'required|valid_email|max_length[100]','phone'=>'permit_empty|max_length[20]'];
}
