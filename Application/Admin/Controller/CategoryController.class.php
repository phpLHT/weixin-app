<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends BaseController {
	//列表页
	public function lst(){
		$model = D('Category');
		$data = $model->getTree();
		$this->assign('data',$data);
		//设置页面信息
		$this->assign(array(
		    'page_title'=>'分类列表',
		));
		$this->display();
	}
	//添加方法
	public function add(){
		//判断是否提交了表单
		if(IS_POST){
			//生成产品模型
			$model = D('Category');
			//接收表单中的数据并根据模型中定义的规则验证表单
			if($model->create(I('post.'),1)){
				//插入数据库
				if($model->add()){
					//提示成功，并在1秒后跳转
					$this->success('添加分类成功！',U('lst'));
					exit;
				}
			}
			//获取失败原因
			$error = $model->getError();
			//打印错误信息
			$this->error($error);
		}
		//取出所有分类
		$catModel = D('Category');
		$data = $catModel->getTree();
		//设置页面信息
		$this->assign(array(
		    'data' => $data,
		    'page_title'=>'添加分类',
		 
		));
		//显示表单
		$this->display();
	}
	public function edit(){
	    $id = I('get.id');//获取要修改的商品ID
	    //判断是否提交了表单
	    if(IS_POST){
	        //生成产品模型
	        $model = D('Category');
	        //接收表单中的数据并根据模型中定义的规则验证表单
	        if($model->create(I('post.'),2)){
	            //插入数据库
	            if($FALSE !== $model->save()){
	                //提示成功，并在1秒后跳转
	                $this->success('修改分类成功！',U('lst'));
	                exit;
	            }
	        }
	        //获取失败原因
	        $error = $model->getError();
	        //打印错误信息
	        $this->error($error);
	    }
	    //取出要修改的分类信息
	    $model = D('Category');
	    $info = $model->find($id);
	    //取出所有的分类
	    $data = $model->getTree();
	    //取出当前分类的所有子分类的ID，在表单中不显示这些分类
	    $children = $model->getChildren($id);
	    $this->assign('children',$children);
	    $this->assign('info',$info);
	    $this->assign('data',$data);
	    //设置页面信息
	    $this->assign(array(
	        'page_title'=>'修改分类',
	        
	    ));
	    //显示表单
	    $this->display();
	}
	public function delete(){
	    //接受要删除的商品ID
	    $id = I('get.id');
	    $model = D('Category');
	    if(FALSE !== $model->delete($id)){
	        $this->success('删除成功！');//不写值就返回上一页
	        exit;
	    }else{
	        $this->error('删除失败！');
	    }
	}
}
