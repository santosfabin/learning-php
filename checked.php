<?php

    $dsn = 'mysql:host=localhost;dbname=php_com_pdo';
    $usuario = 'root';
    $senha = '';
    $conexao = new PDO($dsn, $usuario, $senha);

    if(!empty($_POST['email']) AND !empty($_POST['password']))
    {

        $query = "
            SELECT * FROM tb_usuarios WHERE email = :email AND senha = :pwd
        ";
        $email = "
            SELECT * FROM tb_usuarios WHERE email = :email
        ";
        $prepareEmail = $conexao->prepare($email);
        
        $prepareEmail->bindValue(':email', $_POST['email']);

        $prepareEmail->execute();

        $resulEmail = $prepareEmail->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->prepare($query);

        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':pwd', $_POST['password']);

        $stmt->execute();

        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = $resul['nome'];

        if($resul)
        {
            header("Location: page$nome.php");
        }
        else if(empty($resulEmail['email']))
        {
            header('Location: createAccount.php');
        }
        else
        {
            header('Location: index.php?passwordFailed');
        }
    }
    else
    {
        header('Location: index.php?completTheAcess');
    }