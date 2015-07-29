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
 * @discribe   查寝系统管理-生成报告
-->
<?php
//如果传入参数（要查询的数据库名）为空：提示，返回
if($infsql == "")
{
    mysql_close($con);
    exit( "
         <script language=javascript>
         alert('请输入数据库名');
         window.location.href='admin.html';
         </script> ");
}
//如果要查询的数据库名不存在：提示，返回
$result = mysql_query("select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_NAME='db$infsql' ;");
if(mysql_fetch_array($result) == "")
{
    mysql_close($con);
    exit( "
     <script language=javascript>
     alert('没有找到这个数据库');
     window.location.href='admin.html';
     </script> ");
}
//定义各学院对应的代码 （1为信安院，2为光电院，以此类推）
$depname = array("","信息安全工程学院","光电技术学院","外国语学院","大气科学学院","应用数学学院","控制工程学院","电子工程学院","计算机学院","资源环境学院","通信工程学院","软件工程学院");
//定义等级代码（1为优秀，2为良好，以此类推）
$rankname = array("","优秀","良好","合格","不合格","无人","违纪");
//输出各学院各等级的寝室列表
$i = 1;
echo "<table border='1' cellspacing='0'>";
while($i <= 12)
{
    //单独处理学院信息不清的寝室
    if($i == 12)
    {
        echo "<tr>";
        echo "<th colspan='10'>学院信息不清</th>";
        echo "</tr>";
        //如果数据库中某寝室的 depdone 值没有被置1（默认为0），则该寝室在数据库中没有对应的学院
        //在数据库中查找这种寝室
        $result = mysql_query("SELECT * FROM db$infsql WHERE depdone!='1'");
        $j = 0;
        //清空缓存数组
        unset($depinf);
        //将学院信息不清的寝室加入缓存数组
        while($row = mysql_fetch_array($result))
          {
              $depinf[$j] = $row['no'];
              $j = $j + 1;
          }
        //记录寝室数量
        $jmax = $j;
    }
    //依次处理每个学院的寝室
    else
    {
        //先输出学院的名称
        echo "<tr><th colspan='10'>";
        echo $depname[$i];
        echo "</th></tr>";
        //在数据库查找该学院所有寝室
        $result = mysql_query("SELECT * FROM inf WHERE dep='$i'");
        $j = 0;
        //将这些寝室加入缓存数组
        while($row = mysql_fetch_array($result))
          {
              $depinf[$j] = $row['no'];
              $j = $j + 1;
          }
        //记录寝室数量
        $jmax = $j;
    }
    //输出寝室号
    $k = 1;
    while($k < 7)
    {   
        //输出等级名称
        echo "<tr><td colspan='10' align='center'>";
        echo $rankname[$k];
        echo "</td></tr><tr>";
        $j = 0;
        $l = 0;
        while($j <= $jmax)
        {
            //查找等级、学院符合本次查找的寝室
            $result = mysql_query("SELECT * FROM db$infsql WHERE no='$depinf[$j]' && rank='$k'");           
            while($row = mysql_fetch_array($result))
            {
                //输出带链接（到查询这个寝室的具体信息）的寝室号
                echo "<td width='10%'><a href='lookup.php?no=$row[no]&db=$infsql' target='_blank'>";
                echo $row['no'];
                echo "</a>&nbsp;&nbsp;</td>";
                $l = $l + 1;
                //每输出10个寝室换一行
                if($l >= 10)
                {
                    echo "</tr><tr>";
                    $l = 0;
                }
            }
            $j = $j + 1;
        }
        while($l < 10)
        {
            echo "<td width='10%'></td>";
            $l = $l + 1;
        }
        echo "</tr>";
        //如果该寝室不是没有对应学院的寝室
        if($i != 12)
        {
            //设置该寝室是有对应学院的寝室（数据库中寝室号对应的depdone置1）
            $j = 0;
            while($j <= $jmax)
            {
            mysql_query("UPDATE db$infsql SET depdone = '1' WHERE no = '$depinf[$j]'");
            $j = $j + 1;
            }
        }
        $k = $k + 1;
    }
    $i = $i + 1;
}
?>
<tr><td colspan='10' align='center'><small>
    本程序由<a href="https://echoiot.com">易控实验室</a>,<a href="https://tec.hxlxz.com">何相龙</a>提供。复制、修改请遵循<a href="http://www.gnu.org/licenses/">GPL许可证</a>。
</small></td></tr>
</table><br/>