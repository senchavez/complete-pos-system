<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model
{
    protected $table='users'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['username','full_name','password','avatar']; protected $useTimestamps=true;
    protected $beforeInsert=['hashPassword']; protected $beforeUpdate=['hashPassword'];
    protected function hashPassword(array $data): array
    {
        if (!empty($data['data']['password'])) $data['data']['password']=password_hash($data['data']['password'],PASSWORD_DEFAULT);
        else unset($data['data']['password']);
        return $data;
    }
}
