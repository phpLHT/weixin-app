<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model { 
     //定义验证规则; 
    public $_login_validate=array(
        array('verifycode','require','验证码不能为空',1),
        array('verifycode','verifycode','验证码错误',1,'function'),
        array('username','require','用户名不为空',1),
        array('password','require','密码不为空',1)      
    );
    //新增时进行的验证
    protected $_validate = array(
        array('role','require','身份信息不能为空',1),
        array('email','require','邮箱信息不能为空',1),
        array('email','email','请输入正确的邮箱格式',1),
        array('telephone','require','电话不能为空',1),
        array('sex','require','性别不能为空',1),
        array('area','require','地区信息不能为空',1)
    );
    public $add_validate = array(
        array('role','require','身份信息不能为空',1),
        array('email','require','邮箱信息不能为空',1),
        array('telephone','require','电话不能为空',1),
        array('sex','require','性别不能为空',1),
        array('area','require','地区信息不能为空',1),
        array('email','email','请输入正确的邮箱格式',1),
        array('email','','邮箱已被被使用',0,'unique',1),
        
        array('telephone','','电话已被注册',0,'unique',1),
        
    );
    
    
     protected function verifycode($code){
        $Verify = new \Think\Verify();
        return $Verify->check($code);
     }
     //登录方法
    public function login(){
        //先取出用户提交的用户名和密码
        $username = $this->username;
        $password = $this->password;
        //判断账号是否存在
        $user = $this->where(array(
            'username' => array('eq',$username)
        ))->find();
        if($user){
            if($user['password']==md5($password)){
                //讲权限保存至session
                //登录成功吧ID和用户名存入SESSOION
                session('userid',$user['id']);
                session('username',$user['username']);
                return TRUE;
            }else{
                $this->error = '密码错误！';
                return FALSE;
            }
        }else{
            $this->error = '用户名错误！';
            return FALSE;
        }
    }
    
    
    //取出当前管理员所拥有的前两级权限
	public function getBtns(){
	    /****************取出管理员所拥有的所有权限****************/
	    $priModel = M('Privilege');
	    $id = session('userid');  //当前管理员ID
	   
	        $sql = "SELECT * FROM a_privilege where find_in_set(id,(select priv_id from a_roles left join a_user on a_user.ro_id=a_roles.ro_id where a_user.id=$id))";
	        $priData = $this->query($sql);
	   
	    /******************从所有的权限中提取前两级权限*******************/
	    $ret = array();
//            
//            foreach($priData as $k=>$v ){
//            if($v['parent_id']==0){
//                $ret[$v['id']]=$v;   
//            }else{
//                $ret[$v['parent_id']]['children'][]=$v;
//            }
//             }
//            
            
	    foreach ($priData as $k=>$v){
	        //先提取顶级的
	        if($v['parent_id'] == 0){                 
	            //在提取这个顶级的自权限
	            foreach ($priData as $k1=>$v1){
	                if($v1['parent_id'] == $v['id']){
	                    $v['children'][] = $v1; //把二级权限放到顶级权限的children数组中
	                }
	            }
	            //把顶级权限放到另一个数组中
                    $ret[]=$v;
                }
	    }
            
//            dump($ret);
	    return $ret;
            
	}
        
//        public function agentlist(){
//            $sql = 
//            
//        }
        
    
    
}