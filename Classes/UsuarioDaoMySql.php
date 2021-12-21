<?php
require_once ('UsuarioClasse.php');

Class UsuarioDaoMySql implements UsuarioDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;       
    }

    public function adicionarUsuario(Usuario $usuario){
        $sql = $this->pdo->prepare("INSERT INTO user (user_nome, user_login, user_senha, user_setor, user_regional, user_cpf, user_aniversario) 
        VALUES (:nome, :acesso, :senha, :setor, :regional, :cpf, :aniversario )");
        $sql->bindValue(':nome', $usuario->getNome());
        $sql->bindValue(':acesso', $usuario->getLogin());
        $sql->bindValue(':senha', $usuario->getSenha());
        $sql->bindValue(':setor',$usuario->getSetor());
        $sql->bindValue(':regional',$usuario->getReginal());
        $sql->bindValue(':cpf',$usuario->getCpf());
        $sql->bindValue(':aniversario',$usuario->getNiver());
        $sql->execute();
        
        $usuario->setUserId($this->pdo->lastInsertId());//Função do lastInsertId é do PDO para pega o #id

        return $usuario;
    }
    //Listando todos os Usuários
    public function findAll(){ 
        $array=[];
        $sql = $this->pdo->query("SELECT * FROM user");
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach ($data as $lista){
                $usuario = new Usuario();
                $usuario->setUserId($lista['user_id']);
                $usuario->setNome($lista['user_nome']);

                $array[] = $usuario;
            }

        }
        return $array;
    } 
    //puxa o usuário so pelo id
    public function findById($user_id){ 
        $sql = $this->pdo->prepare("SELECT * FROM user WHERE user_id = :id");
        $sql->bindValue(':id',$user_id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $usuario = new Usuario();
            $usuario->setUserId($data['user_id']);
            $usuario->setNome($data['user_nome']);
            $usuario->setLogin($data['user_login']);
            return $usuario;
        }else{
            return false;
        }
    } 
    public function findByNome($user_id){
        $sql = $this->pdo->prepare("SELECT * FROM user WHERE user_id = :id");
        $sql->bindValue(':id',$user_id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $usuario = new Usuario();
            $usuario->setUserId($data['user_id']);
            $usuario->setNome($data['user_nome']);
            return $usuario;
        }else{
            return false;
        }
    }
    public function findByLogin ($login){ //puxa o usuário so pelo Login, assim poder fazer o cadastro
        $sql=$this->pdo->prepare("SELECT * FROM user WHERE user_login = :login");
        $sql->bindValue(':login',$login);
        $sql->execute();
        if ($sql->rowCount() >0) {
            $data = $sql->fetch();
            $usuario = new Usuario();
            $usuario->setUserId($data['user_id']);
            $usuario->setNome($data['user_nome']);
            $usuario->getSenha($data['user_senha']);

            return $usuario;
        }else{
            return false;
        }

    }
    public function update(Usuario $usuario){
        $sql = $this->pdo->prepare("UPDATE user SET user_nome = :nome, user_setor = :setor, user_nivel = :nivel, user_status = :status, user_setor = :setor, user_regional = :regional, user_cpf = :cpf, user_aniversario = :niver WHERE user_id = :id");
        $sql->bindValue(':nome',$usuario->getNome());

        $sql->execute();

        return true;
    }
    public function desabilitarUser(Usuario $user_id){
        
    }
    public function acessoPass(){
        $array=[];
        $sql = $this->pdo->query("SELECT * FROM user WHERE user_nivel = 0");
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach ($data as $lista){
                $usuario = new Usuario();
                $usuario->setUserId($lista['user_id']);
                $usuario->setNome($lista['user_nome']);

                $array[] = $usuario;
            }

        }
        return $array;
    }
    public function upAcessoPass(Usuario $usuario){
        $sql = $this->pdo->prepare("UPDATE user SET user_nivel = :nivel, user_status = :status WHERE user_id = :id");
        $sql->bindValue(':nivel',$usuario->getNivel());
        $sql->bindValue(':status',$usuario->getStatus());
        $sql->bindValue(':id',$usuario->getUserId());
        $sql->execute();
        return true;
    }
    public function login($login,$senha){ 
        $sql = $this->pdo->prepare("SELECT * FROM user WHERE user_login =:login AND user_senha =:senha");
        $sql->bindValue(':login',$login);
        $sql->bindValue(':senha', $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $user = new Usuario();
            $user->setUserId($data['user_id']);
            $user->setNome($data['user_nome']);
            $user->setNivel($data['user_nivel']);
            $user->setStatus($data['user_status']);
            return $user;
        }else{
            return false;
        }
    }
    // Fim do Método login

}
