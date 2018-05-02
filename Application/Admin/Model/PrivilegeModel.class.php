<?php

namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model{
    public function getpriv($moudle,$controller,$action){
        $where = array(
            
        );
        $priv_id=$this->where("module='{$module}' and controller='{$controller}' and action='{$action}'")->find();
        if($priv_id){
          return $priv_id;
        }else{
            $this->error='没有此操作';
        }
            
    }
}