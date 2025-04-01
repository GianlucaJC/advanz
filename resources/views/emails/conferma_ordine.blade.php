<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<?php
    $name=$info_order['name'];
    $material=$info_order['material'];
    $art_in_order=$info_order['art_in_order'];
    $delivery_date=$info_order['delivery_date'];
    $estim=$info_order['estim'];
?>
<body>
<p>Dear {{$name}},</p><br>
<p>Thank you for your order!</p><br>
<p>Order details:</p><br>
<hr>
<p>Item(s):
<?php

        echo "<br>";
        echo "<ul>";
            for ($sca=0;$sca<count($material);$sca++) {
                $articolo=$material[$sca];
                if (strlen($articolo)==0) continue;
                echo "<li>";
                    if (isset($art_in_order[$articolo]['descr_molecola']))
                        echo $art_in_order[$articolo]['descr_molecola'];
                    if (isset($art_in_order[$articolo]['descr_pack']))
                        echo " - ".$art_in_order[$articolo]['descr_pack'];
                    if (isset($art_in_order[$articolo]['descr_qty']))
                        echo " - ".$art_in_order[$articolo]['descr_qty'];
                echo "</li>";
            }    
        echo "</ul>";

?>
</p>

Delivery Address: [HCP’s address]<br><br>

Estimated Delivery Date: <b>{{$estim}}</b><br><br>

Your order is now being processed and we will ensure its prompt preparation. You will receive a notification once your order has been shipped.<br><br>
Sincerely,<br><br>
The ADVANZ PHARMA ASTIP team
</body>
</html>
