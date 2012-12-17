/*** reduce string ***/
function reduce_str(string, limit){

    if(string.length < limit) return string;

    var html = string.substr(0, limit);
    html = html.substr(0, html.lastIndexOf(" "));

    return html+"...";

}

/*** transform price ***/
function transform_price(number){

    if(number < 1000) return number;

    number = number.toString();

    var new_str = "";
    var count = 0;
    var flag = false;

    for(var i = number.length; i >= 0 ; i--){
        new_str +=  number.charAt(i);

        if(count % 3 == 0 && i < number.length && flag == false)
            new_str += ",";

        count ++;

        if(count == number.length)
            flag = true;

    }

    var result = "";
    for(var j = new_str.length; j >= 0 ; j--){

        result += new_str.charAt(j);

    }

    return result;
    
}

// set height for cart to avoid the overflow of modal cart
function setOverflowCart(height){
		
	if(height > 450){
		$("#cart_detail").css({'overflow':'auto','height':'453px','width':'617px'});
	}
	else{
		$("#cart_detail").css({'overflow':'visible'});
	}
}

// return a unique array
function unique(arr){
   var r = new Array();
   o:for(var i = 0, n = arr.length; i < n; i++)
   {
      for(var x = 0, y = r.length; x < y; x++)
      {
         if(r[x]==arr[i]) continue o;
      }
      r[r.length] = arr[i];
   }
   return r;
}



