<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    //登录前判断是否登录 没有登录就跳转登录页面
    public function __construct(){
        parent::__construct();
        
        if(session('?userid')){
            $userid=  session('userid');
            
            //取得当前操作的名
//            $path= MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
            
//            echo $path;
//            die;
            $module = MODULE_NAME;   // 当前模块名  
            $controller =  CONTROLLER_NAME ; // 当前控制器名  
            $action =  ACTION_NAME; // 当前操作名  
            //取出登录用户的权限; 通过userid;
            $model = M();
            $priv = $model->query("select id from a_privilege where module='{$module}' and controller='{$controller}' and action='{$action}'");
            $priv_id=$priv[0]['id'];
           if($priv_id){
               //通过查询角色表得出角色的列表;
               $priv_list = $model->query("select a_roles.priv_id as priv_id from a_roles left join a_user on a_roles.ro_id=a_user.ro_id where a_user.id='{$userid}'");
               
               $privs = explode(',', $priv_list['0']['priv_id']);
//               var_dump($priv_id);
               
           }
           
            if(in_array($priv_id, $privs)){
                return true;
                
            }else{
                
                $this->error('非法操作,您没有权限');
            } 
        }else{
            $this->error('还没有登录请先登录',U('Admin/Login/login'),1);
            
        }
        
    }
    
    
    
}