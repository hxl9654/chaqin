<!--
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Xianglong He
 * @copyright  Copyright (c) 2015 Xianglong He. (http://tec.hxlxz.com)
 * @license    http://www.gnu.org/licenses/     GPL v3
 * @version    1.0
 * @discribe   查寝系统管理-查寝开始
-->
<?php
//判断是否有真正进行的查寝（data数据库是否存在），如果有：报错，返回
$result = mysql_query("select * from data limit 1");
    if(mysql_fetch_array($result) != "")
    {
        mysql_close($con);
        exit( "
         <script language=javascript>
         alert('上次查寝未结束或本次查寝数据库已生成');
         window.location.href='admin.html';
         </script> ");
    }
//在数据库中创建本次查寝的数据表（data）
/*
    id int auto_increment primary key   //自增主键
    time timestamp                      //自动时间戳
    no text                             //寝室号（以文本形式存储）
    depdone tinyint(1)                  //标记：该寝室在学院数据库中有记录（在导出数据时生成）
    bed tinyint(1)                      //床是否合格
    bin tinyint(1)                      //垃圾桶是否合格
    floor tinyint(1)                    //地面是否合格
    smell tinyint(1)                    //气味是否合格
    place tinyint(1)                    //摆放是否合格
    door tinyint(1)                     //门口是否合格
    wc tinyint(1)                       //厕所是否合格
    power tinyint(1)                    //违规电器
    line tinyint(1)                     //乱拉电线
    fire tinyint(1)                     //使用明火
    rank int(1)                         //寝室评级（1，优秀。2，良好。3，合格。4，不合格。5，无人。6，违纪。该评级自动生成）
    user text                           //添加记录的用户
    ipaddr text                         //添加记录的ip地址
*/
$sql = "CREATE TABLE data
(
id int auto_increment primary key,
time timestamp ,
no text,
depdone tinyint(1),
bed tinyint(1),
bin tinyint(1),
floor tinyint(1),
smell tinyint(1),
place tinyint(1),
door tinyint(1),
wc tinyint(1),
power tinyint(1),
line tinyint(1),
fire tinyint(1),
rank int(1),
user text,
ipaddr text
)";
mysql_query($sql, $con);
//搞定：提示，返回主页面
mysql_close($con);
exit( "
     <script language=javascript>
     alert('数据库生成成功，可以开始查寝。');
     window.location.href='admin.html';
     </script> ");
?>