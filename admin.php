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
 * @discribe   查寝系统管理
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生会查寝系统-管理</title>
</head>

<body>
<a href="index.html">返回首页</a>
<br/>
<?php
require 'config.php';
//屏蔽部分错误信息
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
//如果没有选择要进行的操作：报错，返回
if($_REQUEST['todo'] == "")
	exit( "
			 <script language=javascript>
			 alert('请选择要进行的操作');
			 window.location.href='admin.html';
			 </script> ");
//检查管理员密码是否正确，直接在config.php设置管理员密码
if($_REQUEST['pass'] != AdminPassword1 && $_REQUEST['pass'] != AdminPassword2)
	exit( "
			 <script language=javascript>
			 alert('密码错误');
			 window.location.href='admin.html';
			 </script> ");
//解决变量未定义报错
function _rowget($str, $row){
    $val = !empty($row[$str]) ? $row[$str] : null;
    return $val;
}

//连接数据库
require 'database.php';

//如果选择的是查寝开始
if($_REQUEST['todo'] == 1)
{
    require 'admin_start.php';
}
//如果选择的是查寝结束
else if($_REQUEST['todo'] == 2)
{
    require 'admin_stop.php';
}
//如果选择的是生成报告
else if($_REQUEST['todo'] == 3)
{
    require 'admin_report.php';
}
//如果选择生成密码
else if($_REQUEST['todo'] == 4)
{
    require 'admin_newpass.php';
}
//如果选择的是清空密码
else if($_REQUEST['todo'] == 5)
{
    require 'admin_clearpass.php';
}
else mysql_close($con);
?>
<small>Power By <a href="https://echoiot.com">易控实验室</a>,<a href="https://tec.hxlxz.com">何相龙</a>.<a href="https://github.com/hxl9654/chaqin">SourceCode</a></small>
</body>
</html>
