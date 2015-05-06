# 查寝系统
用HTML+PHP+MySQL写的一个简单的学生会查寝系统  <br/>
数据库请务必使用41位加密方式，否则会有奇怪的兼容性问题  <br/>
由于本人是初学PHP，所以该程序可能有不规范的地方甚至是错误，请谅解 <br/>
请根据自己数据库的情况配置config.php文件 <br/>
需要使用寝室数据库和一个空的密码数据库  <br/>
源代码使用GPL许可证授权，请遵守<a href="https://github.com/qwgg9654/chaqin/blob/master/LICENSE">许可证条款</a>，尊重作者的劳动！  <br/>
## 数据库格式
### pass数据表 
test username  <br/>
text pass  <br/>
数据表为空  <br/>
### inf数据表 
text     no     寝室号  <br/>
int(2)   dep    学院代码  <br/>
数据表须有各寝室对应学院的数据  <br/>