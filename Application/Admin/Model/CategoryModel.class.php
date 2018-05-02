<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    //允许接收的字段
    protected $insertFields = 'cat_name,parent_id';
    //设置表单数据的验证规则
    protected $_validate = array(
        array('cat_name','require','分类名称不能为空！',1),
    );
    //获取树形结构
    public function getTree(){
        $data = $this->select();
        return $this->_getTree($data);
    }
    //递归排序成树形
    private function _getTree($data,$parent_id=0,$level=0){
        static $_ret = array();
        foreach($data as $k=>$v){
            if($v['parent_id'] == $parent_id){
                $v['level'] = $level;
                $_ret[] = $v;
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_ret;
    }
    public function getChildren($catId){
        $data = $this->select();  //取出所有分类
        return $this->_getChildren($data,$catId,TRUE);        
    }
    private function _getChildren($data,$parent_id,$isClear = FALSE){
        static $_ret = array();
        if($isClear)
            $_ret=array();
        foreach($data as $k=>$v){
            if($v['parent_id'] == $parent_id){
                $_ret[] = $v['id'];
                $this->_getChildren($data,$v['id']);
            }
        }         
        return $_ret;       
    }
    protected function _before_delete($option){
        $children = $this->getChildren($option['where']['id']);
        if($children){
            $children = implode(',',$children);
            $this->execute("DELETE FROM a_category WHERE id IN($children)");
        }
    }
    //获取所有的分类信息
    public function getNavData()
    {
        $data = $this->select();
        $ret = array();
        //找出顶级分类
       foreach($data as $k=>$v)
       {
           if($v["parent_id"] == 0)
           {
               //找出二级分类
               foreach($data as $k1=>$v1)
               {
                   if($v1['parent_id'] == $v['id'])
                   {
                       //dump($v1);
                       //找出三级分类
                       foreach($data as $k2=>$v2)
                       {
                           if($v2['parent_id']==$v1['id'])
                           {
                               $v1['children'][]=$v2;
                           }
                       }
                       $v['children'][]=$v1;
                   }
               }
               $ret[]=$v;
           }
       }
       return $ret;
    }
    /***********获取推荐分类************/
    public function getRecCat(){
        //顶级楼层
        $data = $this->where(array(
            'is_rec'=>array('eq','是'),
            'parent_id'=>array('eq',0),
        ))->select();
        //循环每个楼层，取出楼层中的数据
        foreach($data as $k => $v)
        {
            //取出二级分类，并保存到顶级分类的subCat字段中
            $data[$k]['subCat'] = $this->where(array(
                'parent_id' => $v['id'],
            ))->select();
            //取出推荐的二级分类
            $data[$k]['recSubCat'] = $this->where(array(
                'parent_id' => $v['id'],
                'is_rec' => array('eq','是'),
            ))->select();
            //循环每个推荐的二级分类，取出8件商品
            foreach($data[$k]['recSubCat'] as $k1=>$v1)
            {
                $data[$k]['recSubCat'][$k1]['goods'] = $this->getGoodsByCatId($v1['id'],8);
            }
        }
        return $data;
    }  
    //获取某个分类下所有的商品
    public function getGoodsByCatId($catId,$limit)
    {
        $children = $this->getChildren($catId);
        $children[] = $catId;
        $gModel = D('Goods');
        return $gModel->field('id,goods_name,shop_price,sm_logo')->where(array(
            'is_on_sale' => array('eq','是'),
            'cat_id' =>array('in',$children),
        ))->limit($limit)->select();
    }
    /**
     * 获取当前所有上级分类的名称
     *
     * @param unknown_type $catId
     */
    public function getParentCatPath($catId)
    {
        static $ret = array();  // 保存所有的分类信息
        $info = $this->field('id,cat_name,parent_id')->find($catId);
        array_unshift($ret, $info);
        if($info['parent_id'] > 0)
            $this->getParentCatPath($info['parent_id']);
        return $ret;
    }
}












