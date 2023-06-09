

<!DOCTYPE html>
<html lang="pt-pt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Otlevire">
		<meta name="generator" content="Hugo 0.111.3">
		<title>Plantação · Menu Principal</title> 
		<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" href="../estilos/principal.css">
	</head>
	<body >

		<!-- SIDEBAR -->
		<section id="sidebar">
			<a href="#" class="brand">
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
				<li class="active">
					<a href="#">
						<i class='bx bx-home'></i>
						<span class="text">Dashboard</span>
					</a>
				</li>
				<li>
					<a href="./bancoDados.php">
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
				<a href="#" class="nav-link "></a>
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
					<span class="num" id=><?php=$numNotificacoes ?></span>
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
						<h2>Dashboard da Plantação</h2>
						<ul class="breadcrumb">
							<li>
								<a href="#">Plantação</a>
							</li>
							<li><i class='bx bx-chevron-right' ></i></li>
							<li>
								<a class="active" href="#">Home</a>
							</li>
						</ul>
					</div>
				</div>

				<ul class="box-info">
					
					<li>
						<img id="imagemChuva" src="../imagens/chuvaSEM_CHUVA.png" alt="">
						<span class="text">
							<h5 id="nivelChuva">---</h5>
							<p>Nível de Chuva</p>
						</span>
					</li>
					<li>
						<i class='bx bxs-calendar-check' ></i>
						<span class="text">
							<h3 id="sensorChuva">---</h3>
							<p>Sensor de Chuva</p>
						</span>
					</li>
					<li>
						<img src="../imagens/imagemSolo.jpg" alt="">
						<span class="text">
							<h5 id="nivelSolo">---</h5>
							<p>Nível de Solo</p>
						</span>
					</li>
					<li>
						<i class='bx bxs-calendar-check' ></i>
						<span class="text">
							<h3 id="sensorSolo">---</h3>
							<p>Sensor de Solo</p>
						</span>
					</li>

					<li>
						<img id="imagemReservatorio" src="../imagens/reservatorioBaixo.png" alt="">
						<span class="text">
							<h5 id="nivelReservatorio">---</h5>
							<p>Nível de Reservatório</p>
						</span>
					</li>
					<li>
						<i class='bx bxs-calendar-check' ></i>
						<span class="text">
							<h3 id="sensorReservatorio">---</h3>
							<p>Sensor de Reservatório</p>
						</span>
					</li>
					<li>
						<img id="imagemBomba" src="../imagens/bomba.jpeg" alt="">
						<span class="text">
							<h5 id="estadoBomba">---</h5>
							<p>Estado da Bomba</p>
						</span>
					</li>
				</ul>

	
				<div class="table-data">
					<div class="todo">
						<img src="../imagens/plantacao.jpg" alt="">
					</div>
				</div>
			</main>
			<!-- MAIN -->
		</section>
		<!-- CONTENT -->
		
		<script src="../scripts/bibliotecas/jquery.js"></script>
		<script src="../scripts/principal.js"></script>

		<script>
			let timer;
			$(document).ready(function () {
				setInterval(() => {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							let dadosRecebidos = this.responseText.split('*');
							document.getElementById("nivelChuva").innerHTML=dadosRecebidos[1];
							document.getElementById("sensorChuva").innerHTML=dadosRecebidos[2];
							document.getElementById("nivelSolo").innerHTML=dadosRecebidos[3];
							document.getElementById("sensorSolo").innerHTML=dadosRecebidos[4];
							document.getElementById("nivelReservatorio").innerHTML=dadosRecebidos[5];
							document.getElementById("sensorReservatorio").innerHTML=dadosRecebidos[6];
							document.getElementById("estadoBomba").innerHTML=dadosRecebidos[7];
							//console.log(dadosRecebidos);
							setImagemChuva(dadosRecebidos[1]);
							setImagemReservatorio(dadosRecebidos[5]);
							setImagemBomba(dadosRecebidos[7]);
						}
					}
					xmlhttp.open("GET", "../paginas/getDados.php?dados=", true);
					xmlhttp.send();
				}, 700);
			});

			function setImagemChuva(texto) {
				if(texto=="SEM_C")
					document.getElementById("imagemBomba").src ="../imagens/chuva"+texto+".png";
				else
					document.getElementById("imagemBomba").src ="../imagens/chuvaCaindo.gif";
			}
			function setImagemBomba(texto) {
				document.getElementById("imagemBomba").src ="../imagens/bomba"+texto+".png";
			}
			function setImagemReservatorio(texto) {
				document.getElementById("imagemReservatorio").src ="../imagens/reservatorio"+texto+".png";
			}
		</script>
	</body>
</html>