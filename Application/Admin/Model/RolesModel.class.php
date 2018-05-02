<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

use Think\Model;
class RolesModel extends Model{
    //取得所有的角色
    public function rolist(){
        $list=$this->select();
        return $list;
    }
    //取得下级的权限
    public function rol($ro_id){
        $list= $this->where('ro_id='.$ro_id)->select();
        return $list;
    }
    
    
    
    
}
