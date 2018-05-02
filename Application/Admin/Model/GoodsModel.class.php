<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
	//设置允许字段
//	protected $insertFields = 'goods,cat_id,price,stock';
	//设置允许字段
//	protected $updateFields='goods,cat_id,price,stock';
    //设置表单数据验证规则
	protected $_validate= array(
			array('cat_id','require','产品分类不能为空！',1),
                        array('goodsname','require','商品名称不能为空！',1),
                        array('price','require','价格不能为空！',1),
                        array('stock','require','库存不能为空！',1)
		);
	
	//在数据添加到数据库之前自动调用
	/*protected function _before_insert(&$data,$option){
		//商品描述有选择性的过滤
		$data['goods_desc'] = clearXSS($_POST['goods_desc']);
		//把当前时间添加到表单中
		$data['addtime'] = time();
         * 
		//处理表单中上传的LOGO图片
		//判断用户有没有选择图片
		if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
			//上传图片
			$upload = new \Think\Upload(array(
				'maxSize'=>2*1024*1024,
				'exts' => array('jpg','gif','png','jpeg'),
				'rootPath' => './Public/Uploads/',
				'savePath' => 'Goods/', 
				));
			//上传文件
			$info = $upload->upload();
			if($info){
				//生成缩略图
				//先取出刚刚上传成功的图片的路径和名称
				$logo = $info['logo']['savepath'].$info['logo']['savename'];
				//拼出缩略图的名字
				$sm_logo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
				$mid_logo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
				//生成缩略图
				$image = new \Think\Image();
				$image->open('./Public/Uploads/'.$logo);
				$image->thumb(100,100)->save('./Public/Uploads/'.$sm_logo);
				$image->thumb(200,200)->save('./Public/Uploads/'.$mid_logo);
				//把生成的图片的路径放到表单中
				$data['logo'] = $logo;
				$data['sm_logo'] = $sm_logo;
				$data['mid_logo'] = $mid_logo;
			}else{
				//先把错误信息存到模型中，然后返回控制器
				$this->error = $upload->getError();
				return FALSE;
			}
		}
	}*/
	//在数据添加到数据库之后，$data['id']就是新添加的ID
	protected function _after_insert($data,$option){
	    /**************************** 处理商品相册 **************************************/
	    /*if(hasImage('pic'))
	    {
	        // 重新处理数组
	        $pics = array();
	        foreach ($_FILES['pic']['name'] as $k => $v)
	        {
	            if(empty($v))
	                continue;
	            $pics[] = array(
	                'name' => $v,
	                'type' => $_FILES['pic']['type'][$k],
	                'tmp_name' => $_FILES['pic']['tmp_name'][$k],
	                'error' => $_FILES['pic']['error'][$k],
	                'size' => $_FILES['pic']['size'][$k],
	            );
	        }
	        $_FILES = $pics;  // uploadOne函数中会到$_FILES数组中找图片，所以把处理好的图片信息传到这里
	        // 循环这个数组然后一个一个上传并生成缩略图
	        $gpModel = D('goods_pic');
	        foreach ($pics as $k => $v)
	        {
	            $ret = uploadOne($k, 'Goods', array(
	                array(650, 650),
	                array(330, 330),
	                array(50, 50),
	            ));
	            $gpModel->add(array(
	                'goods_id' => $data['id'],
	                'pic' => $ret['images'][0],
	                'big_pic' => $ret['images'][1],
	                'mid_pic' => $ret['images'][2],
	                'sm_pic' => $ret['images'][3],
	            ));
	        }
	    }*/
	    /***************处理商品属性****************/
	    /*$attrId = I('post.attr_id');
	    $goodsAttr = I('post.goods_attr');
	    if($goodsAttr){
	        $gaModel = M('GoodsAttr');
	        foreach($goodsAttr as $k=>$v){
    	        $gaModel->add(array(
    	            'goods_id'=>$data['id'],
    	            'attr_id'=>$attrId[$k],
    	            'attr_value'=>$v,
    	        ));
	        }
	    }*/
	    /********** 处理扩展分类 ***********/
	   /*$extCatId = I('ext_cat_id');
	   if($extCatId){
	       //生成商品分类表模型
	       $gcModel = M('Goods_cat');
	       foreach ($extCatId as $v){
	           //如果没有选择分类就跳过
	           if(empty($v))
	               continue;
    	       //插入到商品分类中
    	       $gcModel->add(array(
    	           'goods_id'=>$data['id'],
    	           'cat_id'=>$v,
    	       ));
	       }
	   }*/
	   /************ 处理会员价格 **************/
	   //$mp = I('post.member_price');
	   /*$lid = I('post.level_id');
	   $mpModel = D('member_price');
	   foreach ($mp as $k => $v)
	   {
	       $_v = (float)$v;
	       if($_v > 0)
	           $mpModel->add(array(
	               'level_id' => $lid[$k],
	               'price' => $v,
	               'goods_id' => $data['id'],
	           ));
	   }*/
	}
	//在数据修改到数据库之前自动调用
	protected function _before_update(&$data,$option){
	    /**************** 处理商品相册 ******************/
	   /* if(hasImage('pic'))
	    {
	        // 重新处理数组
	        $pics = array();
	        foreach ($_FILES['pic']['name'] as $k => $v)
	        {
	            if(empty($v))
	                continue;
	            $pics[] = array(
	                'name' => $v,
	                'type' => $_FILES['pic']['type'][$k],
	                'tmp_name' => $_FILES['pic']['tmp_name'][$k],
	                'error' => $_FILES['pic']['error'][$k],
	                'size' => $_FILES['pic']['size'][$k],
	            );
	        }
	        $_FILES = $pics;  // uploadOne函数中会到$_FILES数组中找图片，所以把处理好的图片信息传到这里
	        // 循环这个数组然后一个一个上传并生成缩略图
	        $gpModel = D('goods_pic');
	        foreach ($pics as $k => $v)
	        {
	            $ret = uploadOne($k, 'Goods', array(
	                array(650, 650),
	                array(330, 330),
	                array(50, 50),
	            ));
	            $gpModel->add(array(
	                'goods_id' => $option['where']['id'],
	                'pic' => $ret['images'][0],
	                'big_pic' => $ret['images'][1],
	                'mid_pic' => $ret['images'][2],
	                'sm_pic' => $ret['images'][3],
	            ));
	        }
	    }*/
	   /************ 修改扩展分类 ***************/
		/*$extCatId = I('ext_cat_id');
		// 生成商品分类表模型
		$gcModel = M('GoodsCat');
		// 先删除原扩展分类数据
		$gcModel->where(array(
			'goods_id' => array('eq', $option['where']['id']),
		))->delete();	
		if($extCatId)
		{
			foreach ($extCatId as $v)
			{
				// 如果没有选择分类就跳过
				if(empty($v))
					continue ;
				// 插入到商品分类表中
				$gcModel->add(array(
					'goods_id' => $option['where']['id'],
					'cat_id' => $v,
				));
			}
		}*/
	    //商品描述有选择性的过滤
	    /*$data['goods_desc'] = clearXSS($_POST['goods_desc']);
	    //把当前时间添加到表单中
	    $data['addtime'] = time();*/
	    /***处理表单中上传的LOGO图片***/
	    //判断用户有没有选择图片
	    /*if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
	        //上传图片
	        $upload = new \Think\Upload(array(
	            'maxSize'=>2*1024*1024,
	            'exts' => array('jpg','gif','png','jpeg'),
	            'rootPath' => './Public/Uploads/',
	            'savePath' => 'Goods/',
	        ));
	        //上传文件
	        $info = $upload->upload();
	        if($info){
	            /******生成缩略图******/
	            //先取出刚刚上传成功的图片的路径和名称
	            /*$logo = $info['logo']['savepath'].$info['logo']['savename'];
	            //拼出缩略图的名字
	            $sm_logo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
	            $mid_logo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
	            //生成缩略图
	            $image = new \Think\Image();
	            $image->open('./Public/Uploads/'.$logo);
	            $image->thumb(100,100)->save('./Public/Uploads/'.$sm_logo);
	            $image->thumb(200,200)->save('./Public/Uploads/'.$mid_logo);
	            //把生成的图片的路径放到表单中
	            $data['logo'] = $logo;
	            $data['sm_logo'] = $sm_logo;
	            $data['mid_logo'] = $mid_logo;*/
	            /************* 删除原图图片 **************/
	            //取出原图
	            /*$oldLogo = $this->field('sm_logo,mid_logo,logo')->find($option['where']['id']);
	            //删除原图片
	            @unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
	            @unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
	            @unlink('./Public/Uploads/'.$oldLogo['logo']);*/
	        /*}else{
	            //先把错误信息存到模型中，然后返回控制器
	            $this->error = $upload->getError();
	            return FALSE;
	        }*/
	    //}
	    /*************商品属性更新***************/
	    /*$gaModel = M('GoodsAttr');
	    //在更新之前，要删除原有商品和属性对应关系
	    $gaModel->where('goods_id='.$option['where']['id'])->delete();
	    //插入新的数据
	    $attrs = I('post.attrs');
	    $attrids=I('post.attr_ids');
	    if($attrs){
	        foreach($attrs as $k=>$v){
	            if(empty($v)) continue;
	            	
	            $gaModel->add(array(
	                'goods_id'=>$option['where']['id'],
	                'attr_id'=>$attrids[$k],
	                'attr_value'=>$v
	            ));
	        }
	    }*/
	    /******************* 处理会员价格 ************************/
	    /*$mp = I('post.member_price');
	    $lid = I('post.level_id');
	    $mpModel = D('member_price');
	    $mpModel->where(array(
	        'goods_id' => array('eq', $option['where']['id'])
	    ))->delete();
	    foreach ($mp as $k => $v)
	    {
	        $_v = (float)$v;
	        if($_v > 0)
	            $mpModel->add(array(
	                'level_id' => $lid[$k],
	                'price' => $v,
	                'goods_id' => $option['where']['id'],
	            ));
	    }*/
	
	}
	public function _before_delete($option){
	    /**********删除图片***********/
	    //取出原图
	    /*$oldLogo = $this->field('sm_logo,mid_logo,logo')->find($option['where']['id']);
	    //删除原图片
	    @unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
	    @unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
	    @unlink('./Public/Uploads/'.$oldLogo['logo']);*/
	    /****************删除商品分类表中扩展分类部分的数据******************/
	    /*$gcModel = M('Goods_cat');
	    //删除原扩展分类数据
	    $gcModel->where(
	        array('goods_id'=>array('eq',$option['where']['id']))
	        )->delete();*/
	    /*************** 删除商品属性 ******************/
	    /*$gaModel = D('goods_attr');
	    $gaModel->where('goods_id='.$option['where']['id'])->delete();
	    /*************** 删除相册 ******************/
	    /*$gpModel = D('goods_pic');
	    // 从硬盘删除图片
	    $pics = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->where('goods_id='.$option['where']['id'])->select();
	    foreach ($pics as $v)
	    {
	        deleteImage($v);
	    }
	    $gpModel->where('goods_id='.$option['where']['id'])->delete();
	        */
	}
	public function search(){
		/********** 搜索 **********/
		$sessionID = session('userid');
		$m=M();
		if($sessionID == 1){
                    
                    $sql="select a_goods.*,a_category.cat_name from a_goods left join a_category on a_goods.cat_id=a_category.id where a_goods.user_id=2 ";
                    
                }else{
                    $sql="select a_goods.*,a_category.cat_name from a_goods left join a_category on a_goods.cat_id=a_category.id where a_goods.user_id=$sessionID ";
                }
                $data=$m->query($sql);
                
//                dump($data);
                return $data;
                    
                    
                    
                    
                    

//		$role = M('User');
//		$roleIdArr = $role->field('ro_id')->where("id=$sessionID")->find();
//		$role_id = $roleIdArr['ro_id'];
//
//		$qunxian = M('Roles');
//		$qunxianArr = $qunxian->field('name')->where("ro_id='$role_id'")->find();
//		
//		$str = substr($qunxianArr['name'],0,1);
//		
//			if(is_numeric($str)){
//				$qunxian = M('goods');
//				$qunxianArrs = $qunxian->field('quanxian')->select();
//				
//				//循环取出role_name前面的数字
//				$zifuchuan = '';
//				foreach ($qunxianArrs as $k => $v) {
//
//					if($v['quanxian'] >= $str){
//
//						$zifuchuan .= $v['quanxian'].",";
//
//					}		
//				}
//				
//				$jieguo = substr($zifuchuan,0,-1);
//				$where['quanxian'] = array('in',"$jieguo");
//			}
//
//		}
		
//		//根据商品名称搜索
//		if($gn = I('get.gn'))
//			$where['goods_name'] = array('like',"%$gn%");
//		//价格搜索商品
//		$fp = I('get.fp');
//		$tp = I('get.tp');
//		if($fp && $tp)
//			$where['shop_price'] = array('between',array($fp,$tp));
//		elseif($fp)
//			$where['shop_price'] = array('egt',$fp);
//		elseif($tp)
//			$where['shop_price'] = array('elt',$tp);
//		//是否上架
//		$ios = I('get.ios');
//		if($ios == '是' || $ios == '否')
//			$where['is_on_sale'] = array('eq',$ios);
//		//分类的搜索
//		$catId = I('get.cat_id');
//		if($catId){
//		   //先取出这个分类的所有子类的ID
//		   $catModel = D('Category');
//		   $children = $catModel->getChildren($catId);
//		   //分类ID和子类ID放到一起
//		   $children[] = $catId;
//		   $children = implode(',',$children);
//		   //主分类或者扩展分类在$chidren这些分类下的商品
//		   //先从商品分类中取出扩展分类下的商品
//		   $gcModel = M('Goods_cat');
//		   $extGoodsId = $gcModel->field('GROUP_CONCAT(goods_id) gid')->where(array(
//		       'cat_id'=>array('in',$children),
//		   ))->find();
//		   if($extGoodsId['gid']){
//		       $orwhere = "OR id IN({$extGoodsId['gid']})";
//		   }else{
//		       $orwhere = '';
//		   }
//		   $where['cat_id'] = array('exp',"IN($children) $orwhere");
//		}
//		//获取总记录数
//		$count = $this->where($where)->count();
//		//生成翻页类
//		$page = new \Think\Page($count,3);
//		$page->setConfig('next','下一页');
//		$page->setConfig('prev','上一页');
//		//生成翻页字符串
//		$pageString = $page->show();
//		/*********** 取数据 ***********/
//		$data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
//		return array(
//		    'data' => $data,
//		    'page' => $pageString,
//		);
                
	}
	//获取促销的商品信息
	public function getPromoteGoods($limit = 5){
	    $today = date('Y-m-d H:i:s',time());
	    return $this->field('id,sm_logo,goods_name,promote_price')->where(array(
	        'is_on_sale'=>array('eq','是'),
	        'promote_price'=>array('neq',0),
	        'promote_start_date'=>array('elt',$today),
	        'promote_end_date'=>array('egt',$today)
	    ))->limit($limit)->select();
	}
	public function getRecGoods($type,$limit = 5){
	    return $this->field('id,sm_logo,goods_name,promote_price')->where(array(
	        'is_on_sale'=>array('eq','是'),
	        $type=>array('eq','是'),
	    ))->limit($limit)->select();
	}
	/**
	 * 计算商品的会员价格
	 *
	 * @param unknown_type $goodsId
	 */
	public function getMemberPrice($goodsId)
	{
		$memberId = session('id');
		if(!$memberId)
		{
			$sp = $this->field('shop_price')->find($goodsId);
			return $sp['shop_price'];
		}
		else 
		{
			// 计算会员级别
			$memberModel = D('member');
			$jifen = $memberModel->field('jifen')->find($memberId);
			$mlModel = D('member_level');
			$levelId = $mlModel->field('id')->where(array(
				'jifen_bottom' => array('elt', $jifen['jifen']),
				'jifen_top' => array('egt', $jifen['jifen']),
			))->find();
			// 会员价格
			$mpModel = D('member_price');
			$price = $mpModel->field('price')->where(array(
				'goods_id' => array('eq', $goodsId),
				'level_id' => array('eq',$levelId['id']),
			))->find();
			// 如果设置了级别价格就返回否则返回本店价格
			if($price['price'])
				return $price['price'];
			else 
			{
				$sp = $this->field('shop_price')->find($goodsId);
				return $sp['shop_price'];
			}
		}
	}
	 /**
	  * 取出摸个分类下销量最高的商品
	  * 
	  * @param unknown $catId
	  * @param number $limit
	  */
	public function getTopGoods($catId,$limit = 7)
	{
	    //取出这个分类下所有子分类的ID
	    $catModel = D('Admin/Category');
	    $children = $catModel->getChildren($catId);
	    $children[] = $catId;
	    //取出分类下的商品信息以及销量并排序
	    return $this->alias('a')
	    ->field("a.id,a.goods_name,a.sm_logo,a.shop_price,sum(b.goods_number) xl")
	    ->join("LEFT JOIN __ORDER_GOODS__ b ON a.id=b.goods_id
	            LEFT JOIN __ORDER__ c ON b.order_id=c.id")
	    ->where(array(
	        'a.cat_id' => array('in',$children),
	        'c.pay_status' => array('eq',1),
	    ))
	    ->order('xl DESC')
	    ->group('a.id')
	    ->limit($limit)
	    ->select();
	}
	//前台商品搜索
	public function home_search()
	{
	    /***************** 搜索 *******************/
	    $catId = I('get.cat_id');
	    $catModel = D('Admin/Category');
	    $children = $catModel->getChildren($catId);
	    $children[] = $catId;
	    $where['a.cat_id'] = array('in', $children);
	    // 价格搜索
	    $price = I('get.price');
	    if($price)
	    {
	        $price = explode('-', $price);
	        $where['a.shop_price'] = array('BETWEEN', $price);
	    }
	    // 属性值 ---> 取出满足所有属性值条件的商品ID，再根据ID搜索商品
	    // 循环提交过来的所有参数
	    $get = I('get.');
	    $gaModel = D('goods_attr');
	    $gids_attr = array(); // 满足每个属性值的商品ID
	    foreach ($get as $k => $v)
	    {
	        // 找出属性值的变量
	        if(strpos($k, 'attr_') === 0)
	        {
	            // 从名称中提取出属性ID, 因为格式为这样：/attr_2/白色_颜色
	            $_k = explode('_', $k);  // $_k[1]  :属性ID
	            // 从提取出属性值
	            $_v = explode('_', $v);  // $_v[0]  :属性值
	            // 根据属性ID和属性值查询商品ID，并拼成一个字符串，格式为：1,2,3,4,45
	            $gids = $gaModel->field('GROUP_CONCAT(goods_id) gids')->where(array(
	                'attr_id' => $_k[1],
	                'attr_value' => $_v[0],
	            ))->find();
	    
	            $_attr = explode(',', $gids['gids']);
	            // 如果这是第一个属性就先暂存起来，否则和上一个属性值的商品ID求交集
	            if(empty($gids_attr))
	                $gids_attr = $_attr;
	            else
	            {
	                // 和上次的值求交集
	                $gids_attr = array_intersect($gids_attr, $_attr);
	                // 取完交集之后如果没有满条件的就说明取不出商品
	                if(empty($gids_attr))
	                {
	                    $where['a.id'] = array('eq', 0);
	                    break ;
	                }
	            }
	        }
	    }
	    
	    // 如果还不为空说明的确有满条件的商品
	    if($gids_attr)
	        $where['a.id'] = array('in', $gids_attr);
	    /***************** 计算筛选条件 ***************************/
	    $goods_info = $this->field('MAX(shop_price) max_price,MIN(shop_price) min_price,COUNT(id) goods_count,GROUP_CONCAT(id) goods_ids')->where(array(
	        'cat_id' => array('in', $children),
	    ))->find();
	    // 当商品数量超过 这些 件时才为价格分段
	    if($goods_info['goods_count'] > 1)
	    {
	        $cha = $goods_info['max_price'] - $goods_info['min_price'];  // 最大价和最小价之间的差距
	        // 根据价格差来决定价格分几段
	        if($cha < 100)
	            $sectionCount = 1;
	        elseif ($cha < 500)
	        $sectionCount = 2;
	        elseif ($cha < 1000)
	        $sectionCount = 3;
	        elseif ($cha < 5000)
	        $sectionCount = 4;
	        elseif ($cha < 10000)
	        $sectionCount = 5;
	        else
	            $sectionCount = 6;
	        // 计算每一段的增量
	        $delta = ceil($cha / $sectionCount);
	        $price = array();  // 保存分好的段
	        $firstPrice = $goods_info['min_price'];
	        for($i=0; $i<$sectionCount; $i++)
	        {
	            $price[] = ceil($firstPrice) . '-' . ($firstPrice+$delta);
	            $firstPrice+=$delta;
	        }
	    }
	    
	    /*************************** 获取筛选属性 ******************************/
	    $gaModel = D('goods_attr');
	    $gaData = $gaModel->alias('a')
	    ->field('b.attr_name,a.attr_value,a.attr_id')
	    ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
	    ->where(array(
	        'a.goods_id' => array('in', $goods_info['goods_ids'])
	    ))
	    ->select();
	    // 把相同属性的值放到一起
	    $_gaData = array();
	    foreach ($gaData as $k => $v)
	    {
	        if(!in_array($v['attr_value'], $_gaData[$v['attr_name'].'-'.$v['attr_id']]))
	            $_gaData[$v['attr_name'].'-'.$v['attr_id']][] = $v['attr_value'];
	    }
	    /********************* 翻页 ************************/
	    // 取总记录数
	    $count = $this->alias('a')->where($where)->count();
	    // 生成翻页类对象
	    $page = new \Think\Page($count, 60);
	    // 生成翻页的字符串
	    $pageString = $page->show();
	    /******************** 排序 ***************************/
	    $orderby = 'xl';     	 // 默认的排序字段
	    $orderway = 'desc'; 	 // 默认的排序方式
	    $odby = I('get.odby');
	    dump($odby);
	    if($odby)
	    {
	        if($odby == 'price-desc')
	            $orderby = 'a.shop_price';
	        elseif ($odby == 'price-asc')
	        {
	            $orderby = 'a.shop_price';
	            $orderway = 'asc';
	        }
	        elseif ($odby == 'pl-desc')
	        $orderby = 'plcount';
	        elseif ($odby == 'time-asc')
	        $orderby = 'a.addtime';
	    }
	    /******************* 取数据 *****************/
	    $data = $this->alias('a')
	    ->field('a.id,a.goods_name,a.sm_logo,a.shop_price
		,(SELECT COUNT(b.id) FROM jxshop_comment b WHERE a.id=b.goods_id) plcount
		,(SELECT SUM(c.goods_number) FROM jxshop_order_goods c LEFT JOIN jxshop_order d ON c.order_id=d.id WHERE a.id=c.goods_id AND d.pay_status=1) xl')
			->where($where)
			->limit($page->firstRow.','.$page->listRows)
			->order("$orderby $orderway")
			->select();
	    //echo $this->getLastSql();
	   return array(
	        'data' => $data,
	        'price' => $price,
	        'gaData' => $_gaData,
	        'page' => $pageString,
	    );
	}
	 
} 











