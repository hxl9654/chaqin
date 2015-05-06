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
 * @discribe   查寝系统查询寝室记录
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询结果</title>
</head>

<body>
<a href="index.html">返回首页</a>
<br/>
<?php
//屏蔽部分错误信息
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
//连接数据库
require 'database.php';
//获取要重新的数据库名（就是查寝时间）
$dbname = $_REQUEST['db'];
//如果指定了数据库，选中
if($dbname != "")
    $result = mysql_query("SELECT * FROM db$dbname WHERE no = '$_REQUEST[no]' ");
//如果没有指定数据库，默认选择当前正在进行查寝的数据库
else
{
    $result = mysql_query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_NAME='data' ;");
    if(mysql_fetch_array($result) != "")
        $result = mysql_query("SELECT * FROM data WHERE no = '$_REQUEST[no]' ");
    else 
    {
        $result = mysql_query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_NAME='lastdata' ;");
        //如果没有记录，则查询上次查寝的数据
        if(mysql_fetch_array($result) != "")
            $result = mysql_query("SELECT * FROM lastdata WHERE no = '$_REQUEST[no]' ");
        else 
        {
            mysql_close($con);
            exit( "
             <script language=javascript>
             alert('暂无该寝室记录。');
             window.location.href='lookup.html';
             </script> ");
        }
    }
}
$row = mysql_fetch_array($result);
//如果还是没有数据，提示，返回。
if($row == "")
{
    mysql_close($con);
    exit( "
     <script language=javascript>
     alert('暂无该寝室记录。');
     window.location.href='lookup.html';
     </script> ");
}
//如果寝室查寝时无人，提示，返回
if($row['rank'] == 5)
{
    mysql_close($con);
    exit( "
	 <script language=javascript>
	 alert('该寝室查寝时无人。');
	 window.location.href='lookup.html';
	 </script> ");
}

?>
<!--输出相关信息-->
<table frame="border" rules="all">
	<tr>
		<td align="center" colspan="2">
			寝室号
			【<?php  echo $row['no'];  ?>】
		</td>
	</tr>
    <tr>
     	<td align="center" colspan="2">
        	总评结果
        	 【<?php
			     if($row['rank']==1) echo '优秀';
			     else  if($row['rank']==2) echo '良好';
			     else  if($row['rank']==3) echo '合格';
			     else  if($row['rank']==4) echo '不合格';
				 else  if($row['rank']==5) echo '无人';
				 else  if($row['rank']==6) echo "<b><font color='#FF0000'>违纪</font></b>";
			  ?>】
     	</td>
     </tr>
     	<tr>
		<td align="center" colspan="2">
			操作者
        	【<?php  echo $row['user'];  ?>】
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			基础项
		</td>
	</tr>
	<tr>
		<td width="90%">
        	床铺整理过，未堆放过多杂物
        </td>
        <td width="10%">
        	<?php if($row['bed']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	垃圾桶内垃圾未达到一半
        </td>
        <td width="10%">
        	<?php if($row['bin']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	地面无垃圾、纸屑
        </td>
        <td width="10%">
          <?php if($row['floor']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	室内无异味，门口无垃圾
        </td>
        <td width="10%">
        	<?php if($row['smell']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>

     <tr>
		<td align="center" colspan="2">
			提高项
		</td>
	</tr>
	<tr>
		<td width="90%">
        	物品杂物摆放有序
        </td>
        <td width="10%">
        	<?php if($row['place']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	门窗被子墙壁无污渍
        </td>
        <td width="10%">
        	<?php if($row['door']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	卫生间瓷砖、洗脸盆、便池无污渍
        </td>
        <td width="10%">
        	<?php if($row['wc']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>

     <tr>
		<td align="center" colspan="2">
			违纪项
		</td>
	</tr>
	<tr>
		<td width="90%">
        	大功率电器
        </td>
        <td width="10%">
        	<?php if($row['power']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	乱接电线
        </td>
        <td width="10%">
        	<?php if($row['line']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
     	<tr>
		<td width="90%">
        	使用液化气灶等明火器具
        </td>
        <td width="10%">
        	<?php if($row['fire']==1) echo '是';else echo '否';  ?>
        </td>
     </tr>
</table>
<?php mysql_close($con); ?>
<small>Power By <a href="https://echoiot.com">Echo</a>,<a href="https://tec.hxlxz.com">hxl</a></small>
</body>
</html>
