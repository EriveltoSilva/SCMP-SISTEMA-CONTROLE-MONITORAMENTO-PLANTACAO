<?php
	include "../conexao/conexaoDB.inc";

	$nivelChuva= "12";
	$sensorChuva= "13";
	$nivelSolo= "14";
	$sensorSolo= "15";
	$nivelReservatorio= "16";
	$sensorReservatorio= "17";
	$estadoBomba="18";
	

	$query = "select * from tbl_dados_sensores where id=18;";
	$resultado=mysqli_query($conexao, $query);
	while($linha= mysqli_fetch_row($resultado))
	{
		$nivelChuva= $linha[1];
		$sensorChuva= $linha[2];
		$nivelSolo= $linha[3];
		$sensorSolo= $linha[4];
		$nivelReservatorio= $linha[5];
		$sensorReservatorio= $linha[6];
		$estadoBomba=$linha[7];
	}
	mysqli_close($conexao);
	
    if(isset($_GET["dados"]))    
        echo "BD*$nivelChuva*$sensorChuva*$nivelSolo*$sensorSolo*$nivelReservatorio*$sensorReservatorio*$estadoBomba*";
    
?>