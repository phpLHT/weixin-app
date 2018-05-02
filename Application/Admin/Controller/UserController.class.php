<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends BaseController {
    public function edit(){
        if(IS_GET){  
            $this->assign('page_title','修改密码');
            $this->display();   
        }
        
        if(IS_POST){
            //根据用户id取出用户的密码;
            $userid=session('userid');
            $user=M('User');
            $password = $user->getFieldById("$userid",'password');
//            dump($password);
//            die;
            $rules=array(
                array('password','require','原始密码不能为空'),
                array('password','checkPwd','原始密码不正确',0,'function'),
                array('newpassword','require','新密码不能为空'),
                array('repassword','require','确认密码不能为空'),
                array('repassword','newpassword','确认密码不正确',0,'confirm'),
            );
            
            if(!$user->validate($rules)->create()){
                $this->error($user->getError());                
            }else{
                $data['password']=md5(I('post.newpassword','','trim'));
                $res=$user->where('id='.$userid)->save($data);
                if($res){
                    $this->success('修改密码成功');
                }else{
                    $this->error('修改密码失败');
                }
            } 
        }
    }
    
    //对原始秘密的验证
    protected function checkPwd($pass){
        $user=M('User');
        $password = $user->getFieldById("$userid",'password');
        if(md5($pass)==$password){
            return ture;  
        }else{
            return '原始密码不正确';
        }
 
    }
}