<?php
namespace App\Controllers;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
class ProductsController extends BaseController
{
    private ProductModel $model;
    public function __construct(){ $this->model=new ProductModel(); }
    public function index(): string { return $this->render('products/index',['title'=>'Products','products'=>$this->model->orderBy('id','DESC')->findAll()]); }
    public function new(): string { return $this->render('products/form',['title'=>'Add Product','product'=>null,'action'=>'/products']); }
    public function create()
    {
        if (!$this->validate($this->rules())) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        $data=$this->request->getPost(['name','price','stock_quantity']); $image=$this->saveImage(); if ($image) $data['image']=$image;
        if (!$this->model->insert($data)) return redirect()->back()->withInput()->with('errors',$this->model->errors());
        return redirect()->to('/products')->with('success','Product added.');
    }
    public function edit($id=null): string { $p=$this->find($id); return $this->render('products/form',['title'=>'Edit Product','product'=>$p,'action'=>'/products/'.$id]); }
    public function update($id=null)
    {
        $p=$this->find($id); if (!$this->validate($this->rules())) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        $data=$this->request->getPost(['name','price','stock_quantity']); $image=$this->saveImage(); if($image){$data['image']=$image;$this->removeFile('products',$p['image']);}
        $this->model->update($id,$data); return redirect()->to('/products')->with('success','Product updated.');
    }
    public function delete($id=null)
    {
        $p=$this->find($id); try{$this->model->delete($id);$this->removeFile('products',$p['image']);return redirect()->to('/products')->with('success','Product deleted.');}
        catch(\Throwable $e){return redirect()->to('/products')->with('error','This product has sales records and cannot be deleted.');}
    }
    private function find($id): array { $row=$this->model->find($id); if(!$row)throw PageNotFoundException::forPageNotFound(); return $row; }
    private function rules(): array { return ['name'=>'required|min_length[2]|max_length[100]','price'=>'required|decimal|greater_than_equal_to[0]','stock_quantity'=>'required|integer|greater_than_equal_to[0]','image'=>'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]']; }
    private function saveImage(): ?string { $f=$this->request->getFile('image'); if(!$f||!$f->isValid()||$f->hasMoved())return null;$name=$f->getRandomName();$f->move(FCPATH.'uploads/products',$name);return $name; }
    private function removeFile(string $dir,?string $file): void { if($file&&is_file(FCPATH.'uploads/'.$dir.'/'.$file))unlink(FCPATH.'uploads/'.$dir.'/'.$file); }
}
