<?php
namespace App\Controllers;
use App\Models\{SaleModel,ProductModel,CustomerModel};
class SalesController extends BaseController
{
    public function index(): string{return $this->render('sales/index',['title'=>'Sales History','sales'=>(new SaleModel())->history()]);}
    public function create()
    {
        $products=(new ProductModel())->where('stock_quantity >',0)->orderBy('name')->findAll();$customers=(new CustomerModel())->orderBy('full_name')->findAll();
        if($this->request->getMethod()==='POST'){
            $rules=['product_id'=>'required|is_natural_no_zero','customer_id'=>'permit_empty|is_natural_no_zero','quantity'=>'required|is_natural_no_zero'];
            if(!$this->validate($rules))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
            $productModel=new ProductModel();$product=$productModel->find((int)$this->request->getPost('product_id'));$qty=(int)$this->request->getPost('quantity');
            if(!$product)return redirect()->back()->withInput()->with('error','Product not found.');
            if($qty>$product['stock_quantity'])return redirect()->back()->withInput()->with('error','Only '.$product['stock_quantity'].' unit(s) are available.');
            $db=db_connect();$db->transStart();
            (new SaleModel())->insert(['product_id'=>$product['id'],'customer_id'=>$this->request->getPost('customer_id')?:null,'sold_by'=>session()->get('user_id'),'quantity'=>$qty,'total_price'=>$qty*(float)$product['price']]);
            $productModel->update($product['id'],['stock_quantity'=>$product['stock_quantity']-$qty]);$db->transComplete();
            if(!$db->transStatus())return redirect()->back()->withInput()->with('error','Sale could not be recorded.');
            return redirect()->to('/sales')->with('success','Sale recorded and inventory updated.');
        }
        return $this->render('sales/form',['title'=>'Record Sale','products'=>$products,'customers'=>$customers]);
    }
}
