<?php require_once('../Connections/core.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mengirim email dengan PHP | Tutorial Website</title>
	<style>
	.mail{
		width: 730px;
		margin: 10px auto;
		border: 1px solid #ddd;
		padding: 10px;
	}
	.mail div{
		padding: 5px 0;
		border-bottom: 1px solid #ddd;
	}
	label{
		width: 100px;
		display: inline-block;
	}
	.bottom{
		font-size: 12px;
		text-align: right;
	}
	</style>
</head>
<body>
	

<div class="mail">
	<div class="top"><a href="http://www.tutorial-website.com">Tutorial-Website.com</a></div>
	<h1>Contact Us</h1>
	<form action="send_mail.php" method="post">
		
		<div>
			<label for="name">Name</label>
			<input type="text" name="name">
		</div>

		<div>
			<label for="email">Email</label>
			<input type="text" name="email">
		</div>

		<div>
			<label for="subject">Subject</label>
			<input type="text" name="subject">
		</div>

		<div>
			<label for="message">Message</label>
			<textarea name="message" id="" cols="30" rows="10"></textarea>
		</div>

		<div><input type="submit" value="Send email"></div>

	</form>
	<div class="bottom"><a href="http://www.tutorial-website.com">Back to tutorial</a></div>
</div>

</body>
</html>