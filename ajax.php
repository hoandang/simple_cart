<?php

	include 'function/function.php';
		
	$db = $GLOBAL['db'];
	
	$action = $_GET['action'];
	
	switch($action){
		
		// Load brief cart
		case 'load':
			if(!isset($_COOKIE['item']))
				echo '{"item":"0 item","price":"$0"}';
			else{
			
				loadBriefCart($_COOKIE['item']);
			}
				
		break;
		
		// Add item
		case 'add':
			
			$id = $_GET['id'];
			$list = (isset($_COOKIE['item'])) ? $_COOKIE['item'] : '';
			
			$new_list_item = '';
			// Call function add() to return a new list item
			$new_list_item = add($id, $list);
			
			setcookie('item', $new_list_item, time()+604800);

			loadBriefCart($new_list_item);
			
		break;
		
		// Show cart
		case 'show':
			// render header of table cart
			echo renderHeaderCart();
					
			// render content of table cart
			if(isset($_COOKIE['item'])){
					
				echo renderLabelItem();
				renderContentCart($_COOKIE['item']);
			}
			else{
			
				echo renderEmptyCart();			
			}
			
			// render footer of table cart
			echo renderFooterCart();
			
		break;
		
		// Edit item
		case 'edit':
		
			echo renderHeaderCart();
			
			echo renderLabelItem();
				
			$new_list_item = '';
			
			$way = $_GET['way'];
			switch($way){
				
				case 'delete':

					$del_item = $_GET['id'];

					// Call function delete() to return a new list item
					$new_list_item = delete($del_item, $_COOKIE['item']);

					setcookie('item', $new_list_item, time() + 604800);
					
				break;
				
				
				case 'update':
				
					// Call function update() to return a new list item
					$new_list_item = update($_GET['list']);
					
					setcookie('item', $new_list_item, time() + 604800);
				
				break;

				//******* Sort ************/
				case 'sortbyname':
	
					$list_name_item = '';
					$list_item = '';
					$method = $_GET['method'];
					
					$list_item = explode(',', $_COOKIE['item']);
					foreach($list_item as $value){
					
						foreach($db as $row){
							if(strcmp($row['id'],$value) === 0){
								if($list_name_item == '')
									$list_name_item = substr($row['name'], 0, 1).'.'.$value;
								else
									$list_name_item .= ','.substr($row['name'], 0, 1).'.'.$value;
							}
						}
					}
					
					$list_name_item = _sort($list_name_item, $method);
	
					$new_list_item = arrange($list_name_item);
					
					setcookie("item", $new_list_item, time() + 604800);
					
				break;
				
				case 'sortbyqt':
					
					$list_quantity = '';
					$method = $_GET['method'];
					
					$arr = array(); // init quantity for each item
					$list_item = explode(",", $_COOKIE['item']);
		
					foreach($list_item as $id){
						$arr[$id] = (isset($arr[$id])) ? $arr[$id] + 1 : 1;
					}
					
					foreach($arr as $id=>$quantity){
					
						$count = 0;
						while($count < $quantity){
							if($list_quantity == '')
								$list_quantity = $quantity.'.'.$id; 
							else
								$list_quantity .= ','.$quantity.'.'.$id;
							$count++;
						}						
					}

					$list_quantity = _sort($list_quantity, $method);
				
					$new_list_item = arrange($list_quantity);
					
					setcookie("item", $new_list_item, time() + 604800);
					
				break;
				
				case 'sortbyprice':
	
					$list_price_item = '';
					$total_price_each = 0;
					$method = $_GET['method'];
					
					$arr = array(); // init quantity for each item
					
					$list_item = explode(",", $_COOKIE['item']);
					foreach($list_item as $id){
					
						$arr[$id] = (isset($arr[$id])) ? $arr[$id] + 1 : 1;
					}
					
					foreach($arr as $id=>$quantity){
					
						foreach($db as $row){
							if(strcmp($row['id'], $id) === 0){
								$count = 0;
								while($count < $quantity){
								
									if($list_price_item == '')
										$list_price_item = ($quantity * $row['price']).'.'.$id;
									else
										$list_price_item .= ','.($quantity * $row['price']).'.'.$id;
									$count++;
								}
							}
						}
					}
					
					$list_price_item = _sort($list_price_item, $method);
					
					$new_list_item = arrange($list_price_item);
				
					setcookie("item", $new_list_item, time() + 604800);
				break;
			}
			
			
			if($new_list_item != ""){
				
				renderContentCart($new_list_item);
			}
			else{
				echo renderEmptyCart();
			}
			
			echo renderFooterCart();
					
			default:
			break;
			
		break;		
	
		default:
		break;
	
	}

?>