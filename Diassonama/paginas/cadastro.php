<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro</title>
        <link rel="stylesheet" href="../estilos/bootstrap.min.css">
        <link rel="stylesheet" href="../estilos/cadastro.css">
        <script src="../ip.js"></script>
    </head>
    <body class="bg-dark">
       <div class="container contentor">
        <div class="heading">
            Cadastro
            <img class="mb-4" src="../imagens/iconeCadastro.png" alt="" width="72" height="57">
        </div>
        <form action="../conexao/validarCadastro.php" method = "POST" id="formCadastro" class="form">

            <div class="container card-details">
                <div class="container card-box">
                    <label class="details">Primeiro Nome</label>
                    <input type="text" placeholder="Primeiro nome" name ="primeiroNome" id="primeiroNome" required>
                </div>
                
                <div class="container card-box">
                    <label class="details">Ultimo Nome</label>
                    <input type="text" placeholder="Ultimo nome" name ="ultimoNome"  id="ultimoNome" required>
                </div>
                 
                <div class="container card-box">
                    <label class="details">Email do Usuário</label>
                    <input type="email" placeholder="Digite o Email" name ="email" id="email" required>
                </div>
                <div class="container card-box">
                    <label class="details">Telefone </label>
                    <input type="phone" placeholder="Digite o Número Telefone" name ="telefone" id="telefone" required>
                </div>
                <div class="container card-box">
                    <label class="details">Senha</label>
                    <input type="password" placeholder="Digite a senha de Usúario" name ="senha1" id="senha1" required>
                </div>
                <div class="container card-box">
                    <label class="details">Confirmação de Senha </label>
                    <input type="password" placeholder="Confirme a senha de Usúario" name="senha2" id="senha2" required>
                </div>
                
                <div class="container card-box"></div>

                <div class="container form-check circal-form ">
                    <label class="circal-title">Gênero</label>
                    <div class="category">
                        <input  type="radio" name="genero" id="radioGenero"  value="Masculino" checked>Masculino
                        <input type="radio" name="genero" id="radioGenero" value="Feminino" >Feminino
                    </div>
                </div>

                <div class="container m-auto row">
                        <input   class="btn btn-success col"   value="Cadastrar"  id="botao" type="submit">
                </div>
                <a href="../index.php">Login</a>

            </div>    
        </form>
  

        
        <script src="../scripts/bootstrap.bundle.min.js"></script>
        <script src="../scripts/jquery.js"></script>
    </body>
</html>