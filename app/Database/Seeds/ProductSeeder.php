<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class ProductSeeder extends Seeder
{
 public function run(){ $now=date('Y-m-d H:i:s');$this->db->table('products')->insertBatch([['name'=>'Wireless Mouse','price'=>599.00,'stock_quantity'=>25,'created_at'=>$now,'updated_at'=>$now],['name'=>'Mechanical Keyboard','price'=>1899.00,'stock_quantity'=>15,'created_at'=>$now,'updated_at'=>$now],['name'=>'USB-C Cable','price'=>299.00,'stock_quantity'=>40,'created_at'=>$now,'updated_at'=>$now]]); }
}
