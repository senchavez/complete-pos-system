<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class CustomerSeeder extends Seeder
{
 public function run(){ $now=date('Y-m-d H:i:s');$this->db->table('customers')->insertBatch([['full_name'=>'Juan Dela Cruz','email'=>'juan@example.com','phone'=>'09171234567','created_at'=>$now,'updated_at'=>$now],['full_name'=>'Maria Santos','email'=>'maria@example.com','phone'=>'09181234567','created_at'=>$now,'updated_at'=>$now]]); }
}
