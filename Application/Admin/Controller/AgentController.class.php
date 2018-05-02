<?php


namespace Admin\Controller;

class AgentController extends BaseController {
    //代理商信息列表
    public function agentlist(){
        $userid=session('userid');
        $model = M();
        $sql = "select * from a_user left join a_roles on a_user.ro_id=a_roles.ro_id where a_user.pid=$userid";
        $list = $model->query($sql);
        
        $this->assign('page_title','代理商列表');
        $this->assign('data',$list);
        $this->display();
        
    }
    
    //修改代理商信息
    public function edit(){
        if(IS_GET){
            $id = I('get.id');
            $userid=session('userid');
            //展示出代理商信息; 
            $model = M();
            $sql = "select * from a_user left join a_roles on a_user.ro_id=a_roles.ro_id where a_user.id=$id";
            $data = $model->query($sql);
            $role_id = $data[0]['ro_id'];
            //查询出用户的角色;
            $user=M('User');
            $userinfo=$user->where('id='.$userid)->find();
            
//            dump($userinfo);
            if($userinfo['ro_id'] == 4){
                $role=D('Roles');
                $rolist = $role->rolist();
            }else{
                $role=D('Roles');
                $rolist=$role->rol($role_id);

            }
            $this->assign('rolist',$rolist);
            $this->assign('page_title','修改代理商信息');
            $this->assign('list',$data);
            $this->display();
        }
        if(IS_POST){
            $user=D('User');
            if(!$user->create(I('post.'))){
                $this->error($User->getError());
            }else{
                $data['ro_id']=I('post.role');
                $data['email']=I('post.email','','trim');
                $data['telephone']=I('post.telephone','','trim');
                $data['sex']=I('post.sex','','trim');
                $data['area']=I('post.area','','trim');
//                $data['pid']
                $id=I('post.id');
               $res = $user->where('id='.$id)->save($data);
               
               if($res){
                   $this->success('修改信息成功',U('Agent/agentlist'));
               }else{
                   $this->error('修改信息失败');
               }              
            }
        }  
    }
    //添加代理商信息;
    public function agentadd(){
        if(IS_GET){
            $userid=session('userid');
            $m=M('');
            $sql="select * from a_roles where ro_pid=( select ro_id from a_user where id=$userid)";
            $info = $m->query($sql); 
//            var_dump($info);
            $this->assign('roles',$info);
            $this->assign('page_title','添加代理商');
            $this->display();  
        }
        if(IS_POST){
            $user=D("User");
            if(!$user->validate($user->add_validate)->create(I('post.'))){
                $this->error($user->getError());
            }else{
                $data['ro_id']=I('post.role');
                $data['username']=I('post.username','','trim');
                $data['password']=md5(I('post.password','','trim'));
                $data['email']=I('post.email','','trim');
                $data['telephone']=I('post.telephone','','trim');
                $data['sex']=I('post.sex','','trim');
                $data['area']=I('post.area','','trim');
                $data['pid']=session('userid');
                
                
                $res = $user->data($data)->add();
               
               if($res){
                   $this->success('添加信息成功',U('Agent/agentadd'));
               }else{
                   $this->error('修改信息失败');
               }           
            }
                       
        }
        
    }
    //删除代理商;
    public function delete(){
        $id=I('get.id');
        $m=M('User');
        $res = $m->where('id='.$id)->delete();
        if($res){
            $this->success('删除代理商成功',U('Agent/agentlist'));
        }else{
            $this->error('删除代理商失败');
        }
        
    }
    
    
}
