<?php
    include "../conexao/conexaoDB.inc";
    if(isset($_GET["nivelChuva"]) && isset($_GET["sensorChuva"]) && 
       isset($_GET["nivelSolo"]) && isset($_GET["sensorSolo"]) && 
       isset($_GET["nivelReservatorio"]) && isset($_GET["sensorReservatorio"]) &&
       isset($_GET["estadoBomba"]))
    
    {
        $nivelChuva=$_GET["nivelChuva"];
        $sensorChuva=$_GET["sensorChuva"];
        $nivelSolo=$_GET["nivelSolo"];
        $sensorSolo=$_GET["sensorSolo"];
        $nivelReservatorio=$_GET["nivelReservatorio"];
        $sensorReservatorio=$_GET["sensorReservatorio"];
        $estadoBomba=$_GET["estadoBomba"];
        $salvar=$_GET["salvar"];

        if($salvar=="1")
        {
            $query= "insert into tbl_dados_sensores VALUES (DEFAULT, '$nivelChuva', '$sensorChuva', '$nivelSolo', '$sensorSolo', '$nivelReservatorio', '$sensorReservatorio', '$estadoBomba', now() )";
            if(mysqli_query($conexao, $query))
            {
                echo "Novo registro inserido!";
            }
            else
                echo "Error:" . $query."<br/>". mysqli_error($conexao);
        }
        else
        {
            $query= "UPDATE tbl_dados_sensores set nivel_chuva='$nivelChuva', sensor_chuva='$sensorChuva', nivel_solo='$nivelSolo', sensor_solo='$sensorSolo', nivel_reservatorio='$nivelReservatorio', sensor_reservatorio='$sensorReservatorio', estado_bomba='$estadoBomba' where id=18;";
            if(mysqli_query($conexao, $query))
                echo "Update feito!";
            else 
                echo "Update falhou!";
        }        
    }
    mysqli_close($conexao);
?>