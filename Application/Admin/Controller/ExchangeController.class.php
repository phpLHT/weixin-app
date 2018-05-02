<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;


class ExchangeController extends BaseController{
    //产看交易记录
    public function lst(){
        $user_id=session('userid');
        $exchange=M('Exchange');
        $begin=I('get.time1','');
        if(!empty($begin)){
//            $map['createtime']=array('egt',I('post.time1'));
            $time1=I('get.time1');
        }else{
            
//            $map['createtime']=array('egt',date('Y-m-d H:i:s',strtotime('-1day')));
            $time1=date('Y-m-d H:i:s',strtotime('-1day'));

        }
        $end=I('get.time2','');
        if(!empty($end)){
//            $where['createtime']=array('elt',I('post.time2'));
            $time2=I('get.time2');
        }else{
             $time2=date('Y-m-d H:i:s');
//            $where['createtime']=array('elt',date('Y-m-d H:i:s'));
        }
        
        $testusername=I('get.username','');
        if(!empty($testusername)){
            $username=I('get.username');
//            dump($username);
//                die;
            $user=M('User');
            $data=$user->where('pid='.$user_id)->select();
            
            if(!empty($data)){
                $userlist=array();
                foreach($data as $k=>$v){
                    $userlist[$k]=$v['id'];
                }
                
                $userinfo=$user->where('username='.$username)->find();
                
    //            $search['user_id']=$userid;
                if(!empty($userinfo)){
                    $userid=$userinfo['id'];
                    if(in_array($userid, $userlist)){
                         $data=M()->query("select e.id,e.createtime,e.action,e.num,u.username,g.name from a_user u left join a_exchange e on u.id=e.user_id left join a_goods g on e.goods_id=g.id where e.createtime>=$time1 and e.createtime<=$time2 and e.user_id=$userid");
                    }else{
                        $this->ajaxReturn('您没有权限查看该代理商');
                        exit();
                    }
                }
             
            }else{
                $this->ajaxReturn('该代理商不存在,请输入正确的姓名');
                exit();
            }
//            $data=$exchange->field()->where($map)->where($where)->where($search)->select();
           
        }else{
//            $data=$exchange->where($map)->where($where)->select();
            $data=M()->query("select e.id,e.createtime,e.action,e.num,u.username,g.name from a_user u left join a_exchange e on u.id=e.user_id left join a_goods g on e.goods_id=g.id where e.createtime > '{$time1}' and e.createtime < '{$time2}' and u.pid=$user_id");
        }
            $this->assign('data',$data);
            $this->assign('page_title','交易记录');
            $this->display();
        
    }
    
    //查找展示自己的交易记录;
    public function ownlist(){
        $user_id=session('userid');
        $begin=I('get.time1','');
        if(!empty($begin)){
//            $map['createtime']=array('egt',I('post.time1'));
            $time1=I('get.time1');
        }else{
            
//            $map['createtime']=array('egt',date('Y-m-d H:i:s',strtotime('-1day')));
            $time1=date('Y-m-d H:i:s',strtotime('-1day'));

        }
        $end=I('get.time2','');
        if(!empty($end)){
//            $where['createtime']=array('elt',I('post.time2'));
            $time2=I('get.time2');
        }else{
             $time2=date('Y-m-d H:i:s');
//            $where['createtime']=array('elt',date('Y-m-d H:i:s'));
        }
        
//        $time1=date('Y-m-d H:i:s',strtotime('-1day'));
//        $time2=date('Y-m-d H:i:s');
        $data=M()->query("select e.id,e.createtime,e.action,e.num,u.username,g.name from a_user u left join a_exchange e on u.id=e.user_id left join a_goods g on e.goods_id=g.id where e.createtime > '{$time1}' and e.createtime < '{$time2}' and e.user_id=$user_id ");    
        $this->assign('data',$data);
        $this->assign('page_title','我的交易记录');
        $this->display();
    }
    
    
}
