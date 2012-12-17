$(document).ready(function(){
	loadBriefCart();
	$.cookie("flag", 0, { expires: 7 });
});

function closeCartbyESC(event){
	var status = $("#box").css("display");
	if(event.keyCode == 27 && status != 'none')
		refreshCart();
}

function loadBriefCart(){
	
	$.ajax({
	
		type: 'GET',
		url: 'ajax.php',
		data: 'action=load',
		dataType: 'json',
		
		beforeSend: function(){
			$("#cart p img.loadbrief").show();
		},
		
		success: function(msg){
			$("#cart p img.loadbrief").hide();
			$("#cart span.item").html(msg.item);
			$("#cart span.price").html(msg.price);
		}
		
	});
	
}

function addCart(id){
	
	$.ajax({
		type: 'GET',
		url: 'ajax.php',
		data: 'action=add&id='+id,
		dataType: 'json',
		
		beforeSend: function(){
			$("#_"+id).fadeIn("fast");
			$("#cart p img.loadbrief").show();
		},
		
		success: function(msg){
			$("#cart p img.loadbrief").hide();
			$("#cart span.item").html(msg.item);
			$("#cart span.price").html(msg.price);
			$("#_"+id).fadeOut("slow");
		}
	
	});
	
}

function showCart(){

	$.ajax({
		type: 'GET',
		url: 'ajax.php',
		data: 'action=show',
		dataType: 'html',
		
		beforeSend: function(){
		
			$("body").css({'backgroundColor':'#7F7F7F'});
			$("#container").css({'opacity':'0.1','zIndex':'-1000'});	
			$("#loading").show();
			
		},
		
		success: function(msg){
			$("#loading").hide();
			$("#box").css({'zIndex':'90000'}).fadeIn();
			$("#box").html(msg);
			setOverflowCart($("#cart_detail").height());
		}
	
	});

}

function refreshCart(){
	
	$.ajax({
	
		type: 'GET',
		url: 'ajax.php',
		data: 'action=load',
		dataType: 'json',
		
		beforeSend: function(){
			$("#loading").show();
		},
		
		success: function(msg){
			$("#loading").hide();
			$("body").css({'backgroundColor':'#fff'});
			$("#box").hide();
			$("#container").css({'opacity':'1','zIndex':'10000'});	
			$("#cart p img.loadbrief").show();
			$("#cart span.item").html(msg.item);
			$("#cart span.price").html(msg.price);
			$("#cart p img.loadbrief").hide();
		}
		
	});

}

function deleteItem(id){

	$.ajax({
		type: 'GET',
		url: 'ajax.php',
		data: 'action=edit&way=delete&id=' + id,
		dataType: 'html',
		
		beforeSend: function(){
			$("#progress"+id).fadeIn("fast");
		},
		
		success: function(msg){
			$("#progress"+id).fadeOut("slow");	
			$("#box").html(msg);
			setOverflowCart($("#cart_detail").height());
		}
	});
	
}

function sort(way){
	var method = '';
	if($.cookie("flag") == 1){
	
		method = '<';
		$.cookie("flag", 0, { expires: 7 });
	}
	else{
	
		method = '>';
		$.cookie("flag", 1, { expires: 7 });
	}
	
	$.ajax({
		type: 'GET',
		url: 'ajax.php',
		data: 'action=edit&way='+way+'&method='+method,
		dataType: 'html',
		
		beforeSend: function(){
			$("#waiting").css({'zIndex':'800000'}).show();
		},
		
		success: function(msg){
			$("#waiting").css({'zIndex':'-1'}).hide();
			$("#box").html(msg);
			setOverflowCart($("#cart_detail").height());		
		}
	});
}

function sortByName(){
	sort('sortbyname');
}

function sortByQt(){
	sort('sortbyqt');
}

function sortByPrice(){
	sort('sortbyprice');
}

function change(value, id, price){
	var total = value * price;
	$("span#prod_id_"+id).html('$'+total);
}

function update(){

		var list = $.cookie("item").split(',');
		var s = '';
		list = unique(list);
		
		for(x in list){
			if(s == '')
				s = list[x] + '=>' + $("#cart_detail input#qt"+list[x]).val();
			else
				s += ',' + list[x] + '=>' + $("#cart_detail input#qt"+list[x]).val();
		}
		
		$.ajax({
			type: 'GET',
			url: 'ajax.php',
			data: 'action=edit&way=update&list='+s,
			dataType: 'html',
			
			beforeSend: function(){
				$("#waiting").css({'zIndex':'800000'}).show();
			},
			
			success: function(msg){
				$("#waiting").css({'zIndex':'-1'}).hide();
				$("#box").html(msg);
				setOverflowCart($("#cart_detail").height());
				
			}
		});
	
}
