<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
class UsersController extends BaseController
{
    private UserModel $model;
    public function __construct(){ $this->model=new UserModel(); }
    public function index(): string{return $this->render('users/index',['title'=>'Staff','users'=>$this->model->orderBy('id','DESC')->findAll()]);}
    public function new(): string{return $this->render('users/form',['title'=>'Add Staff','user'=>null,'action'=>'/users']);}
    public function create(){if(!$this->validate($this->rules(false)))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());$d=$this->request->getPost(['username','full_name','password']);$a=$this->saveAvatar();if($a)$d['avatar']=$a;$this->model->insert($d);return redirect()->to('/users')->with('success','Staff account added.');}
    public function edit($id=null): string{$u=$this->find($id);return $this->render('users/form',['title'=>'Edit Staff','user'=>$u,'action'=>'/users/'.$id]);}
    public function update($id=null){$u=$this->find($id);if(!$this->validate($this->rules(true,$id)))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());$d=$this->request->getPost(['username','full_name','password']);$a=$this->saveAvatar();if($a){$d['avatar']=$a;$this->remove($u['avatar']);}$this->model->update($id,$d);return redirect()->to('/users')->with('success','Staff account updated.');}
    public function delete($id=null){$u=$this->find($id);if((int)$id===(int)session()->get('user_id'))return redirect()->back()->with('error','You cannot delete your own active account.');try{$this->model->delete($id);$this->remove($u['avatar']);return redirect()->to('/users')->with('success','Staff account deleted.');}catch(\Throwable $e){return redirect()->back()->with('error','Staff member has sales records and cannot be deleted.');}}
    private function rules(bool $edit,int|string|null $id=null): array{$unique=$edit?'is_unique[users.username,id,'.$id.']':'is_unique[users.username]';return ['username'=>'required|min_length[3]|max_length[50]|'.$unique,'full_name'=>'required|min_length[2]|max_length[100]','password'=>($edit?'permit_empty':'required').'|min_length[8]','avatar'=>'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]'];}
    private function saveAvatar(): ?string{$f=$this->request->getFile('avatar');if(!$f||!$f->isValid()||$f->hasMoved())return null;$n=$f->getRandomName();$f->move(FCPATH.'uploads/avatars',$n);return $n;}
    private function remove(?string $f): void{if($f&&is_file(FCPATH.'uploads/avatars/'.$f))unlink(FCPATH.'uploads/avatars/'.$f);}
    private function find($id): array{$r=$this->model->find($id);if(!$r)throw PageNotFoundException::forPageNotFound();return $r;}
}
