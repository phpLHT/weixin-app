<?php

namespace Admin\Controller;

class BuyController extends BaseController{
    //展示父级代理商的商品信息;
   public function goodslist(){
       //获取当前登录用户的id
       $userid=session('userid');
       $m=M();
       $sql="select a_goods.* from a_goods left join a_user on a_goods.user_id=a_user.pid where a_user.id=$userid";
       $data=$m->query($sql);
       $this->assign('page_title','进货');
       $this->assign('data',$data);
       $this->display();
       
   }
   //加入购物车,
   public function addcart(){
       //获取到商品的id
       $userid=session('userid');
       $id = I('post.id');
       //通过id查询出商品的信息
       $goods=M('Goods');
       $info=$goods->where('id='.$id)->find();
       
       $data['goods_id']=$id;
       $data['goods_name']=$info['name'];
       $data['goods_price']=$info['price'];
       $data['user_id']=$userid;
       
       
       //购物车中商品重复性检测;
       $cart=M('Cart');
       $end=$cart->where('status=0 and goods_id='.$id)->find();
       if(empty($end)){
           $data['goods_number']=1;
           $data['money']=$info['price']*$data['goods_number'];
       }else{
           $this->ajaxReturn('购物车中已存在,请勿重复操作');
       }
       
       $res=$cart->data($data)->add();
       
       if($res){
           $this->ajaxReturn('加入购物车成功');
       }else{
           $this->ajaxReturn('加入购物车失败');
       }  
   }
    
   //修改购买数量并生成订单
   public function cartlist(){
       $userid=session('userid');
       $cart=M('Cart');
       $data=$cart->where("status=0 and user_id=$userid")->select();
       
       $this->assign('data',$data);
       
       $this->assign('page_title','生成订单');
       $this->display();
     
   }
   
   public function changeNumber(){
       //获取商品的购物车id 和 数量;
       $number=I('post.number');
       $cart_id=I('post.id');
       $cart=M('Cart');
       $stock=M()->query("select g.stock from a_cart c left join a_goods on c.goods_id=g.id where c.cart_id=$cart_id");
       $price=$cart->getFieldByCart_id($cart_id,'goods_price');
       if($stock['0']['stock'] >= $number){
           $data['goods_number']=I('post.number');
            $data['money']=$data['goods_number']*$price;
            $res=$cart->where('cart_id='.$cart_id)->save($data);
     //       dump($price);
            if($res){
                $this->ajaxReturn('修改数量成功');
            }else{
                $this->ajaxReturn('修改数量失败');
            }
           
       }else{
           $this->ajaxReturn('购买数量大于库存,修改失败');
       }
       
   }
   
   //删除单个商品
   public function delOne(){
       //获取购物车中商品的id
       $cart_id= I('post.id');
       $cart=M('Cart');
       $data['status']=2;
       $res=$cart->where('cart_id='.$cart_id)->save($data);
       if($res){
           $this->ajaxReturn('删除商品成功');
       }else{
           $this->ajaxReturn('删除商品失败');
       }
   }
   
   //单个商品生成订单;
   
   public function addOrder(){
       $userid=session('userid');
       $cart_id=I('post.id');
       //查询出购物车中商品的信息;
       $cart=M('Cart');
       $info=$cart->find($cart_id);
       $order=M('Order');
       $order_cart = M('Order_cart');
       $order->startTrans();
       $data['user_id']=$userid;
       $data['totalmoney']=$info['money'];
       $res = $order->data($data)->add();
       if($res){
           $data['order_id']=$res;
           $data['cart_id']=$cart_id;
           $end = $order_cart->data($data)->add();
           $result=$cart->where('cart_id='.$cart_id)->save(['status'=>1]);
           if($end && $result){
               $order->commit();
               $this->ajaxReturn('生成订单成功');
           }else{
               $order->rollback();
               $this->ajaxReturn('生成订单失败');
           }
       }else{
           $order->rollback();
           $this->ajaxReturn('生成订单失败');
       }
   }
   
   public function addAll(){
       $userid=session('userid');
       $cart_id=I('post.id');
       $ids=  implode(',', $cart_id);
       //查询出购物车中商品的信息;
       $cart=M('Cart');
       $info=M()->query("select sum(money) as totalmoney from a_cart where cart_id in($ids)");
       $order=M('Order');
       $order_cart = M('Order_cart');
       $order->startTrans();
       $data['user_id']=$userid;
       $data['totalmoney']=$info['0']['totalmoney'];
       $res = $order->data($data)->add();
       if($res){
           $add=true;
           foreach($cart_id as $k=>$v){
               $data['order_id']=$res;
               $data['cart_id']=$v;
               $end = $order_cart->data($data)->add();
               $result=$cart->where('cart_id='.$v)->save(['status'=>1]);
                if($end && $result){
                    $add=true;
                }else{
                    $add=false;
                }
           }
           if($add){
               $order->commit();
               $this->success('生成订单成功',U('Order/orderlist'));
           }else{
               $order->rollback();
               $this->error('生成订单失败');
           }
           
       }else{
           $order->rollback();
           $this->error('生成订单失败');
       }
       
   }
   
   
    
    
    
}
