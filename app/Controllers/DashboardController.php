<?php
namespace App\Controllers;
use App\Models\{ProductModel,CustomerModel,UserModel,SaleModel};
class DashboardController extends BaseController
{
    public function index(): string
    {
        $sale=new SaleModel(); $today=$sale->where('DATE(created_at)',date('Y-m-d'))->selectSum('total_price')->first();
        return $this->render('dashboard',['title'=>'Dashboard','productCount'=>(new ProductModel())->countAll(),'customerCount'=>(new CustomerModel())->countAll(),'staffCount'=>(new UserModel())->countAll(),'salesCount'=>$sale->countAll(),'todaySales'=>(float)($today['total_price']??0)]);
    }
}
