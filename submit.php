<?php

    $dsn = 'mysql:host=localhost;dbname=php_com_pdo';
    $usuario = 'root';
    $senha = '';
    $conexao = new PDO($dsn, $usuario, $senha);
    
    if(!empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['password']))
    {
        $query = "
            SELECT email FROM tb_usuarios WHERE email = :email
        ";
        $resul = $conexao->prepare($query);

        $resul->bindValue(':email' , $_POST['email']);

        $resul->execute();

        $resul = $resul->fetch(PDO::FETCH_ASSOC);

        if(empty($resul['email']))
        {
            $insert = "
                INSERT INTO tb_usuarios(nome, email, senha)
                VALUES
                (:name, :email, :password)
            ";

            $var = $conexao->prepare($insert);

            $var->bindValue(':email' , $_POST['email']);
            $var->bindValue(':name' , $_POST['name']);
            $var->bindValue(':password' , $_POST['password']);

            $var->execute();

            
            $verificador = 'Email Cadastrado com sucesso!';

        }
        else{
            $verificador = 'Email ja Cadastrado';
        }
    }

?>

<html>
    <head>
    <meta charset="UTF-8">
    <title>Login</title>
    </head>
    <body>
        
        <?php
            echo $verificador;
            echo '<br>';
        ?>

        <span><a href="index.php">BACK</a></span>

    </body>
</html>