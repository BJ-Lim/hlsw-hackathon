<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<h2 align="center">Login</h2>
<div class="wrapper">
	<form id="login_form" action="login.php" method="POST" FONT face="impact">
    <div class="wrap-input">
        <input name="id" class="input-block-level" type="text" placeholder="id" required></input>
    </div>
	<br>
    <div class="wrap-input">
        <input name="pass" class="input-block-level" type="text" placeholder="password" required></input>
    </div>
	<br>
		<button class="button" onsubmit="" >login</button>
	</form>
</div>
</body>
</html>