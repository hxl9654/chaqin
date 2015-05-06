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
 * @discribe   查寝系统数据录入
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提交中</title>

    //获取URL中的参数（用于记住密码）
    <script type="text/javascript">
    function $G(){
        var Url=window.location.href;//如果想获取框架顶部的url可以用 top.window.location.href
        var u,g,StrBack='';
        if(arguments[arguments.length-1]=="#")
           u=Url.split("#");
        else
           u=Url.split("?");
        if (u.length==1) g='';
        else g=u[1];

        if(g!=''){
           gg=g.split("&");
           var MaxI=gg.length;
           str = arguments[0]+"=";
           for(xm=0;xm<MaxI;xm++){
              if(gg[xm].indexOf(str)==0) {
                StrBack=gg[xm].replace(str,"");
                break;
              }
           }
        }
        return StrBack;
    }
    </script>

//获取pass参数（即上次使用的密码）
<script type="text/javascript"> var pass=$G("pass"); </script>
</head>

<body>
<?php
//解决变量未定义报错
function _rowget($str,$row)
{
    $val = !empty($row[$str]) ? $row[$str] : null;
    return $val;
}
//屏蔽部分错误信息
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
//导入获取ip函数
include 'getip.php';
//连接数据库
include 'database.php';
//判断当前是否正在进行查寝（data数据库是否存在），否；提示，转到管理界面
$result = mysql_query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_NAME='data' ;");
	if(mysql_fetch_array($result) == "")
    {
        mysql_close($con);
		exit("
		 <script language=javascript>
		 alert('本次查寝未开始，请联系管理员');
		 window.location.href='admin.html';
		 </script> ");
    }
//验证密码，错误：提示，返回
$result = mysql_query("select pass from pass where pass = '$_REQUEST[pass]' limit 1");
if(mysql_fetch_array($result) == "")
{
    mysql_close($con);
	exit("
	 <script language=javascript>
	 alert('密码错误，提交失败');
	 window.location.href='check.html';
	 </script> ");
}
//判断当前寝室是否已有数据，是：提示，返回
$result = mysql_query("select * from data where no = '$_REQUEST[no]' limit 1");
if(mysql_fetch_array($result) != "")
{
    mysql_close($con);
	exit("
	 <script language=javascript>
	 alert('数据重复，提交失败，请手动处理。');
	 window.location.href='check.html?pass='+pass;
	 </script> ");
}
//判断是否输入了寝室号，否：提示，返回
if($_REQUEST['no'] == "")
{
    mysql_close($con);
    exit("
	 <script language=javascript>
	 alert('请填写寝室号');
	 window.location.href='check.html?pass='+pass;
	 </script> ");
}
//查询当前操作密码对应的操作者
mysql_query("set character set 'utf8'");
$sql = "SELECT * FROM pass WHERE pass = '$_REQUEST[pass]' ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$username = _rowget('username', $row);

//根据规定判断当前寝室的等级
if($_REQUEST['abuse'] == 2)
	$rank = 5;
else if($_REQUEST['power'] == 1 || $_REQUEST['fire'] == 1 || $_REQUEST['line'] == 1)
	$rank = 6;
else if($_REQUEST['bed'] == 0 || $_REQUEST['bin'] == 0 || $_REQUEST['floor'] == 0 || $_REQUEST['smell'] == 0)
	$rank = 4;
else if($_REQUEST['place'] == 1 && $_REQUEST['door'] == 1 && $_REQUEST['wc'] == 1)
	$rank = 1;
else if($_REQUEST['place'] == 1 || $_REQUEST['door'] == 1 || $_REQUEST['wc'] == 1)
	$rank = 2;
else $rank = 3;
//获取ip地址
$ipaddr = get_real_ip();
//向数据库写数据
$sql = "INSERT INTO data (no, bed, bin, floor, smell, place, door, wc, power, line, fire, rank, user, ipaddr, depdone)
VALUES
('$_REQUEST[no]','$_REQUEST[bed]','$_REQUEST[bin]','$_REQUEST[floor]','$_REQUEST[smell]','$_REQUEST[place]','$_REQUEST[door]','$_REQUEST[wc]','$_REQUEST[power]','$_REQUEST[line]','$_REQUEST[fire]','$rank','$username','$ipaddr','0')";

if (!mysql_query($sql, $con))
{
    die('Error: ' . mysql_error());
}
else
{
    mysql_close($con);
	exit("
	 <script language=javascript>
	 alert('提交成功');
	 window.location.href='check.html?pass='+pass;
	 </script> ");
}
?>
<small>Power By <a href="https://echoiot.com">Echo</a>,<a href="https://tec.hxlxz.com">hxl</a></small>
</body>
</html>
