-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2021-06-03 09:57:42
-- 服务器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `idealog`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `date` varchar(12) NOT NULL COMMENT '日期',
  `content` longtext NOT NULL COMMENT '内容',
  `excerpt` longtext NOT NULL COMMENT '摘要',
  `key` varchar(255) NOT NULL COMMENT '关键字',
  `alias` varchar(255) NOT NULL COMMENT '连接别名',
  `author` int(10) NOT NULL DEFAULT 0 COMMENT '作者 默认 0 佚名, 1管理员  外键 用户id ',
  `s_id` int(10) NOT NULL DEFAULT -1 COMMENT '分类 默认 -1未分类 外键 分类id',
  `type` varchar(8) NOT NULL COMMENT '类型 默认 a 文章 p 页面',
  `eyes` int(10) NOT NULL COMMENT '阅读量',
  `goodnum` int(10) NOT NULL COMMENT '点赞数',
  `badnum` int(10) NOT NULL COMMENT '差评数',
  `saynum` int(10) NOT NULL COMMENT '评论数',
  `filenum` int(10) NOT NULL COMMENT '附件数',
  `getsite` varchar(255) NOT NULL COMMENT '来源',
  `geturl` varchar(255) NOT NULL COMMENT '来源链接',
  `show` int(1) NOT NULL COMMENT '显示 默认 1 显示，0隐藏',
  `sayok` int(1) NOT NULL COMMENT '允许评论 默认 1 允许，0不允许',
  `template` varchar(255) NOT NULL COMMENT '模板',
  `password` varchar(64) NOT NULL COMMENT '加密密码',
  `pic` varchar(255) NOT NULL COMMENT '主图',
  `tags` text NOT NULL COMMENT '标签 外键 标签id 多标签用,分割',
  `check` int(1) NOT NULL COMMENT '审核 默认 1 已审核，0 未审核 ',
  `mark` varchar(32) NOT NULL COMMENT '标记 T 置顶，ST分类置顶，Y原创，Z转载，H热门，J加精',
  `copyrights` int(1) NOT NULL COMMENT '版权 默认 1可转载，0 禁止转载'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='笔记';

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `date`, `content`, `excerpt`, `key`, `alias`, `author`, `s_id`, `type`, `eyes`, `goodnum`, `badnum`, `saynum`, `filenum`, `getsite`, `geturl`, `show`, `sayok`, `template`, `password`, `pic`, `tags`, `check`, `mark`, `copyrights`) VALUES
(1, '我的创意生活', '1609137850', '这是我的第一篇笔记，记录我的生活点滴！本站部分功能正在制作中，期待与大家一起成长', '我的第一个个人笔记', '', '', 1, -1, 'a', 0, 0, 0, 0, 0, '', '', 1, 0, '', '', '', '', 1, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `a_id` int(10) NOT NULL COMMENT '文章id 外键 文章id',
  `top_id` int(10) NOT NULL COMMENT '上级评论id',
  `t_id` int(10) NOT NULL COMMENT '定位主回复',
  `date` varchar(12) NOT NULL COMMENT '时间',
  `posterid` int(10) NOT NULL COMMENT '评论者id',
  `name` varchar(255) NOT NULL COMMENT '评论者昵称',
  `content` text NOT NULL COMMENT '评论内容',
  `mail` varchar(128) NOT NULL COMMENT '邮箱',
  `url` varchar(128) NOT NULL COMMENT '链接',
  `ip` varchar(128) NOT NULL COMMENT 'IP地址',
  `show` int(1) NOT NULL COMMENT '显示 默认 1 显示 ，0 隐藏',
  `check` int(1) NOT NULL COMMENT '审核 默认 1 已审核 ，0 未审核 默认值与系统配置有关',
  `mark` int(1) NOT NULL COMMENT '评论标签 默认 0 无标签，1 加精，2神评',
  `good` int(10) NOT NULL COMMENT '好评 ',
  `bad` int(10) NOT NULL COMMENT '差评 '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论';

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE `file` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `a_id` int(10) NOT NULL COMMENT '文章ID',
  `name` varchar(128) NOT NULL COMMENT '附件名',
  `size` varchar(32) NOT NULL COMMENT '附件大小',
  `path` varchar(255) NOT NULL COMMENT '附件地址',
  `addtime` varchar(12) NOT NULL COMMENT '上传时间',
  `type` varchar(32) NOT NULL COMMENT '附件类型',
  `width` int(10) NOT NULL COMMENT '宽度',
  `height` int(10) NOT NULL COMMENT '高度',
  `top_id` int(10) NOT NULL DEFAULT 0 COMMENT '上级id 默认0，为图片缩略图时保存原图的id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='附件';

-- --------------------------------------------------------

--
-- 表的结构 `nav`
--

CREATE TABLE `nav` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `name` varchar(64) NOT NULL COMMENT '导航名称',
  `url` varchar(128) NOT NULL COMMENT '导航连接',
  `pic` varchar(255) NOT NULL COMMENT '导航图片',
  `blank` int(1) NOT NULL COMMENT '新页面 默认 0 原标签 ，1 新页面打开',
  `show` int(1) NOT NULL COMMENT '显示 默认 1 显示 ，0 隐藏',
  `top_id` int(10) NOT NULL COMMENT '上级导航id',
  `index` int(10) NOT NULL DEFAULT 0 COMMENT '排序 默认 0',
  `change` int(1) NOT NULL COMMENT '是否可以更改 默认 1 可改 ，0 不可改',
  `type` int(1) NOT NULL COMMENT '导航类型 0,自定 1,首页 2,系统 3,后台 4,分类5,单页',
  `type_id` int(10) NOT NULL COMMENT '导航id 外键 id （4,分类5,单页）时外连id',
  `group` int(1) NOT NULL COMMENT '分组'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='导航';

--
-- 转存表中的数据 `nav`
--

INSERT INTO `nav` (`id`, `name`, `url`, `pic`, `blank`, `show`, `top_id`, `index`, `change`, `type`, `type_id`, `group`) VALUES
(1, '主页', '', '', 0, 1, 0, 1, 0, 1, 0, 0),
(2, '登录', 'login', '', 1, 0, 0, 99, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `options`
--

CREATE TABLE `options` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `key` varchar(128) NOT NULL COMMENT '键',
  `value` longtext NOT NULL COMMENT '值',
  `text` longtext NOT NULL COMMENT '说明'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='配置';

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`id`, `key`, `value`, `text`) VALUES
(1, 'sitename', '网站名称', '网站名称'),
(2, 'siteinfo', '带你享受生活。', '网站简述'),
(3, 'seo_title', '网站', 'SEO标题'),
(4, 'seo_description', '描述', '描述'),
(5, 'seo_key', '关键字', '关键字'),
(6, 'logo', 'Logo', '网站logo'),
(7, 'seo_type', '3', 'seo标题方案1、文章标题2、文章标题+sitename3、文章标题+seo_title'),
(8, 'siteurl', 'http://www.a.com/', '网站域名'),
(9, 'icp', '皖ICP备17000176号-8', '备案号'),
(10, 'footer_info', '', '底部代码'),
(11, 'header_meta', '', '头部验证'),
(12, 'template', 'ideashu', '模板'),
(13, 'admin_tem', 'admin', '后台模板'),
(14, 'admin_style', 'gray', '后台配色'),
(15, 'admin_pnum', '12', '后台列表每页显示数'),
(16, 'art_num', '12', '文章数量'),
(17, 'art_check', '1', '文章审核'),
(18, 'login_code', '1', '登录验证码'),
(19, 'time_zone', 'Asia/Shanghai', '时区'),
(20, 'aliasok', '1', '连接别名 0 未启动 ，1启动'),
(21, 'htmlok', '1', 'html后缀 0 不启动 ，1启动'),
(22, 'url_type', '3', '连接方案1、/?blog=1; 动态2、/blog/1; 目录; 3、/type/1.html; 静态...'),
(23, 'excerpt', '1', '自动摘要 0关闭 ，1开启'),
(24, 'excerpt_long', '120', '摘要字数'),
(25, 'sayok', '1', '是否开启评论0关闭 ，1开启'),
(26, 'say_time', '60', '评论时间间隔 单位s，0不限制'),
(27, 'say_code', '1', '评论验证码 0关闭 ，1开启'),
(28, 'say_check', '0', '评论审核 0不需要 ，1需要'),
(29, 'say_chinese', '0', '评论内容包含中文 0不需要 ，1需要'),
(30, 'say_gravatar', '1', '评论人头像 0不显示 ，1显示'),
(31, 'say_page', '1', '评论分页 0关闭 ，1开启'),
(32, 'say_pnum', '5', '评论每页显示数'),
(33, 'say_order', '1', '0旧评论在前 ，1新评论在前'),
(34, 'reply_code', '0', '回复验证码 0关闭 ，1开启'),
(35, 'file_maxsize', '2', '上传文件最大值，默认2M'),
(36, 'file_type', 'jpg,gif,png,jpeg,mp4,mp3,rar,zip,txt,pdf,docx,doc,xls,xlsx', '允许的文件上传类型'),
(37, 'thumbnailok', '0', '生成缩略图 0不生成 1生成'),
(38, 'thum_imgmaxw', '420', '缩略图限宽，大于该值生成缩略图'),
(39, 'thum_imgmaxh ', '480', '缩略图限高，大于该值生成缩略图'),
(40, 'userpre', 'i', '用户名自定义前缀'),
(41, 'mailhost', 'smtp.163.com', '邮件服务器 smtp.163.com   smtp.qq.com'),
(42, 'mail', 'amuke123@163.com', '账号 amuke123@ideashu.com   amuke123@163.com'),
(43, 'mailpswd', 'MFVZHJRACERFHKBV', '发送密码 PFFUGSXSOXMOYKKQ   dmpvsmoxczwbcbca'),
(44, 'mailport ', '465', '端口号 465'),
(45, 'message_appid', '1400435435', '短信appid'),
(46, 'message_appkey', 'b35f66722***', '短信appkey'),
(47, 'message_templId', '346441', '短信模板'),
(48, 'message_sign', '签名', '短信签名'),
(49, 'message_url ', 'https://yun.tim.qq.com/v5/***', '短信链接'),
(50, 'ali_appid', '', '支付宝应用APPID'),
(51, 'ali_publicKey', '', '支付宝公钥'),
(52, 'ali_privateKey', '', '支付宝私钥'),
(53, 'wx_id', '', '微信支付商户号'),
(54, 'wx_key', '', '商户支付密钥'),
(55, 'wx_appid', '', '绑定支付的APPID'),
(56, 'wx_secert', '', '公众账号secert'),
(57, 'wx_m_appid', '', 'APP appid(用于APP中支付，不使用可忽略)'),
(58, 'wx_m_secert', '', 'APP appsecret(用于APP中支付，不使用可忽略)'),
(59, 'pay_name', '', '线下汇款户名'),
(60, 'pay_bank', '', '开户行'),
(61, 'pay_id', '', '账号'),
(62, 'banner_list', 'PHP序列化数据', '轮换图数据'),
(63, 'link_list', 'PHP序列化数据', '友情链接数据'),
(64, 'plugins_list', 'PHP序列化数据', '开启的插件列表'),
(65, 'side', 'PHP序列化数据', '边栏');

-- --------------------------------------------------------

--
-- 表的结构 `sort`
--

CREATE TABLE `sort` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `name` varchar(128) NOT NULL COMMENT '分类名称',
  `alias` varchar(128) NOT NULL COMMENT '连接别名',
  `pic` varchar(255) NOT NULL COMMENT '分类图片',
  `description` text NOT NULL COMMENT '分类描述',
  `key` text NOT NULL COMMENT '分类关键字',
  `template` varchar(128) NOT NULL COMMENT '模板',
  `group` int(10) NOT NULL COMMENT '分组',
  `top_id` int(10) NOT NULL COMMENT '上级导航id',
  `index` int(10) NOT NULL DEFAULT 0 COMMENT '排序 默认 0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='分类';

-- --------------------------------------------------------

--
-- 表的结构 `tags`
--

CREATE TABLE `tags` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT '标签名称',
  `a_id` text NOT NULL COMMENT '文章id 可空 文章id 用,分隔'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='标签';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `nickname` varchar(128) NOT NULL COMMENT '昵称 ',
  `role` varchar(32) NOT NULL COMMENT '权限 ',
  `check` int(1) NOT NULL COMMENT '审核 默认 1 已审核，0 未审核',
  `photo` varchar(255) NOT NULL COMMENT '头像',
  `email` varchar(128) NOT NULL COMMENT '邮箱 ',
  `emailok` int(1) NOT NULL DEFAULT 0 COMMENT '邮箱认证 默认 0 未认证，1已认证',
  `tel` varchar(12) NOT NULL COMMENT '手机 ',
  `telok` int(1) NOT NULL DEFAULT 0 COMMENT '手机认证 默认 0 未认证，1已认证',
  `description` varchar(255) NOT NULL COMMENT '描述 ',
  `date` varchar(12) NOT NULL COMMENT '注册时间',
  `lastdate` varchar(12) NOT NULL COMMENT '最后登录时间',
  `sex` int(1) NOT NULL DEFAULT 0 COMMENT '性别 默认：0 保密，1 男，2 女',
  `birthday` varchar(12) NOT NULL COMMENT '生日',
  `diyurl` varchar(64) NOT NULL COMMENT '自定义连接',
  `order` int(10) NOT NULL COMMENT '积分',
  `state` int(1) NOT NULL DEFAULT 0 COMMENT '状态 默认 0 正常，1禁言，2封禁，3 永久封禁'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nickname`, `role`, `check`, `photo`, `email`, `emailok`, `tel`, `telok`, `description`, `date`, `lastdate`, `sex`, `birthday`, `diyurl`, `order`, `state`) VALUES
(1, 'amuke123', '$2y$10$djWbLuaPbFBVHmhg6iyW0Ob.SMLWklKtIIVfy2KtZNuKJ4cKwBUFO', 'amuke123', 'admin', 1, '', '', 0, '', 0, '愿你出走半生，归来仍是少年！', '1612235214', '', 0, '', '', 0, 0);

--
-- 转储表的索引
--

--
-- 表的索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sort`
--
ALTER TABLE `sort`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `file`
--
ALTER TABLE `file`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `nav`
--
ALTER TABLE `nav`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=66;

--
-- 使用表AUTO_INCREMENT `sort`
--
ALTER TABLE `sort`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
