<?php
class Usuario{
    private $user_id;
    private $user_nome;
    private $user_login;
    private $user_senha;

    public function getUserId(){
        return $this->user_id;
    }
    public function setUserId($id){
        $this->user_id = trim($id);
    }
    public function getNome(){
        return $this->user_nome;
    }
    public function setNome($nome){
        $this->user_nome = ucwords(trim($nome)); // deixa a primeira letra do nome Maiuscula
    }
    public function getLogin(){
        return $this->user_login;
    }
    public function setLogin($login){
        $this->user_login = strtolower(trim($login)); // strtolower -> deixa a texto em minusculas 
    }
    public function getSenha(){
        return $this->user_senha;
    }
    public function setSenha($senha){
        $this->user_senha = $senha;
    }


}

interface UsuarioDAO {
    public function addUsuario(Usuario $usuario);
    public function findAll(); //Achar todos os Usuários 
    public function findById($user_id); //Achar usuário so pelo #id
    public function findByNome($user_id); //Retorno no do Colaborador 
    public function findByLogin ($login); //Achar o usuário pelo login
    public function update(Usuario $user);
    public function upAcessoPass(Usuario $user);
    public function login($login,$senha);
}
