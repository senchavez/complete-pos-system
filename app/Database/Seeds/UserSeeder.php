<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class UserSeeder extends Seeder
{
 public function run(){ $this->db->table('users')->insert(['username'=>'admin','full_name'=>'System Administrator','password'=>password_hash('Admin123!',PASSWORD_DEFAULT),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]); }
}
