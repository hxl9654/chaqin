/**
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
 * @discribe   查寝系统管理-增加用户
 */
<?php
//生成密码函数
function generate_password($length)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'acdefghijkmnprstuvwxyz234578';
    $password = "";
    //生成密码
    for ( $i = 0; $i < $length; $i++ )
    {
        //生成密码的一位
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
}
//判断输入的用户名是否已经存在，是：提示，返回
$result = mysql_query("select * from pass where username = '$_REQUEST[inf]' limit 1");
if(mysql_fetch_array($result) != "")
{
    mysql_close($con);
     exit( "
     <script language=javascript>
     alert('用户名重复。');
     window.location.href='admin.html';
     </script> ");
}
//生成密码，直到产生一个与数据库中其他密码不同的密码
do
    {
        $passwords = generate_password(8);
        $result = mysql_query("select * from pass where pass = '$passwords' limit 1");
    }while(mysql_fetch_array($result)!="");
//获取传入的用户名
$username = $_REQUEST[inf];
//添加用户
$sql = "INSERT INTO pass (pass, username) VALUES('$passwords','$username')";
mysql_query($sql,$con);
//搞定：提示，返回
mysql_close($con);
exit( "
     <script language=javascript>
     alert('密码生成成功，请保存。');
     window.location.href='show.php?pass=$passwords&user=$username';
     </script> ");
?>