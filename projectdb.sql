--Run first time only
drop database if exists projectdb;
create database projectdb;

use projectdb;

create table `user` (
  `id` int unsigned auto_increment,
  `first_name` nvarchar(255) not null,
  `last_name` nvarchar(255) not null,
  `email` nvarchar(255) not null,
  `password` char(60) not null,
  `signup_date` datetime default current_timestamp,
  primary key(`id`)
);

create table `profile` (
  `id` int unsigned auto_increment,
  `user_id` int unsigned,
  `avatar` nvarchar(255),
  `about_me` text,
  `facebook` nvarchar(255),
  `instagram` nvarchar(255),
  `youtube` nvarchar(255),
  `location` nvarchar(255),
  primary key(`id`)
);

create table `image` (
  `id` int unsigned auto_increment primary key,
  `filename` nvarchar(255) not null,
  `filetype` nvarchar(50) not null,
  `filedata` mediumblob,
  `profile_id` int unsigned not null,
  foreign key (`profile_id`) references `profile`(`id`) on delete cascade
);

create table `post` (
  `id` int unsigned auto_increment,
  `user_id` int unsigned,
  `content` text not null,
  `date_posted` datetime default current_timestamp,
  `date_edited` datetime default current_timestamp,
  `likes` int,
  primary key(`id`)
);

create table `comment` (
  `id` int unsigned auto_increment,
  `user_id` int unsigned,
  `post_id` int unsigned,
  `content` text not null,
  `date_posted` datetime default current_timestamp,
  `date_edited` datetime default current_timestamp,
  primary key(`id`)
);

alter table `profile` add constraint `user_id_fk` foreign key(`user_id`) references `user`(`id`);

alter table `post` add constraint `user_post_id_fk` foreign key(`user_id`) references `user`(`id`);

alter table `comment` add constraint `user_comment_id_fk` foreign key(`user_id`) references `user`(`id`);

alter table `comment` add constraint `post_id_fk` foreign key(`post_id`) references `post`(`id`);


/*
insert into `user`(`first_name`,`last_name`,`email`,`password`) values
('Shawn','Myers','shawn@mail.com','password'),
('Jesse','Pinkman','Jess@mail.com','password');

insert into `profile`(`user_id`,`about_me`,`location`) values
('1', 
'I am learning computer programming, and I like to lift weights',
'New Albany'),
('2',
'I used to make meth and now I live in Alaska',
'Alaska');
*/