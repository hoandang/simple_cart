<?php

	include 'db/cloneDB.php';
	
	$db = $GLOBAL['db'];
	
	foreach($db as $row){
		echo '<li>
				<div class="content">

					<h1 class="rounded_corners_top">'.$row['name'].'</h1>
					<p>
						<span>Price: $'.$row['price'].'</span>
						<img alt="'.$row['name'].'"
						src="images/'.$row['image'].'" width="130px" height="110px"/>
					</p>
					<a href="javascript:addCart('.$row['id'].')" class="rounded_corners_bottom">
						Add to cart
						<img id="_'.$row['id'].'" class="ajax_load" alt="Ajax load" src="images/ajax-loader.gif" />
					</a>
				</div><!-- end of content of product -->
			</li>';
	}

?>
