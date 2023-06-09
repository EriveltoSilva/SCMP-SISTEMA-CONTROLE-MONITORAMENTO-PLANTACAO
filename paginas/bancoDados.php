<!DOCTYPE html>
<html lang="pt-pt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Otlevire">
		<meta name="generator" content="Hugo 0.111.3">
		<title>Plantação · Banco de Dados</title> 
		<!-- Boxicons -->
		<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" href="../estilos/bootstrap.min.css">
		<link rel="stylesheet" href="../estilos/principal.css">

		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
		<script src="../scripts/bibliotecas/bootstrap.bundle.min.js"></script>
	</head>
	<body >

		<!-- SIDEBAR -->
		<section id="sidebar">
			<a href="principal.php" class="brand">
				<i class='bx bxs-smile'></i>
				<span class="text">Plantação</span>
			</a>
			<ul class="side-menu top">
				<li>
					<a href="./cadastro.php">
						<i class='bx bxs-group' ></i>
						<span class="text">Cadastro</span>
					</a>
				</li>
				<li>
					<a href="principal.php">
						<i class='bx bx-home'></i>
						<span class="text">Dashboard</span>
					</a>
				</li>
				<li class="active">
					<a href="bancoDados.php">
						<i class='bx bx-table' ></i>
						<span class="text">Banco de Dados</span>
					</a>
				</li>
			</ul>
			<ul class="side-menu">
				<li>
					<a href="../index.php" class="logout">
						<i class='bx bxs-log-out-circle' ></i>
						<span class="text">Logout</span>
					</a>
				</li>
			</ul>
		</section>
		<!-- SIDEBAR -->


		<!-- CONTENT -->
		<section id="content">
			<!-- NAVBAR -->
			<nav>
				<i class='bx bx-menu' ></i>
				<a href="#" class="nav-link"></a>
				<form action="#" style="display:none;">
					<div class="form-input">
						<input type="search" placeholder="Search...">
						<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
					</div>
				</form>
				<input type="checkbox" id="switch-mode" hidden>
				<label for="switch-mode" class="switch-mode"></label>
				<a href="./bancoDados.php" class="notification">
					<i class='bx bxs-bell' ></i>
					<span class="num" id=></span>
				</a>
				<a href="#" class="profile">
					<img src="../imagens/iconeLogin.png">
				</a>
			</nav>
			<!-- NAVBAR -->

			<!-- MAIN -->
			<main>
				<div class="head-title">
					<div class="left">
						<h2>Banco de Dados da Plantação</h2>
						<ul class="breadcrumb">
							<li>
								<a href="principal.php">Plantação</a>
							</li>
							<li><i class='bx bx-chevron-right' ></i></li>
							<li>
								<a class="active" href="bancoDados.php">BD</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- Example single danger button -->
				<div class="btn-group">
					<button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					Selecione o BD que Deseja...
					</button>
					<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="bancoDados.php?sensor=chuva">Dados do S.Chuva</a></li>
					<li><a class="dropdown-item" href="bancoDados.php?sensor=solo">Dados do S.Solo</a></li>
					<li><a class="dropdown-item" href="bancoDados.php?sensor=reservatorio">Dados do Reservatório</a></li>
					<li><a class="dropdown-item" href="bancoDados.php?sensor=bomba">Dados da Bomba</a></li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="bancoDados.php?sensor=geral">Geral</a></li>
					</ul>
				</div>
  

				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Dados Armazenados</h3>
						</div>
						

						<table>
							<thead>
							<?php
							
								if(isset($_GET["sensor"]))
								{
									$sensor= $_GET["sensor"];
									$query="";
									$tipo ='z';
									echo "<th>NºRegistro</th>";
									if($sensor=="chuva")
									{
										$tipo ='c';
										$query = "select id, nivel_chuva, sensor_chuva, data from tbl_dados_sensores;";
										echo "<th>N.Chuva</th>";
										echo "<th>V. Sen Chuva</th>";
									}
									if($sensor=="solo")
									{
										$tipo ='s';
										$query = "select id, nivel_solo, sensor_solo, data from tbl_dados_sensores;";
										echo "<th>N.Solo</th>";
										echo "<th>V. Sen Solo</th>";
									}
									if($sensor=="reservatorio")
									{
										$tipo ='r';
										$query = "select id, nivel_reservatorio, sensor_reservatorio, data from tbl_dados_sensores;";
										echo "<th>N. Reservatório</th>";
										echo "<th>V. Sen Reservatório</th>";
									}

									if($sensor=="bomba")
									{
										$tipo ='b';
										$query = "select id, estado_bomba, data from tbl_dados_sensores;";
										echo "<th>Estado Bomba</th>";
									}

									if($sensor=="geral")
									{
										$tipo ='g';
										$query = "select * from tbl_dados_sensores;";
										echo "<th>N.Chuva</th>";
										echo "<th>V. Sen Chuva</th>";
										echo "<th>N.Solo</th>";
										echo "<th>V. Sen Solo</th>";
										echo "<th>N. Reservatório</th>";
										echo "<th>V. Sen Reservatório</th>";
										echo "<th>Estado Bomba</th>";
									}
									echo "<th>Data e Hora</th>";

								
									
							?>
							</thead>
							<tbody>
								<?php
									
									
									function query_chuva($query)
									{
										include "../conexao/conexaoDB.inc";

										$resultado=mysqli_query($conexao, $query);
										while($linha= mysqli_fetch_row($resultado))
										{
											$id= $linha[0];
											$nivel_chuva= $linha[1];
											$sensor_chuva= $linha[2];
											$data=$linha[3];
											echo "<tr>";
												echo "<td>$id</td>";
												echo "<td>$nivel_chuva</td>";
												echo "<td>$sensor_chuva</td>";
												echo "<td>$data</td>";
											echo "</tr>";
										}
										mysqli_close($conexao);
									}
									function query_solo($query)
									{
										include "../conexao/conexaoDB.inc";

										$resultado=mysqli_query($conexao, $query);
										while($linha= mysqli_fetch_row($resultado))
										{
											$id= $linha[0];
											$nivel_solo= $linha[1];
											$sensor_solo= $linha[2];
											$data=$linha[3];
											echo "<tr>";
												echo "<td>$id</td>";
												echo "<td>$nivel_solo</td>";
												echo "<td>$sensor_solo</td>";
												echo "<td>$data</td>";
											echo "</tr>";
										}
										mysqli_close($conexao);
									}
									function query_reservatorio($query)
									{
										include "../conexao/conexaoDB.inc";

										$resultado=mysqli_query($conexao, $query);
										while($linha= mysqli_fetch_row($resultado))
										{
											$id= $linha[0];
											$nivel_reservatorio= $linha[1];
											$sensor_reservatorio= $linha[2];
											$data=$linha[3];
											echo "<tr>";
												echo "<td>$id</td>";
												echo "<td>$nivel_reservatorio</td>";
												echo "<td>$sensor_reservatorio</td>";
												echo "<td>$data</td>";
											echo "</tr>";
										}
										mysqli_close($conexao);
									}
									function query_bomba($query)
									{
										include "../conexao/conexaoDB.inc";

										$resultado=mysqli_query($conexao, $query);
										while($linha= mysqli_fetch_row($resultado))
										{
											echo "<tr>";
												$id= $linha[0];
												$estado_bomba= $linha[1];
												$data=$linha[2];
												echo "<td>$id</td>";
												echo "<td>$estado_bomba</td>";
												echo "<td>$data</td>";
											echo "</tr>";
										}
										mysqli_close($conexao);
									}
									function query_geral($query)
									{
										include "../conexao/conexaoDB.inc";

										$resultado=mysqli_query($conexao, $query);
										while($linha= mysqli_fetch_row($resultado))
										{
											$id= $linha[0];
											$nivel_chuva= $linha[1];
											$sensor_chuva= $linha[2];
											$nivel_solo= $linha[3];
											$sensor_solo= $linha[4];
											$nivel_reservatorio= $linha[5];
											$sensor_reservatorio= $linha[6];
											$bomba=$linha[7];
											$data=$linha[8];
											echo "<tr>";
												echo "<td>$id</td>";
												echo "<td>$nivel_chuva</td>";
												echo "<td>$sensor_chuva</td>";
												echo "<td>$nivel_solo</td>";
												echo "<td>$sensor_solo</td>";
												echo "<td>$nivel_reservatorio</td>";
												echo "<td>$sensor_reservatorio</td>";
												echo "<td>$bomba</td>";
												echo "<td>$data</td>";
											echo "</tr>";
										}
										mysqli_close($conexao);
									}
									
									if($tipo=='c')
										query_chuva($query);
									else if($tipo=='s')
										query_solo($query);
									else if($tipo=='r')
										query_reservatorio($query);
									else if($tipo=='b')
										query_bomba($query);
									else if($tipo=='g')
										query_geral($query);
								}
								?>
							</tbody>
						</table>
					</div>

				</div>
			</main>
			<!-- MAIN -->
		</section>
		<!-- CONTENT -->
		

		<script src="../scripts/principal.js"></script>
		<script src="../scripts/bibliotecas/jquery.js"></script>
		
	</body>
</html>
