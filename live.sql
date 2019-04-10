/*球队表*/
create table `live_team`(
  `id` tinyint(1) unsigned not null auto_increment,
  `name` VARCHAR (20) not null default '' comment '球队名称',
  `image` varchar (20) not null default '' comment '球队图片',
  `type` tinyint(1)  unsigned not null default 0 comment '类型:0东部球队,1西部球队',
  `create_time` int (0) unsigned not null default 0 comment '创建时间',
  `update_time` int (0) unsigned not null default 0 comment '更新时间',
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 直播表
create table `live_game`(
  `id` int(10) unsigned not null auto_increment,
  `a_id` tinyint(1) unsigned not null default 0 comment 'a球队的id',
  `b_id` tinyint(1) unsigned not null default 0 comment 'b球队的id',
  `a_score` int (10) unsigned not null default 0 comment 'a球队的比分',
  `b_score` int (10) unsigned not null default 0 comment 'b球队的比分',
  `narrator` VARCHAR (20) not null default '' comment '解说员',
  `image` varchar (20) not null default '' comment '图片直播',
  `start_time` int (0) unsigned not null default 0 comment '比赛开始时间',
  `status` tinyint(1)  unsigned not null default 0 comment '比赛状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 球员表
create table `live_palyer`(
  `id` int(10) unsigned not null auto_increment,
  `name` tinyint(1) unsigned not null default 0 comment '球员姓名',
  `image` varchar (20) not null default '' comment '球员图片',
  `age` tinyint(1) unsigned not null default 0 comment '球员年龄',
  `position` tinyint(1) unsigned not null default 0 comment '球员位置',
  `status` tinyint(1)  unsigned not null default 0 comment '球员状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 赛况表
create table `live_outs`(
  `id` int(10) unsigned not null auto_increment,
  `game_id` int(10) unsigned not null default 0 comment '直播id',
  `team_id` int(10) unsigned not null default 0 comment '球队id',
  `content` varchar (200) not null default '' comment '赛况内容',
  `image` varchar (20) not null default '' comment '赛况图片',
  `type` tinyint(1) unsigned not null default 0 comment '第几节比赛',
  `status` tinyint(1)  unsigned not null default 0 comment '球员状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 聊天室的表
create table `live_chart`(
  `id` int(10) unsigned not null auto_increment,
  `game_id` int(10) unsigned not null default 0 comment '直播id',
  `user_id` int(10) unsigned not null default 0 comment '用户id',
  `content` varchar (200) not null default '' comment '用户发送的内容',
  `image` varchar (20) not null default '' comment '用户发送的图片',
  `status` tinyint(1)  unsigned not null default 0 comment '状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 直播数据表
create tabpe `live_data`(
  `id` int (10) unsigned not null auto_increment,

);




create database live
use live;
-- 直播表
create table `live_game`(
  `id` int(10) unsigned not null auto_increment,
  `a_id` tinyint(1) unsigned not null default 0 comment 'a队的id',
  `b_id` tinyint(1) unsigned not null default 0 comment 'b队的id',
  `a_score` int (10) unsigned not null default 0 comment 'a队的比分',
  `b_score` int (10) unsigned not null default 0 comment 'b队的比分',
  `narrator` VARCHAR (20) not null default '' comment '解说员',
  `image` varchar (20) not null default '' comment '图片直播',
  `start_time` int (0) unsigned not null default 0 comment '比赛开始时间',
  `status` tinyint(1)  unsigned not null default 0 comment '比赛状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 来源
create table `live_program`(
	`id` int(1) unsigned not null auto_increment,
  `name` VARCHAR (20) not null default '' comment '来源名称',
	`image` varchar (20) not null default '' comment '来源图片',
	`create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
	primary key (`id`)
)

/*阵营表*/
create table `live_camp`(
  `id` tinyint(1) unsigned not null auto_increment,
	`program_id` tinyint(1) unsigned not null default 0 comment '来源id',
  `name` VARCHAR (20) not null default '' comment '阵营名称',
  `image` varchar (20) not null default '' comment '阵营图片',
  `type` tinyint(1)  unsigned not null default 0 comment '类型:0邪恶,1正义',
  `create_time` int (0) unsigned not null default 0 comment '创建时间',
  `update_time` int (0) unsigned not null default 0 comment '更新时间',
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;


create table `live_palyer`(
  `id` int(10) unsigned not null auto_increment,
	`master_id` int(10) UNSIGNED not null default 0 comment '主人id',
  `name` tinyint(1) unsigned not null default 0 comment '人物姓名',
  `image` varchar (20) not null default '' comment '人图头像',
  `age` tinyint(1) unsigned not null default 0 comment '人物年龄',
  `position` tinyint(1) unsigned not null default 0 comment '球员位置',
  `status` tinyint(1)  unsigned not null default 0 comment '人物状态:0.死亡1.健康2.受伤/生病3.隐藏',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;


-- 赛况表
create table `live_outs`(
  `id` int(10) unsigned not null auto_increment,
  `game_id` int(10) unsigned not null default 0 comment '直播id',
  `team_id` int(10) unsigned not null default 0 comment '阵营id',
  `content` varchar (200) not null default '' comment '赛况内容',
  `image` varchar (20) not null default '' comment '赛况图片',
  `type` tinyint(1) unsigned not null default 0 comment '第几节比赛',
  `status` tinyint(1)  unsigned not null default 0 comment '状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;

-- 聊天室的表
create table `live_chart`(
  `id` int(10) unsigned not null auto_increment,
  `game_id` int(10) unsigned not null default 0 comment '直播id',
  `user_id` int(10) unsigned not null default 0 comment '用户id',
  `content` varchar (200) not null default '' comment '用户发送的内容',
  `image` varchar (20) not null default '' comment '用户发送的图片',
  `status` tinyint(1)  unsigned not null default 0 comment '状态',
  `create_time` int (0) unsigned not null default 0,
  `update_time` int (0) unsigned not null default 0,
  primary key (`id`)
)engine=innodb auto_increment=1 default charset=utf8;