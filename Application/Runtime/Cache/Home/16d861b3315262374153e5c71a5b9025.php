<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="post" action="/test3/index.php/Home/Index/ios" >
    <label>上传苹果应用的地址</label><input type="text" name="file1" value=<?php echo ($pathname); ?>>&nbsp;&nbsp;

    <input type="submit" value="提交上传"><hr/>
</form>
</body>
</html>