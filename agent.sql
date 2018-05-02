-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 04 月 10 日 10:11
-- 服务器版本: 5.6.30
-- PHP 版本: 5.4.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `agent`
--

-- --------------------------------------------------------

--
-- 表的结构 `a_cart`
--

CREATE TABLE IF NOT EXISTS `a_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车自增id',
  `goods_name` varchar(25) NOT NULL COMMENT '商品名',
  `goods_number` int(11) NOT NULL COMMENT '商品数量',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0未提交,1已提交,2删除',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `goods_price` decimal(10,2) NOT NULL,
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='购物车表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `a_cart`
--

INSERT INTO `a_cart` (`cart_id`, `goods_name`, `goods_number`, `status`, `user_id`, `goods_price`, `goods_id`, `money`) VALUES
(1, '小吧', 10, '2', 4, 20.00, 0, 0.00),
(2, '小吧', 1, '1', 4, 20.00, 0, 0.00),
(3, '小吧', 1, '1', 4, 20.00, 2, 0.00),
(4, '小吧', 1, '1', 4, 20.00, 2, 0.00),
(5, '小吧', 5, '1', 4, 20.00, 2, 0.00),
(6, '小吧', 1, '1', 4, 20.00, 2, 0.00),
(7, '小吧2', 1, '1', 4, 20.00, 3, 0.00),
(8, '小吧2', 8, '1', 4, 20.00, 3, 160.00),
(9, '小吧', 1, '1', 4, 20.00, 2, 20.00),
(10, '小吧2', 1, '1', 4, 20.00, 3, 20.00),
(11, '小吧', 1, '1', 4, 20.00, 2, 20.00),
(12, '小吧2', 1, '1', 4, 20.00, 3, 20.00);

-- --------------------------------------------------------

--
-- 表的结构 `a_category`
--

CREATE TABLE IF NOT EXISTS `a_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类自增id',
  `cat_name` varchar(50) NOT NULL COMMENT '产品分类名',
  `level` char(1) NOT NULL DEFAULT '1' COMMENT '几级分类',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类id 0代表一级分类',
  `status` char(1) DEFAULT '0' COMMENT '0正常 1删除 默认正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品分类表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `a_category`
--

INSERT INTO `a_category` (`id`, `cat_name`, `level`, `parent_id`, `status`) VALUES
(2, '洗发水', '1', 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `a_exchange`
--

CREATE TABLE IF NOT EXISTS `a_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '交易记录自增id',
  `user_id` int(11) NOT NULL COMMENT '交易者的id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '交易时间',
  `action` char(1) NOT NULL DEFAULT '0' COMMENT '1买入,0卖出',
  `num` int(11) NOT NULL COMMENT '交易数量',
  `goods_id` int(11) NOT NULL COMMENT '商品的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='交易记录表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `a_exchange`
--

INSERT INTO `a_exchange` (`id`, `user_id`, `createtime`, `action`, `num`, `goods_id`) VALUES
(1, 4, '2017-04-09 19:04:22', '1', 1, 2),
(2, 2, '2017-04-09 19:04:22', '0', 1, 2),
(3, 4, '2017-04-09 19:04:22', '1', 1, 3),
(4, 2, '2017-04-09 19:04:22', '0', 1, 3),
(5, 4, '2017-04-09 19:04:43', '1', 1, 2),
(6, 2, '2017-04-09 19:04:43', '0', 1, 2),
(7, 4, '2017-04-09 19:04:43', '1', 1, 3),
(8, 2, '2017-04-09 19:04:43', '0', 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `a_goods`
--

CREATE TABLE IF NOT EXISTS `a_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类自增id',
  `name` varchar(50) NOT NULL COMMENT '产品名称',
  `cat_id` int(11) NOT NULL COMMENT '分类id',
  `price` decimal(10,2) NOT NULL COMMENT '产品价格',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存 默认为0',
  `user_id` int(11) NOT NULL COMMENT '代理商id',
  `status` char(1) DEFAULT '0' COMMENT '0正常 1删除 默认正常',
  `desc` varchar(200) DEFAULT NULL COMMENT '商品描述',
  `creattime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '商品添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品分类表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `a_goods`
--

INSERT INTO `a_goods` (`id`, `name`, `cat_id`, `price`, `stock`, `user_id`, `status`, `desc`, `creattime`) VALUES
(2, '小吧', 2, 20.00, 98, 2, '0', '额外服务二个如果', '2017-04-09 19:04:43'),
(3, '小吧2', 2, 20.00, 198, 2, '0', '仍突然', '2017-04-09 19:04:43');

-- --------------------------------------------------------

--
-- 表的结构 `a_order`
--

CREATE TABLE IF NOT EXISTS `a_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单自增id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单生成时间',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0未结算,1已结算,2删除',
  `user_id` int(11) NOT NULL,
  `totalmoney` decimal(10,2) NOT NULL COMMENT '订单总金额',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `a_order`
--

INSERT INTO `a_order` (`order_id`, `createtime`, `status`, `user_id`, `totalmoney`) VALUES
(1, '2017-04-08 06:12:08', '2', 4, 0.00),
(2, '2017-04-08 06:20:03', '2', 4, 0.00),
(3, '2017-04-08 06:21:58', '2', 4, 0.00),
(4, '2017-04-08 06:22:04', '2', 4, 0.00),
(5, '2017-04-08 06:22:07', '2', 4, 0.00),
(6, '2017-04-08 06:22:08', '2', 4, 0.00),
(7, '2017-04-08 06:22:08', '2', 4, 0.00),
(8, '2017-04-08 06:22:08', '2', 4, 0.00),
(9, '2017-04-08 06:22:15', '2', 4, 0.00),
(10, '2017-04-08 06:22:30', '2', 4, 0.00),
(11, '2017-04-08 06:22:32', '2', 4, 0.00),
(12, '2017-04-08 06:22:32', '2', 4, 0.00),
(13, '2017-04-08 06:22:33', '2', 4, 0.00),
(14, '2017-04-08 06:22:33', '0', 4, 0.00),
(15, '2017-04-08 06:24:37', '0', 4, 0.00),
(16, '2017-04-08 06:28:22', '2', 4, 0.00),
(17, '2017-04-08 06:45:23', '0', 4, 0.00),
(18, '2017-04-08 06:48:16', '0', 4, 0.00),
(19, '2017-04-08 06:58:38', '0', 4, 0.00),
(20, '2017-04-08 07:11:20', '2', 4, 0.00),
(21, '2017-04-08 07:21:56', '1', 4, 0.00),
(22, '2017-04-08 13:41:28', '0', 4, 0.00),
(23, '2017-04-09 16:45:53', '1', 4, 0.00),
(24, '2017-04-09 16:56:13', '0', 4, 40.00);

-- --------------------------------------------------------

--
-- 表的结构 `a_order_cart`
--

CREATE TABLE IF NOT EXISTS `a_order_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单购物车表自增id',
  `order_id` int(11) NOT NULL COMMENT '订单表对应的id',
  `cart_id` int(11) NOT NULL COMMENT '购物车id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单购物车表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `a_order_cart`
--

INSERT INTO `a_order_cart` (`id`, `order_id`, `cart_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 11, 2),
(12, 12, 2),
(13, 13, 2),
(14, 14, 2),
(15, 15, 2),
(16, 16, 2),
(17, 17, 3),
(18, 18, 4),
(19, 19, 5),
(20, 20, 0),
(21, 21, 6),
(22, 21, 7),
(23, 22, 8),
(24, 23, 9),
(25, 23, 10),
(26, 24, 11),
(27, 24, 12);

-- --------------------------------------------------------

--
-- 表的结构 `a_privilege`
--

CREATE TABLE IF NOT EXISTS `a_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限自增id',
  `module` varchar(50) NOT NULL COMMENT '模块名',
  `controller` varchar(50) NOT NULL COMMENT '控制器名',
  `action` varchar(50) NOT NULL COMMENT '方法名',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0正常 1删除 默认正常',
  `priv_name` varchar(10) NOT NULL COMMENT '全限名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类id  默认为0 0代表没有父类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限表' AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `a_privilege`
--

INSERT INTO `a_privilege` (`id`, `module`, `controller`, `action`, `status`, `priv_name`, `parent_id`) VALUES
(1, 'Admin', 'Index', 'index', '0', '首页', 0),
(2, 'Admin', 'Index', 'top', '0', '顶部', 4),
(3, 'Admin', 'Index', 'menu', '0', '菜单', 4),
(4, 'Admin', 'Index', 'main', '0', '首页展示', 1),
(5, 'Admin', 'Agent', '', '0', '代理商管理', 0),
(6, 'Admin', '', '', '0', '商品管理', 0),
(7, 'Admin', 'Buy', '', '0', '进货管理', 0),
(8, 'Admin', 'User', '', '0', '个人中心', 0),
(9, 'Admin', 'Agent', 'agentadd', '0', '添加代理商', 5),
(10, 'Admin', 'Agent', 'agentlist', '0', '代理商列表', 5),
(11, 'Admin', 'Agent', 'edit', '0', '修改代理商信息', 10),
(12, 'Admin', 'Agent', 'delete', '0', '删除代理商', 10),
(13, 'Admin', 'User', 'edit', '0', '修改密码', 8),
(14, 'Admin', 'Category', 'lst', '0', '产品分类', 6),
(15, 'Admin', 'Category', 'add', '0', '添加分类', 6),
(16, 'Admin', 'Category', 'edit', '0', '修改产品分类', 14),
(17, 'Admin', 'Category', 'delete', '0', '删除产品分类', 14),
(18, 'Admin', 'Goods', 'lst', '0', '商品列表', 6),
(19, 'Admin', 'Goods', 'add', '0', '添加商品', 6),
(20, 'Admin', 'Goods', 'edit', '0', '修改商品信息', 18),
(21, 'Admin', 'Goods', 'delete', '0', '删除商品', 18),
(22, 'Admin', 'Buy', 'goodslist', '0', '进货', 7),
(23, 'Admin', 'Buy', 'addcart', '0', '加入购物车', 22),
(24, 'Admin', 'Buy', 'cartlist', '0', '生成订单', 7),
(25, 'Admin', 'Buy', 'changeNumber', '0', '修改购买商品数量', 24),
(26, 'Admin', 'Buy', 'delOne', '0', '删除单个商品', 24),
(27, 'Admin', 'Buy', 'addOrder', '0', '单个商品生成订单', 24),
(28, 'Admin', 'Order', 'orderlist', '0', '提交订单', 7),
(29, 'Admin', 'Buy', 'addAll', '0', '批量生成订单', 24),
(30, 'Admin', 'Order', 'delOne', '0', '删除单个订单', 28),
(31, 'Admin', 'Order', 'subOrder', '0', '提交单个订单', 28),
(32, 'Admin', 'Exchange', 'lst', '0', '查看交易记录', 5);

-- --------------------------------------------------------

--
-- 表的结构 `a_roles`
--

CREATE TABLE IF NOT EXISTS `a_roles` (
  `ro_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色自增id',
  `name` varchar(25) NOT NULL COMMENT '角色名',
  `status` char(1) DEFAULT '0' COMMENT '0正常 1删除 默认正常',
  `priv_id` varchar(200) NOT NULL COMMENT '权限名',
  `ro_pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  PRIMARY KEY (`ro_id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `a_roles`
--

INSERT INTO `a_roles` (`ro_id`, `name`, `status`, `priv_id`, `ro_pid`) VALUES
(1, '总代理', '0', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,32', 4),
(2, '一级代理', '0', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32', 1),
(3, '二级代理', '0', '1,2,3,4,8,13,14,18,19,20,21,22,23,24,25,26,27,28,29,30,31', 2),
(4, '管理员', '0', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21', 0);

-- --------------------------------------------------------

--
-- 表的结构 `a_user`
--

CREATE TABLE IF NOT EXISTS `a_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户自增id',
  `username` varchar(25) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '代理商登录密码',
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `telephone` varchar(15) NOT NULL COMMENT '电话',
  `sex` char(1) NOT NULL DEFAULT '0' COMMENT '性别 0女,1男  默认0',
  `area` varchar(50) NOT NULL DEFAULT '0' COMMENT '代理商地区  0 总代理',
  `ro_id` int(11) NOT NULL DEFAULT '1' COMMENT '角色id  默认1 1表示总代理',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级代理id  默认0, 0表示总代理',
  `status` char(1) DEFAULT '0' COMMENT '0正常 1删除 默认正常',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '用户添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `telephone` (`telephone`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代理商信息表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `a_user`
--

INSERT INTO `a_user` (`id`, `username`, `password`, `email`, `telephone`, `sex`, `area`, `ro_id`, `pid`, `status`, `createtime`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '', '0', '0', 4, 0, '0', '2017-04-07 06:42:07'),
(2, 'abc', 'e10adc3949ba59abbe56e057f20f883e', '89@qq.com', '12345678911', '0', '上海', 1, 1, '0', '2017-04-07 06:42:07'),
(3, '战三', 'e10adc3949ba59abbe56e057f20f883e', '8@qq.com', '12345678910', '0', '上海', 1, 1, '0', '2017-04-07 06:42:07'),
(4, '李四', 'e10adc3949ba59abbe56e057f20f883e', '65@qq.com', '12345678921', '0', '深圳', 2, 2, '0', '2017-04-07 06:42:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
