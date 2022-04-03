<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Jade Delight</title>
	<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
	<style>
	
		*{
		/* background-color: #cfebca; */
		text-align: center;
		}
		table{
		margin-left: auto;
		margin-right: auto;
		}
		input{
		border: 1px solid #000000;
		background-color: white

		}
		.button:hover{
		background-color: #ACA6A6;
		}
		h1 {
			color: #5f8343; 
		}
		
	</style>
</head>

<body>
    <script>
        dish_arr = [];
        cost_arr = [];
    </script>

<?php
	
	//establish connection info
    $server = "localhost";// your server
    $userid = "ugpysaiklbajq"; // your user id
    $pw = "6.i1#hp>jx2g"; // your pw
    $db= "db68tdck2kefne"; // your database

    // Create connection
    $conn = new mysqli($server, $userid, $pw );

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    ?>
    <script>

    console.log("Connected successfully");
    </script>

    <?php
    //select the database
    $conn->select_db($db);

        //run a query
    // select from name of table

    // $sql = "SELECT first_name, last_name FROM users";
    // $result = $conn->query($sql);

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    //get results
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            
            $temp_dish = $row["dish"];
            $temp_cost = $row["cost"];
            echo "<script>dish_arr.push('$temp_dish'); cost_arr.push('$temp_cost');</script>";
        }
    }
        
    //close the connection	
    $conn->close();

	
?>


<script>

    for (i = 0; i < dish_arr.length; i++) {

        cost_arr[i] = parseFloat(cost_arr[i]);
        console.log(typeof dish_arr[i]);
        console.log(typeof cost_arr[i]);
        console.log("dish: " + dish_arr[i] + "\n" + "cost: " + cost_arr[i]);
    }
    

// set a menu item
function MenuItem(name, cost)
{
	this.name = name;
	this.cost=cost;
}

// create menu
menuItems = new Array(
	new MenuItem(dish_arr[0], cost_arr[0]),
	new MenuItem(dish_arr[1], cost_arr[1]),
	new MenuItem(dish_arr[2], cost_arr[2]),
	new MenuItem(dish_arr[3], cost_arr[3]),
	new MenuItem(dish_arr[4], cost_arr[4])
);

// make select options for select item
function makeSelect(name, minRange, maxRange)
{
	var t= "";
	t = "<select name='" + name + "' size='1' onchange='fixTotals()'>";
	for (j=minRange; j<=maxRange; j++)
	   t += "<option>" + j + "</option>";
	t+= "</select>"; 
	return t;
}

// get <td> for table
function td(content, className="")
{
	return "<td class = '" + className + "'>" + content + "</td>";
}
	
</script>

<h1>Jade Delight</h1>



<!-- get user input data -->
<form name="data" method="get" action="reciept.php" onsubmit="validate()">

	<p class="userInfo"><label>First Name:</label> <input type="text"  name='fname' /></p>
	<p class="userInfo" id="lname"><label>Last Name*</label>:  <input
	type="text"  name='lname' /></p>
	

	
	<p class="userInfo address"><label id="street-label">Street*:</label> <input type="text" name='street' id="street"/></p>
	<p class="userInfo address"><label id="city-label">City*:</label> <input type="text" name='city' id="city"/></p>
	<p class="userInfo"><label>Phone*</label>: <input type="text"  name='phone' /></p>
	<p> 
		<input type="radio"  name="p_or_d" value = "pickup" id="pickup" checked="checked"/>Pickup  
		<input type="radio"  name='p_or_d' value = 'delivery' id="delivery"/>
		Delivery
	</p>

<table border="0" cellpadding="3">
  <tr>
    <th>Select Item</th>
    <th>Item Name</th>
    <th>Cost Each</th>
    <th>Total Cost</th>
  </tr>
<script>
	

	// default is pickup so default is to hide these
	$("#city").hide();
	$("#city-label").hide();
	$("#street").hide();
	$("#street-label").hide();

	// if pickup is clicked, hide
	$("#pickup").click(function(){
		$("#city").hide();
		$("#city-label").hide();
		$("#street").hide();
		$("#street-label").hide();
	});
	// if delivery is clicked, show
	$("#delivery").click(function(){
		$("#city").show();
		$("#city-label").show();
		$("#street").show();
		$("#street-label").show();

	});

	// populate table
  var s = "";
  for (i=0; i< menuItems.length; i++)
  {
	  s += "<tr>";
	  s += td(makeSelect("quan" + i, 0, 10),"selectQuantity");
	  s += td(menuItems[i].name, "itemName");
	  s += td("$" +menuItems[i].cost.toFixed(2), "cost");
	  s += td("$<input type='text' name='cost'/>", "totalCost");
	  s+= "</tr>";
  }
  document.writeln(s);

  // set values to 0 for looks
  $("[name=cost").eq("0").val(0);
  $("[name=cost]").eq("1").val(0);
  $("[name=cost]").eq("2").val(0);
  $("[name=cost]").eq("3").val(0);
  $("[name=cost]").eq("4").val(0);

  // check order not empty
	function validateOrder(subtotal) {

		if($("[name=quan0]").val()==0 &&
			$("[name=quan1]").val()==0 &&
			$("[name=quan2]").val()==0 &&
			$("[name=quan3]").val()==0 &&
			$("[name=quan4]").val()==0) {
			return false;
		}
		else {
			return true;
		}
}


  // update total according to amount, make subtotal, tax, total
  function fixTotals() {
	  subtotal = 0;
	
	  // update total cost per number of items
	for (i = 0; i < menuItems.length; i++) {
	  select_value = document.getElementsByName("quan" + i)[0].value;
	  items_cost = parseInt(select_value) * menuItems[i].cost.toFixed(2);
	  subtotal += items_cost;
	  document.getElementsByName("cost")[i].value = items_cost;
  	}

	  // update subtotal, tax, total
	  $("#subtotal").val(subtotal);
	  tax = subtotal * (0.0625);
	  $("#tax").val(tax.toFixed(2));
	  total = subtotal + tax;
	  $("#total").val(total.toFixed(2));

	  return validateOrder(subtotal);
  }


  function calcOrder() {

	  console.log("in calcOrder\n");

		order = getOrder();

		var hour, min;
    	date = new Date();
    	hour = date.getHours();
		if (document.data.p_or_d[0].checked){
			if (date.getMinutes()>44){
				hour += 1;
				min = (date.getMinutes()+15) - 60;
			}
			else{
				min = date.getMinutes() + 15;
			}
		}
		else{
			if (date.getMinutes()>29){
				hour += 1;
				min = (date.getMinutes()+30) - 60;
			}
			else{
				min = date.getMinutes() + 30;
			}
		}

        $("#hour").val(hour);
        $("#minutes").val(min);
        $("#order").val(order);

		// var myWindow=window.open("");
		
		// receipt = ("Thank you for ordering:<br>" + order + ".<br>It will be ready at " + hour + ":" + min + ".<br>Subtotal: $" + subtotal.toFixed(2) + "<br>Tax: $" + tax.toFixed(2) + "<br>Total: $" + total.toFixed(2));

		// myWindow.document.write(receipt);

		// myWindow.focus();

	}
  

  function validate() {
	
	last_name = document.data.lname.value;
	phone = document.data.phone;
	match_phone = /^(([0-9]{7})|([0-9]{10}))$/;
	// match_phone7 = /^\d{7}$/;

	console.log(phone.length);

	error = false;
	with (document.data) {
		if (!phone.value.match(match_phone)) {
			alert("Phone number invalid.");
			error = true;
		}
		if (document.data.p_or_d[1].checked) {
			if (city.value == "") {
				alert("Please enter a city.");
				document.data.city.select();
				error = true;
			}
			if (street.value == "") {
				alert("Please enter a street.");
				document.data.street.select();
				error = true;
			}
		}
		if (last_name == "") {
			alert("Please enter a last name.");
			document.data.lname.select();
			error = true;
		}
		if (!validateOrder()) {
			alert("Order must not be empty.");
			error = true;
		}
		if (!error) {
			calcOrder();
		}
	}
	return error;

}

function getOrder() {
	console.log("in getOrder\n");
		order = "";
		for (i = 0; i < menuItems.length; i++) {
			select_value = document.getElementsByName("quan" + i)[0].value;
			if(select_value != 0) {
				order += menuItems[i].name + ": " + select_value + " ";
			}
		}
		return order;
}

	
</script>
</table>
<!-- final costs -->
<p class="subtotal totalSection"><label>Subtotal</label>: 
   $ <input type="text"  name='subtotal' id="subtotal" />
</p>
<p class="tax totalSection"><label>Mass tax 6.25%:</label>
  $ <input type="text"  name='tax' id="tax" />
</p>
<p class="total totalSection"><label>Total:</label> $ <input type="text"  name='total' id="total" />
</p>

<input type="hidden" name='hour' id="hour"/>
<input type="hidden" name='minutes' id="minutes"/>
<input type="hidden" name='order' id="order"/>

<input type = "submit" value = "Submit Order"  />

</form>
</body>
</html>