<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateSales extends Migration
{
 public function up(){ $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'product_id'=>['type'=>'INT','unsigned'=>true],'customer_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],'sold_by'=>['type'=>'INT','unsigned'=>true],'quantity'=>['type'=>'INT'],'total_price'=>['type'=>'DECIMAL','constraint'=>'10,2'],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);$this->forge->addKey('id',true);$this->forge->addForeignKey('product_id','products','id','RESTRICT','RESTRICT');$this->forge->addForeignKey('customer_id','customers','id','SET NULL','RESTRICT');$this->forge->addForeignKey('sold_by','users','id','RESTRICT','RESTRICT');$this->forge->createTable('sales'); }
 public function down(){ $this->forge->dropTable('sales'); }
}
