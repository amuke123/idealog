-- version:IdeaLog 1.0
-- date:2021-06-24 11:17
-- prefix:

DROP TABLE IF EXISTS article;
CREATE TABLE `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `date` varchar(12) NOT NULL COMMENT '日期',
  `content` longtext NOT NULL COMMENT '内容',
  `excerpt` longtext NOT NULL COMMENT '摘要',
  `key` varchar(255) NOT NULL COMMENT '关键字',
  `alias` varchar(255) NOT NULL COMMENT '连接别名',
  `author` int(10) NOT NULL DEFAULT '0' COMMENT '作者 默认 0 佚名, 1管理员  外键 用户id ',
  `s_id` int(10) NOT NULL DEFAULT '-1' COMMENT '分类 默认 -1未分类 外键 分类id',
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
  `copyrights` int(1) NOT NULL COMMENT '版权 默认 1可转载，0 禁止转载',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='笔记';



DROP TABLE IF EXISTS comment;
CREATE TABLE `comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
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
  `bad` int(10) NOT NULL COMMENT '差评 ',
  `del` int(1) NOT NULL DEFAULT '1' COMMENT '删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论';



DROP TABLE IF EXISTS file;
CREATE TABLE `file` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `a_id` int(10) NOT NULL COMMENT '文章ID',
  `name` varchar(128) NOT NULL COMMENT '附件名',
  `size` varchar(32) NOT NULL COMMENT '附件大小',
  `path` varchar(255) NOT NULL COMMENT '附件地址',
  `addtime` varchar(12) NOT NULL COMMENT '上传时间',
  `type` varchar(32) NOT NULL COMMENT '附件类型',
  `width` int(10) NOT NULL COMMENT '宽度',
  `height` int(10) NOT NULL COMMENT '高度',
  `top_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级id 默认0，为图片缩略图时保存原图的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='附件';



DROP TABLE IF EXISTS nav;
CREATE TABLE `nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL COMMENT '导航名称',
  `url` varchar(128) NOT NULL COMMENT '导航连接',
  `pic` varchar(255) NOT NULL COMMENT '导航图片',
  `blank` int(1) NOT NULL COMMENT '新页面 默认 0 原标签 ，1 新页面打开',
  `show` int(1) NOT NULL COMMENT '显示 默认 1 显示 ，0 隐藏',
  `top_id` int(10) NOT NULL COMMENT '上级导航id',
  `index` int(10) NOT NULL DEFAULT '0' COMMENT '排序 默认 0',
  `change` int(1) NOT NULL COMMENT '是否可以更改 默认 1 可改 ，0 不可改',
  `type` int(1) NOT NULL COMMENT '导航类型 0,自定 1,首页 2,系统 3,后台 4,分类5,单页',
  `type_id` int(10) NOT NULL COMMENT '导航id 外键 id （4,分类5,单页）时外连id',
  `group` int(1) NOT NULL COMMENT '分组',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='导航';

INSERT INTO nav VALUES ('1','首页','','','0','1','0','1','0','1','0','0'),
('2','登录','login','','1','0','0','99','0','3','0','0');


DROP TABLE IF EXISTS options;
CREATE TABLE `options` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(128) NOT NULL COMMENT '键',
  `value` longtext NOT NULL COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COMMENT='配置';

INSERT INTO options VALUES ('1','sitename','创意书'),
('2','siteinfo','带你享受生活。'),
('3','seo_title','网站'),
('4','seo_description','描述'),
('5','seo_key','关键字'),
('6','logo','../content/uploadfile/logo/logo_162426476281694.jpg'),
('7','seo_type','3'),
('8','siteurl','http://www.a.com/'),
('9','icp','皖ICP备17000176号-8'),
('10','footer_info',''),
('11','header_meta',''),
('12','template','ideashu'),
('13','admin_tem','admin'),
('14','admin_style','gray'),
('15','admin_pnum','15'),
('16','art_num','12'),
('17','art_check','1'),
('18','login_code','1'),
('19','time_zone','PRC'),
('20','aliasok','1'),
('21','htmlok','1'),
('22','url_type','3'),
('23','excerpt','1'),
('24','excerpt_long','120'),
('25','sayok','1'),
('26','say_time','60'),
('27','say_code','1'),
('28','say_check','0'),
('29','say_chinese','0'),
('30','say_gravatar','1'),
('31','say_page','1'),
('32','say_pnum','5'),
('33','say_order','1'),
('34','reply_code','0'),
('35','file_maxsize','2'),
('36','file_type','jpg,gif,png,jpeg,mp4,mp3,rar,zip,txt,pdf,docx,doc,xls,xlsx'),
('37','thumbnailok','0'),
('38','thum_imgmaxw','420'),
('39','thum_imgmaxh','480'),
('40','userpre','i'),
('41','mailhost','smtp.163.com'),
('42','mail','amuke123@163.com'),
('43','mailpswd','MFVZHJRACERFHKBV'),
('44','mailport','465'),
('45','message_appid','1400435435'),
('46','message_appkey','b35f66722cb1cd648a8ce531c32f9eae'),
('47','message_templId','346441'),
('48','message_sign','创意书'),
('49','message_url','https://yun.tim.qq.com/v5/tlssmssvr/sendsms'),
('50','ali_appid','');
INSERT INTO options VALUES ('51','ali_publicKey',''),
('52','ali_privateKey',''),
('53','wx_id',''),
('54','wx_key',''),
('55','wx_appid',''),
('56','wx_secert',''),
('57','wx_m_appid',''),
('58','wx_m_secert',''),
('59','pay_name',''),
('60','pay_bank',''),
('61','pay_id',''),
('62','banner_list','a:0:{}'),
('63','link_list','a:1:{i:0;a:6:{s:4:"name";s:6:"博客";s:3:"pic";s:0:"";s:3:"url";s:21:"http://www.amuker.com";s:3:"des";s:12:"个人博客";s:4:"show";s:1:"1";s:5:"index";s:1:"1";}}'),
('64','plugins_list','PHP序列化数据'),
('65','side','PHP序列化数据');


DROP TABLE IF EXISTS sort;
CREATE TABLE `sort` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL COMMENT '分类名称',
  `alias` varchar(128) NOT NULL COMMENT '连接别名',
  `pic` varchar(255) NOT NULL COMMENT '分类图片',
  `description` text NOT NULL COMMENT '分类描述',
  `key` text NOT NULL COMMENT '分类关键字',
  `template` varchar(128) NOT NULL COMMENT '模板',
  `group` int(10) NOT NULL COMMENT '分组',
  `top_id` int(10) NOT NULL COMMENT '上级导航id',
  `index` int(10) NOT NULL DEFAULT '0' COMMENT '排序 默认 0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='分类';



DROP TABLE IF EXISTS tags;
CREATE TABLE `tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT '标签名称',
  `a_id` text NOT NULL COMMENT '文章id 可空 文章id 用,分隔',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='标签';



DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `nickname` varchar(128) NOT NULL COMMENT '昵称 ',
  `role` varchar(32) NOT NULL COMMENT '权限 ',
  `check` int(1) NOT NULL COMMENT '审核 默认 1 已审核，0 未审核',
  `photo` varchar(255) NOT NULL COMMENT '头像',
  `email` varchar(128) NOT NULL COMMENT '邮箱 ',
  `emailok` int(1) NOT NULL DEFAULT '0' COMMENT '邮箱认证 默认 0 未认证，1已认证',
  `tel` varchar(12) NOT NULL COMMENT '手机 ',
  `telok` int(1) NOT NULL DEFAULT '0' COMMENT '手机认证 默认 0 未认证，1已认证',
  `description` varchar(255) NOT NULL COMMENT '描述 ',
  `date` varchar(12) NOT NULL COMMENT '注册时间',
  `lastdate` varchar(12) NOT NULL COMMENT '最后登录时间',
  `sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别 默认：0 保密，1 男，2 女',
  `birthday` varchar(12) NOT NULL COMMENT '生日',
  `diyurl` varchar(64) NOT NULL COMMENT '自定义连接',
  `order` int(10) NOT NULL COMMENT '积分',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '状态 默认 0 正常，1禁言，2封禁，3 永久封禁',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户';

INSERT INTO user VALUES ('1','amuke123','$2y$10$djWbLuaPbFBVHmhg6iyW0Ob.SMLWklKtIIVfy2KtZNuKJ4cKwBUFO','amuke123','admin','1','','','0','','0','','','1623822719','0','','','0','0');

-- the end of backup