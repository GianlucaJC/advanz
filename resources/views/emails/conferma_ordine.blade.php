<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<?php
    $name=$info_order['name'];
    $material=$info_order['material'];
    $delivery_date=$info_order['delivery_date'];
?>
<body>
<p>Dear {{$name}},</p>
<p>Thank you for your order!</p>
<p>Order details:</p>
<hr>
<p>Item(s):<br>
    <ul>
        <?php
        
        for ($sca=0;$sca<count($material);$sca++) {
            $articolo=$material[$sca];
            if (strlen($articolo)==0) continue;
            echo "<li>";
                echo $articolo;
            echo "</li>";
        }    
        ?>
    </ul>
</p>

Delivery Address: [HCP’s address]
Estimated Delivery Date: <b>+14 days from order date</b>
Your order is now being processed and we will ensure its prompt preparation. You will receive a notification once your order has been shipped.
Sincerely,
The ADVANZ PHARMA ASTIP team
</body>
</html>
