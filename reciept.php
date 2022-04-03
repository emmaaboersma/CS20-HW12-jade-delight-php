

<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Receipt</title>
	<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
</head>
<body>
    <h1 style="color: #5f8343; text-align: center;">Jade Delight</h1>

    <?php

    $order = $_GET["order"];
    $hour = $_GET["hour"];
    $min = $_GET["minutes"];

    $subtotal = $_GET["subtotal"];
    $tax = $_GET["tax"];
    $total = $_GET["total"];

    $pd = "";

    $street = $_GET["street"];
    $city = $_GET["city"];

    if ($street == "" && $city == "") {
        $pd .= "Pickup at $hour:$min.";
    } else {
        $pd .= "Food will be delivered to $street, $city shortly.";
    }

    echo "Thank you for ordering:<br>$order.<br><br>" . $pd . "<br><br>Subtotal: $$subtotal<br>Tax: $$tax<br>Total: $$total";

    $email = "example@aol.edu";
    $body = "Thank you for the order.\nTotal: $total\n";
    mail($email, "Thank you for ordering from Jade Delight!", $body . $pd . "\n");

    ?>
</body>
