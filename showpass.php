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
 * @discribe   查寝系统显示生成的密码
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>密码</title>
</head>
<!-- 太简单，不想写注释了-->
<body>
请复制<br/>
<?php
echo "用户【";
echo $_REQUEST['user'];
echo "】的密码是【";
echo $_REQUEST['pass'];
echo "】<br/>";
?>
<br/>
<a href="admin.html">返回</a>
<small>Power By <a href="https://echoiot.com">易控实验室</a>,<a href="https://tec.hxlxz.com">何相龙</a>.<a href="https://github.com/hxl9654/chaqin">SourceCode</a></small>
</body>
</html>
