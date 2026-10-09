<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductModel extends Model
{
    protected $table='products'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['name','price','stock_quantity','image'];
    protected $useTimestamps=true; protected $createdField='created_at'; protected $updatedField='updated_at';
    protected $validationRules=['name'=>'required|min_length[2]|max_length[100]','price'=>'required|decimal|greater_than_equal_to[0]','stock_quantity'=>'required|integer|greater_than_equal_to[0]'];
}
