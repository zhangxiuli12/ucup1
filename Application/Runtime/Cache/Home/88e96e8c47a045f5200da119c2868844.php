<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员登陆</title>

</head>
<body>
    <form method="post" action="/test3/index.php/Home/Index/login">
        <label>请输入管理员账号</label><input type="text" name="name"> <br/>
        <label>请输入管理员密码</label><input type="password" name="password"><br/><hr/>
        <input type="submit" value="提交">

    </form>
</body>
</html>