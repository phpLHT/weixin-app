<?php

namespace Admin\Controller;

class OrderController extends BaseController{
    //订单列表
   
   public function orderlist(){
       $userid=session('userid');
       //根据当前用户查询出所有未完成的订单;
       $m=M();
       $sql = "select o.* ,c.goods_name,c.goods_number,c.goods_price,c.money from a_order o left join a_order_cart oc on o.order_id=oc.order_id left join a_cart c on oc.cart_id=c.cart_id where o.user_id=$userid and o.status=0";
       $data=$m->query($sql);
       $orderList=[];
       foreach($data as $k=>$v){
           $orderList[$v['order_id']]['totalmoney']=$v['totalmoney'];
           $orderList[$v['order_id']]['info'][]=$v;
           
       }
       
//       dump($orderList);
       
       $this->assign('page_title','提交订单');
       $this->assign('data',$orderList);
       $this->display();
      
   }
    //删除单个商品
   public function delOne(){
       //获取购物车中商品的id
       $order_id= I('post.id');
       $cart=M('Order');
       $data['status']=2;
       $res=$cart->where('order_id='.$order_id)->save($data);
       if($res){
           $this->ajaxReturn('删除订单成功');
       }else{
           $this->ajaxReturn('删除订单失败');
       }
   }

   //订单提交
   public function subOrder(){
//       $this->ajaxReturn(1);
       $userid=session('userid');
       $order_id=I('post.id');     
       //查询出购物车中商品的信息;
       $cart=M('Cart');
       $user=M('User');
       $order=M('Order');
       $order_cart = M('Order_cart');
       $goods=M('Goods');
      
       //获取用户的上级代理;
       $pid=$user->getFieldById($userid,'pid');
       
       $info=M()->query("select c.goods_number,g.stock,c.goods_id from a_order_cart oc left join a_cart c on oc.cart_id=c.cart_id left join a_goods g on c.goods_id=g.id where oc.order_id=$order_id");

       $order->startTrans();
       //循环取出订单中的商品
        //更改订单的状态
       $changestatus=$order->where('order_id='.$order_id)->save(['status'=>1]);
       
       if($changestatus){
           $res=true;
           foreach($info as $k=>$v){
                //改变商品库存
                $number=$v['stock']-$v['goods_number'];
                
                $changestock=$goods->where('id='.$v['goods_id'])->save(array('stock'=>$number));
//                dump($changestock);
//       die;

                //增加添加记录表
                //首先将用户购买记录写进记录表
                $exchange=M('Exchange');
                $us['user_id']=$userid;
                $us['num']=$v['goods_number'];
                $us['goods_id']=$v['goods_id'];
                $us['action']=1;
                $changeuser=$exchange->data($us)->add();
                 
                //将上级的交易记录写入记录表
                $p['user_id']=$pid;
                $p['num']=$v['goods_number'];
                $p['goods_id']=$v['goods_id'];
                $p['action']=0;
                $changep=$exchange->data($p)->add();
               
                if($changestock && $changeuser && $changep){
                    $res=true;
                }else{
                    $res=false;
                }
            }
            if($res){
                $order->commit();
                $this->ajaxReturn('订单提交成功');
            }else{
                $order->rollback();
                $this->ajaxReturn('订单提交失败');
            }
       }else{
           $order->rollback();
           $this->ajaxReturn('订单提交失败');
       }
       
       

   }
   
   //待处理的订单;
   public function todealorder(){
       $user_id=session('userid');
       $data=M()->query("select o.* ,c.goods_name,c.goods_number,c.goods_price,c.money,u.telephone,u.area,u.username from a_order o left join a_order_cart oc on o.order_id=oc.order_id left join a_cart c on oc.cart_id=c.cart_id left join a_user u on c.user_id=u.id  where o.status=1 and o.user_id in (select id from a_user where pid=$user_id)");
       
       $orderList=[];
       foreach($data as $k=>$v){
           $orderList[$v['order_id']]['totalmoney']=$v['totalmoney'];
           $orderList[$v['order_id']]['info'][]=$v;
           
       }
//       dump($orderList);
       $this->assign('page_title','待处理订单');
       $this->assign('data',$orderList);
       $this->display();
   }
   
   public function submit(){
       $order_id=I('post.id');
       $number=I('post.number','','trim');
       if(empty($number)){
           $this->ajaxReturn('运单号不能为空');
           exit();
       }else{
           $order=M('Order');
       
            $order->startTrans();
            $res=$order->where('order_id='.$order_id)->data(array('transnumber'=>$number))->add();

            $end=$order->where('order_id='.$order_id)->save(array('status'=>3));
     //       dump($end);
     //       die;
            if($res && $end){
                $order->commit();
                $this->ajaxReturn('操作成功');
            }else{
                $order->rollback();
                $this->ajaxReturn('操作失败');
            }
           
           
       }
       
   }
   
   
   public function confirm(){
       //取出当前用户的所有状态为确认的订单;
       
       $user_id=session('userid');
       $data=M()->query("select o.* ,c.goods_name,c.goods_number,c.goods_price,c.money,u.telephone,u.area,u.username from a_order o left join a_order_cart oc on o.order_id=oc.order_id left join a_cart c on oc.cart_id=c.cart_id left join a_user u on c.user_id=u.id  where o.status=1 and o.user_id =$user_id");
       $orderList=[];
       foreach($data as $k=>$v){
           $orderList[$v['order_id']]['totalmoney']=$v['totalmoney'];
           $orderList[$v['order_id']]['info'][]=$v;
           
       }
       $this->assign('page_title','待确认完成订单');
       $this->assign('data',$orderList);
       $this->display();   
   }
   
   //确认完场订单;
   public function end(){
       $order_id=I('post.id');
       $order=M('Order');
       
//        $order->startTrans();
//        $res=$order->where('order_id='.$order_id)->data(array('transnumber'=>$number))->add();

        $end=$order->where('order_id='.$order_id)->save(array('status'=>4));
 //       dump($end);
 //       die;
        if( $end){
//            $order->commit();
            $this->ajaxReturn('操作成功');
        }else{
//            $order->rollback();
            $this->ajaxReturn('操作失败');
        }
   }
}
