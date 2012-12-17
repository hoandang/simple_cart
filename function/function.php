<?php

include 'db/cloneDB.php';
	
$db = $GLOBAL['db'];

function renderHeaderCart(){

	return '<p class="close"><span onclick="javascript:refreshCart()"><img title="Close" src="images/close.png" width="18px" height="18px" /></span><span>or press ESC</span></p>
			<div id="cart_detail">
				<table>
					<caption>
						<span><img alt="Icon cart" src="images/icon-cart.png" width="31px" height="23px"/></span>
						Your cart
					</caption>';
}

function renderLabelItem(){
	
	return '<thead>
			<tr>
				<th><a href="javascript:sortByName()" title="Sort by name">Name</a></th>
				<th>Images</th>
				<th><a href="javascript:sortByQt()" title="Sort by quantity">Quantity</a></th>
				<th><a href="javascript:sortByPrice()" title="Sort by total price">Total</a></th>
			</tr>
		</thead>';
}

function renderContentCart($list){

	global $db;
	
	$list_of_item = "";
	$list_of_item = explode(",", $list);

	$arr = array(); // init quantity for each item
	
	foreach($list_of_item as $value){
		$arr[$value] = (isset($arr[$value])) ? $arr[$value] + 1 : 1;
	}
	$name;
	$total_price_each = 0;
	$sub_total = 0;
	
	foreach($arr as $key=>$value){
		
		foreach($db as $row){
			if(strcmp($row['id'],$key) === 0){
			
				$total_price_each = $value * $row['price'];
				$sub_total += $total_price_each; 
				
				echo '<tbody>
						  <tr>
							  <td>'.$row['name'].'</td>
							  <td>
								  <img alt="'.$row['name'].'" src="images/'.$row['image'].'" 
										 width="100px" height="80px" />
							  </td>
							  <td class="quantity">
								<p>
									<input type="text" maxLength="3" onkeyup="change(this.value,'.$key.','.$row['price'].')" value="'.$value.'" id="qt'.$key.'"/>
									<a href="javascript:deleteItem('.$key.')" class="remove_lnk" title="Remove this item">
										<span></span>
									</a>
								 </p>
								 <p><img id="progress'.$key.'" alt="progess" src="images/progress.gif" /></p>
							  </td>
							  <td class="price">
								  <span id="prod_id_'.$key.'">$'.$total_price_each.'</span>
								  <p>$'.$row['price'].' each</p>
							  </td>
						  </tr>
					  </tbody>';
			}	
		}
	}
	
	echo'<tfoot>
			<tr>
				<td colspan="4">
					Subtotal: <span id="sum">$'.$sub_total.'</span>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<a id="lnk_update" href="javascript:update()"><span></span></a>
					<a href="index.php"><span></span></a>
				</td>
			</tr>
		</tfoot>';
}

function renderEmptyCart(){

	return '<script>$("thead").remove();</script>
			<tr>
				<td colspan="4">
					<h3>Your cart is empty</h3>
				</td>
			</tr>';
}

function renderFooterCart(){

	return '</table><!-- end of the detail of cart -->
				</div>
				
				<p class="back"><span href="#" onclick="javascript:refreshCart()">&#60;&#60;&#60; Continue to shopping</span></p>';
}

function loadBriefCart($list){

	global $db;
	$total = 0;
			
	foreach(explode(',',$list) as $value){
	
		foreach($db as $row){
		
			if(strcmp($row['id'],$value) === 0)
				$total += (int)$row['price'];
		}
	}
	
	$count = count(explode(',',$list));
	$s = ($count > 1) ? 'items' : 'item';
	echo '{"item":"'.$count.' '.$s.'","price":"$'.$total.'"}';
}

function add($id, $list){

	$new_list_item = '';
	
	if($list == '')
		$new_list_item = $id; 
	else{
		$new_list_item = $list;
		$new_list_item .= ','.$id;
	}
	
	return $new_list_item;
}

function delete($del_item, $list){

	$new_list_item = '';

	foreach(explode(',', $list) as $value){
	
		if($value != $del_item){
			if($new_list_item != '')
				$new_list_item .= ','.$value; 
			else
				$new_list_item = $value;
		}
	}
	
	return $new_list_item;
}

function update($list){

	$new_list_item = '';

	foreach(explode(',',$list) as $value)
	{
		$value = explode('=>', $value);
		$count = 0;
		while($count < (int)$value[1])
		{	
			if($new_list_item == '')
				$new_list_item = $value[0];
			else
				$new_list_item .= ','.$value[0];
			$count++;
		}
	}
	
	return $new_list_item;
}

function swap(&$a, &$b){

	$temp = $a;
	$a = $b;
	$b = $temp;
}

function _sort($list, $method){
	
	$new_list_item = '';
	$new_list_item = explode(',', $list);
					
	for($i = 0; $i < count($new_list_item) - 1; $i++){
	
		for($j = $i + 1; $j < count($new_list_item); $j++){
			//asc
			if(strcmp($method,'>') === 0){
			
				if($new_list_item[$i] > $new_list_item[$j]){
			
					swap($new_list_item[$i], $new_list_item[$j]);
				}
			}
			//desc
			if(strcmp($method,'<') === 0){
			
				if($new_list_item[$i] < $new_list_item[$j]){
			
					swap($new_list_item[$i], $new_list_item[$j]);
				}
			}
			
		}
	}
	
	return $new_list_item;
}

function arrange($list){

	$new_list_item = '';
	foreach($list as $value){
							
		for($i = 0; $i < strlen($value); $i++){
	
		if(strcmp($value[$i],'.') === 0)
			$value = substr($value, $i + 1, $i + 2);
		}
			
		if($new_list_item == '')
			$new_list_item = $value;
		else
			$new_list_item .= ','.$value;
	}
	
	return $new_list_item;
}

?>
