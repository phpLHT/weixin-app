<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        $this->display();
    }
    
    public function top()
    {
            $this->display();  // 显示对应模板
    }
    public function menu()
    {
            $this->display();  // 显示对应模板
    }
    public function main()
    {
            $this->display();  // 显示对应模板
    }
}