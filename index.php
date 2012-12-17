<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<link rel="stylesheet" type="text/css" href="mainStyle.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/ajax_manager.js"></script>
<script type="text/javascript" src="js/effect.js"></script>

<title>- Cart -</title>
</head>
<body onkeyup="closeCartbyESC(event)">
	<div id="wrapper">
		<div id="container">
			<ul id="prod_list">
				<?php include 'inc_product.php'; ?>
			</ul><!-- end of list of products  -->

			<div id="cart">
				<h1 class="rounded_corners_top">Your Cart</h1>
				<p class="rounded_corners_bottom">
					<img class='loadbrief' alt="progress" src="images/progress.gif" /><span class="item"></span>
					<img class='loadbrief' alt="progress" src="images/progress.gif" /><span class="price"></span>
					<a href="javascript:showCart()"><img alt="View cart" src="images/shoppingcart.gif" /></a>
				</p>
				<span class="help">View your cart</span>
			</div><!-- end of cart -->
			
		</div>
		<div id="loading">
			<img alt="Loading" src="images/loading.gif" />
		</div>
		
		<div id="waiting">
			<img alt="Waiting" src="images/waiting.gif" />
		</div>
		
		<div id="box">	
		</div>
		
	</div><!-- end of wrapper -->
</body>
</html>
