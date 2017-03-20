<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<body>
<form action="/index.php/Home/Index/android" method="post" enctype="multipart/form-data">
    <label>安卓版本地址</label><input type="file" name="file">&nbsp;&nbsp;
    <input type="submit" value="提交"><hr/>
</form>
<form method="post" action="/index.php/Home/Index/ios" >
    <label>上传苹果应用的地址</label><input type="text" name="file1" value=<?php echo ($pathname); ?>>&nbsp;&nbsp;

    <input type="submit" value="提交上传"><hr/>
</form>
</body>


        <label><a href="/index.php/Home/Index/logout">注销</a> </label><br/>
        <label><a href="/index.php/Home/Index/changepwd">更改密码</a> </label>

    </form>
</body>
</html>