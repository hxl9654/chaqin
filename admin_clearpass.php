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
 * @discribe   查寝系统管理-清空密码
-->
<?php
//清空密码数据库
//判断pass数据表是否存在
$result = mysql_query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_NAME='pass' ;");
//存在：清空pass表
if(mysql_fetch_array($result) != "")
{
    $sql="TRUNCATE TABLE pass";
    mysql_query($sql, $con);
}
//不存在：新建pass数据表
else 
{   
    $sql = "CREATE TABLE pass
    (
    id int auto_increment primary key,
    pass text,
    username text
    )";
    mysql_query($sql, $con);
}
$sql = "INSERT INTO pass (pass, username) VALUES('$AdminPass1',' ')";
mysql_query($sql, $con);
$sql = "INSERT INTO pass (pass, username) VALUES('$AdminPass2',' ')";
mysql_query($sql, $con);

//搞定:提示，返回
mysql_close($con);
exit( "
     <script language=javascript>
     alert('密码清除成功，请重新生成。');
     window.location.href='admin.html';
     </script> ");
?>
