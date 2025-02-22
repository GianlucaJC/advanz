<!DOCTYPE html>
<html>
<head>
    <title>Request contact</title>
</head>

<body>
    <h1>{{$dati['body_title']}}</h1>

        @foreach($dati as $dato=>$value) 
            <?php
                
                $dato=str_replace("txtInstitution","Institution Name",$dato);
                $dato=str_replace("txtName","Full Name",$dato);
                $dato=str_replace("txtPhone","Phone Number",$dato);
                $dato=str_replace("txtEmail","Email",$dato);
                $dato=str_replace("ddlTopic","Topic",$dato);
                $dato=str_replace("txtMessage","Message",$dato);
            
            ?>

            @if ($dato!='body_title')  {{$dato}}: <b>{{$value}}</b><br> @endif
        @endforeach
    
</body>
</html>
