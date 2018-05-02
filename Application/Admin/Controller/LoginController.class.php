<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    
    //验证码设置;
    public function verifycode(){
        $config=array(
            'fontSize'=>    17,    // 验证码字体大小    
            'length'      =>    4,     // 验证码位数    
            'useNoise'    =>    false, // 关闭验证码杂点
        );
        
        $verify=new \Think\Verify($config);
        $verify->entry();
        
    }
    
    //登录
    public function login(){
        if(IS_GET){
            $this->display();
        }
        if(IS_POST){
           
//           dump($data);
//           die;
            $model = D('User');
           //使用我们定义的规则来验证登录
           if($model->validate($model->_login_validate)->create(I('post.'))){
               if($model->login()){                                     
                   $this->success('登陆成功！',U('Admin/Index/index'));
                   exit;
               }
           }
           $this->error($model->geterror());
          
        }
        
    }
    
    public function logout(){
        session(null);
        session('destroy');
        
        $this->success('退出成功',U('Login/login'));
        
        
    }
    
    
}