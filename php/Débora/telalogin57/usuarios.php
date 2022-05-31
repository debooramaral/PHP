<?php
class Usuario 
{
    /*declarando variaveis*/
    private $pdo;
    public $msgErro = "";

    /*função de conexão*/
    public function conectar($nome, $host, $usuario, $senha)
    {
        /*tela_login_57, localhost, root, vazio*/
        
        /*variaveis global*/
        global $pdo;

        try{ /*se tiver certo*/
            $pdo = new PDO("mysql:dbname=".$nome, $usuario, $senha);
        } catch(PDOException $e){ /*se não tiver certo*/
            $msqErro = $e->getMessage();
        }
    }

    public function cadastrar($nome, $telefone, $email, $senha)
    {
        global $pdo;
        //VERIFICAR SE O EMAIL EXISTE
        $sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e");
        $sql->bindValue(":e",$email); /*apelido para um parametro*/
        $sql->execute();

        if($sql->rowCount()>0)
        {
            return false; //EMAIL JÁ CADASTRADO
        }
        else
        {
            //EMAIL NÃO ESTA CADASTRADO, FAZER O CADASTRO:
            $sql = $pdo->prepare("INSERT INTO usuario(nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5 ($senha));
            $sql->execute();
            return true; //TUDO OK
        }
    }

    public function login($email, $senha)
    {
        global $pdo;
        //VERIFICAR SE O EMAIL E SENHA ESTÃO CORRETOS, SE SIM
        $sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5 ($senha));
        $sql->execute();
        if($sql->rowCoun()>0)
        {
            $dado =  $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>