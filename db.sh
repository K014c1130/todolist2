#!/bin/sh

#削除
mysql -uroot -e "drop database todolist;"

#作成
mysql -uroot -e "create database todolist character set utf8;"

#list作成
mysql -uroot todolist -e "create table list(id MEDIUMINT NOT NULL AUTO_INCREMENT
, item varchar(256), PRIMARY KEY (id))"
