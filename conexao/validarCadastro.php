<?php
    include "conexaoDB.inc";
    if(isset($_POST['primeiroNome']) && isset($_POST['ultimoNome']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['senha1']) && isset($_POST['senha1']) && isset($_POST['genero']))
    {
        $primeiroNome=$_POST['primeiroNome'];
        $ultimoNome=$_POST['ultimoNome'];
        $email= $_POST['email'];
        $telefone=$_POST['telefone'];
        $senha1=$_POST['senha1'];
        $senha2=$_POST['senha2'];
        $genero = $_POST['genero'];
        if(!validar($primeiroNome, $ultimoNome, $email, $telefone, $senha1, $senha2))
            echo "<script>window.location.assign('../paginas/cadastro.php');</script>";
        else{
            //Inserção na tabela
            $query = "insert into tbl_usuario VALUES (DEFAULT, '$primeiroNome', '$ultimoNome', '$email', '$telefone', '$genero', '$senha1')";
            $resultado = mysqli_query($conexao, $query);
            if(($num = mysqli_affected_rows($conexao))>0)
            {
                echo"<script> alert('Usuario Cadastrado com Sucesso!');</script>";
                echo "<script>window.location.assign('../index.php');</script>";
            }
            else{
                echo"<script> alert('Erro inserindo os dados no DB!');</script>";
                echo "<script>window.location.assign('../paginas/cadastro.php');</script>";
            }
        }
    }
    

    function validar($primeiroNome,$ultimoNome,  $email,$telefone,$senha1,$senha2 )
    {
        if($primeiroNome == "")
        {
            echo"<script> alert('Digite o seu primeiro nome!');</script>";
            return false;
        } 
        else if($ultimoNome == "")
        {
            echo "<script> alert('Digite o seu ultimo nome!');</script>";
            return false;
        }
        else if($email=="")
        {
            echo "<script> alert('Digite o seu email!');</script>";
            return false;
        }
        else if($telefone=="")
        {
            echo "<script> alert('Digite o seu numero de telefone!');</script>";
            return false;
        }
        else if($senha1 ==""){
            echo "<script> alert('Digite a sua senha1');</script>";
            return false;
        }
        else if($senha2=="")
        {
            echo "<script> alert('Digite a sua senha2');</script>";
            return false;
        }
        else if($senha1!=$senha2)
        {
            echo "<script> alert('Digitou senhas diferentes!');</script>";
            return false;
        }
        return true;
    }

    mysqli_close($conexao);
?>