<!doctype html>
<html lang="pt-pt" data-bs-theme="auto">
  <head>
      
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Diassonama">
      <meta name="generator" content="Otlevire">
      <title>Plantação - Login</title>
      
      <link href="./estilos/bootstrap.min.css" rel="stylesheet">
      <link href="./estilos/sign-in.css" rel="stylesheet">
      <script src="ip.js"></script>
      <script src="./scripts/bibliotecas/jquery.js"></script>
      <script src="./scripts/bibliotecas/bootstrap.bundle.min.js"></script>
  </head>

  <body class="text-center bg-dark">    
    <main class="form-signin w-100 m-auto">
    <form method="POST" action="./conexao/validarLogin.php">
        <img class="mb-4" src="./imagens/iconeLogin.png" alt="" width="72" height="57">
        <h1 class="text-light h3 mb-3 fw-normal">Bem Vindo ao <strong>Controle da sua Plantação</strong></h1>

        <div class="form-floating mb-4">
        <input type="email" class="form-control" name="email" id="email" placeholder="Seu Email">
        </div>
        <div class="form-floating ">
        <input type="password" class="form-control" name="senha" id="senha" placeholder="Sua Senha">
        </div>

        <div class="checkbox mb-3">
        <label>
        </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" id="botaoEntrar">Entrar</button>
    </form>
    </main>    
  </body>
</html>
