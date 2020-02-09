<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="ru">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="UTF-8">
		<title>Наш кинотеатр</title>

        <script src="/js/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<a href="/">Наш кинотеатр</span></a>
				</div>
				<div id="menu">
					<ul>
						<li class="first active"><a href="/">Главная</a></li>
							<li><a href="/admin">Администрирование</a></li>
					</ul>
					<br class="clearfix" />
				</div>
			</div>
			<div id="page">

				<div id="content">
					<div class="box">
						<?php include 'application/views/'.$content_view; ?>
					</div>
				<br class="clearfix" />
			</div>

		</div>
	</body>
</html>