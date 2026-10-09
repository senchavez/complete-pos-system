<?php
namespace App\Controllers;
use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
class CustomersController extends BaseController
{
    private CustomerModel $model;
    public function __construct(){ $this->model=new CustomerModel(); }
    public function index(): string{return $this->render('customers/index',['title'=>'Customers','customers'=>$this->model->orderBy('id','DESC')->findAll()]);}
    public function new(): string{return $this->render('customers/form',['title'=>'Add Customer','customer'=>null,'action'=>'/customers']);}
    public function create(){if(!$this->model->insert($this->request->getPost(['full_name','email','phone'])))return redirect()->back()->withInput()->with('errors',$this->model->errors());return redirect()->to('/customers')->with('success','Customer added.');}
    public function edit($id=null): string{$c=$this->find($id);return $this->render('customers/form',['title'=>'Edit Customer','customer'=>$c,'action'=>'/customers/'.$id]);}
    public function update($id=null){$this->find($id);if(!$this->model->update($id,$this->request->getPost(['full_name','email','phone'])))return redirect()->back()->withInput()->with('errors',$this->model->errors());return redirect()->to('/customers')->with('success','Customer updated.');}
    public function delete($id=null){$this->find($id);try{$this->model->delete($id);return redirect()->to('/customers')->with('success','Customer deleted.');}catch(\Throwable $e){return redirect()->to('/customers')->with('error','Customer has sales records and cannot be deleted.');}}
    private function find($id): array{$r=$this->model->find($id);if(!$r)throw PageNotFoundException::forPageNotFound();return $r;}
}
