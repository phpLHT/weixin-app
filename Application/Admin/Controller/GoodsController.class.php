<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends BaseController {
    
	//列表页
	public function lst(){
		$model = D('Goods');
		$data = $model->search();
		
		$this->assign('data',$data);
//		$this->assign('page',$data['page']);
		//设置页面信息
		$this->assign(array(
		    'page_title'=>'商品列表',

		));
		$this->display();
	}
	//添加方法
	public function add(){
            //判断是否提交了表单
            if(IS_POST){
                $userid=session('userid');
                $user=M('User');
                $ro_id=$user->getFieldById("$userid",'ro_id');
                    //生成产品模型
                    $model = D('Goods');
                    //接收表单中的数据并根据模型中定义的规则验证表单
                    if($model->create()){
                            //插入数据库
                        $data['name']=I('post.goodsname','','trim');
                        $data['cat_id']=I('post.cat_id');
                        $data['price']=I('post.price','','trim');
                        $data['stock']=I('post.stock','','trim');
                      
                        if($ro_id==4){
                            $data['user_id']=2;
                        }else{
                            $data['user_id']=$userid;
                        }
                        $data['desc']=I('post.goods_desc');
                        $res=$model->data($data)->add();
                        if($res){
                            $this->success('添加商品成功');
                        }else{
                            $this->error('添加商品失败');
                        }

                    }else{
                        //获取失败原因
                    $error = $model->getError();
                    //打印错误信息
                    $this->error($error);

                    }
            }
		$this->assign(array(
		    'page_title'=>'添加商品',
		  
		));
		//显示表单
                $catModel = D('Category');
		$data = $catModel->getTree();
                $this->assign('catData',$data);
		$this->display();
	}
	public function edit(){
	    
	    $id = I('get.id');//获取要修改的商品ID
	    //判断是否提交了表单
	    if(IS_POST){
	        //生成产品模型
	        $model = D('Goods');

	        //接收表单中的数据并根据模型中定义的规则验证表单
	        if($model->create(I('post.'))){
	        	$id=I('post.id');
	            //插入数据库
                    $data['name']=I('post.goodsname','','trim');
                    $data['cat_id']=I('post.cat_id');
                    $data['price']=I('post.price','','trim');
                    $data['stock']=I('post.stock','','trim');
                    $data['desc']=I('post.goods_desc','','trim');
                    
                    $res=$model->where('id='.$id)->save($data);
                    if($res){
                        $this->success('修改商品成功！',U('Goods/lst'));
                    }else{
                        $this->error('修改商品失败');
                    }

	        }else{
                    //获取失败原因
                    $error = $model->getError();
                    //打印错误信息
                    $this->error($error);
                }
	        
	    }
	    //取出要修改的商品信息
	    $model = D('Goods');
	    $info = $model->find($id);
//            dump($info);
	    $this->assign('info',$info);
		// 设置页面的信息
		$this->assign(array(
	        'page_title'=>'修改商品',
	    ));
            $catModel = D('Category');
            $data = $catModel->getTree();
            $this->assign('catData',$data);
	    //显示表单
	    $this->display();
	}

	public function delete(){
	    //接受要删除的商品ID
	    $id = I('get.id');
	    $model = D('Goods');
	    if(FALSE !== $model->delete($id)){
	        $this->success('删除成功！');//不写值就返回上一页
	        exit;
	    }else{
	        $this->error('删除失败！');
	    }
	}
}
