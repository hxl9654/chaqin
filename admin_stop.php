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
 * @discribe   查寝系统管理-查寝结束
-->
<?php
//判断当前是否在进行查寝（data数据表是否存在）
$result = mysql_query("select * from data limit 1");
if(mysql_fetch_array($result) == "")
{
    mysql_close($con);
    exit( "
     <script language=javascript>
     alert('当前没有进行查寝');
     window.location.href='admin.html';
     </script> ");
}
//判断传入的参数（要保存到的数据表的名字是否为空），是：报错，返回
if($_REQUEST[inf] == "")
{
    mysql_close($con);
    exit( "
         <script language=javascript>
         alert('名字冲突，请重新输入');
         window.location.href='admin.html';
         </script> ");
}
//判断要保存到的数据表的名字是否已存在，是：报错，返回
$result = mysql_query("select * from $_REQUEST[inf] limit 1");
if(mysql_fetch_array($result) != "")
{
    mysql_close($con);
    exit( "
     <script language=javascript>
     alert('名字冲突，请重新输入');
     window.location.href='admin.html';
     </script> ");
}
//删除上次的lastdata表
mysql_query("DROP TABLE lastdata");
mysql_query($sql, $con);
//将这次的查寝数据（data表）复制到lastdata表
mysql_query("CREATE TABLE lastdata SELECT * FROM data");
mysql_query($sql, $con);
//将这次的查寝数据（data表）存档到用户自定义的数据表（推荐以日期作为表名）
mysql_query("RENAME TABLE '" + DBName + "'.'data'  TO '" + DBName + "'.`db$_REQUEST[inf]` ");
mysql_query($sql, $con);
//搞定：提示，返回主界面
mysql_close($con);
exit( "
     <script language=javascript>
     alert('查寝结束，可以生成报告。');
     window.location.href='admin.html';
     </script> ");
?>
