<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<?php
    $first_name=$info_order['first_name'];
    $last_name=$info_order['last_name'];
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

                echo "</li>";
            }    
        echo "</ul>";

?>
</p>

<?php
    $istituto=$info_order['istituto'];
    $shipping_address1=$info_order['shipping_address1'];
    $shipping_address2=$info_order['shipping_address2'];
    $state=$info_order['state'];
    $city=$info_order['city'];
    $postal_code=$info_order['postal_code'];
    $address=$istituto;
    if (strlen($shipping_address1)!=0) $address.=", $shipping_address1";
    if (strlen($shipping_address2)!=0) $address.=", $shipping_address2";
    if (strlen($state)!=0) $address.=", $state";
    if (strlen($city)!=0) $address.=", $city";
    if (strlen($postal_code)!=0) $address.=", $postal_code";



?>
Name: {{$first_name}} {{$last_name}}<br>
Delivery Address: {{$address}}<br><br>

Estimated Delivery Date: <b>{{$estim}}</b><br><br>

Your order is now being processed and we will ensure its prompt preparation. You will receive a notification once your order has been shipped.<br><br>
Sincerely,<br><br>
The ADVANZ PHARMA ASTIP team
</body>
</html>
