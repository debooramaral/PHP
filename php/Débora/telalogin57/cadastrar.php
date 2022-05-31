<?php
    require_once 'usuarios.php';
    $usuario = new Usuario();
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>CADASTRAR</title>
</head>
<body>
    <h1>CADASTRAR</h1>
    <div id="corpo_id_cad">
        <form method="post">
            <input type="text" name="nome" placeholder="NOME COMPLETO" maxlength="30">
            <input type="text" name="telefone" placeholder="TELEFONE" maxlength="10">
            <input type="email" name="email" placeholder="SEU E-MAIL" maxlength="50">
            <input type="password" name="senha" placeholder="SENHA" maxlength="15">
            <input type="password" name="confsenha" placeholder="CONFIRMAR SENHA" maxlength="15">
            <input type="submit" value="CADASTRAR">
        </form>
    </div>

    <?php
        if(isset($_POST['nome']))
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            $confirmarSenha = addslashes($_POST['confsenha']);

            //VERIFICAR SE TODOS OS CAMPOS ESTÃO PREENCHIDOS
            if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
            {
                //PRECISA SE CONECTAR COM O BANCO DE DADOS
                $usuario->conectar("tela_login_57", "localhost", "root", "");
                if($usuario->msgErro == "") //TUDO OK.. CONECTAMOS
                {
                    //VEJA SE AS DUAS SENHAS ESTÃO CERTAS
                    if($senha == $confirmarSenha)
                    {
                        if($usuario->cadastrar($nome, $telefone, $email, $senha))
                        {
                            ?>
                            <div id="msg-sucesso"><!--da pra fazer um alerta pelo JS-->
                                Cadastrado com Sucesso ☺
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div id="msg-sucesso"><!--da pra fazer um alerta pelo JS-->
                                Email já Cadastrado 
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                            <div id="msg-sucesso"><!--da pra fazer um alerta pelo JS-->
                                Senhas Invalidas, não correspondem
                            </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                        <div class="msg-sucesso"><!--da pra fazer um alerta pelo JS-->
                            <?php echo "Erro:".$usuario->msgErro?>
                        </div>
                    <?php
                }
            }
            else
            {
                ?>
                    <div id="msg-sucesso"><!--da pra fazer um alerta pelo JS-->
                        Preencha todos os campos.
                    </div>
                <?php
            }
        }
    
    ?>
</body>
</html>