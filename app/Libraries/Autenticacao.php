<?php

namespace App\Libraries;

/*
 @descricao essa biblioteca / classe cuidará da parte de autenticação da nossa aplicação 
 */

class Autenticacao{
    private $usuario;

    public function login(string $email, string $password){

        $usuarioModel = new \App\Models\UsuarioModel();

        $usuario = $usuarioModel->buscaUsuarioPorEmail($email);
        // Se não encontrar o usuario por email retorna falso
        if($usuario === null){
            return false;
        }
        // Se a senha não combinar com o password_hash, retorna falso
        if(!$usuario->verificaPassword($password)){
            return false;
        }
        // Só permitiremos o login de usuarios ativos
        if(!$usuario->ativo){
            return false;
        }
        // Nesse ponto todas as verificações foram aprovadas e o login será realizado
        $this->logaUsuario($usuario);

        return true;
    }

    public function logout(){
        session()->destroy();
    }

    public function pegaUsuarioLogado(){
        // NJão esquecer de compartilhar a instância com services
        if($this->usuario === null){

            $this->usuario = $this->pegaUsuarioDaSessao();
        }
        // retorna usuario definido no inicio da classe
        return $this->usuario;
    }

    /**
     * @descricao : O método só permite ficar logado na aplicação aquele que ainda existir na base e que esteja ativo
     *              do contrario, será feito o logout do mesmo, caso haja uma mudança na sua conta durante a sua sessão
     *  
     * @uso : No filtro LoginFilter 
     * 
     *  @return retorna true se o método pegaUsuarioLogado() não for null. ou seja, se o usuário estiver logado
     */
    public function estaLogado(){
        return $this->pegaUsuarioLogado() !== null; 
    }

    private function pegaUsuarioDaSessao(){
        if(!session()->has('usuario_id')){
            return null;
        }
        // instanciando o model usuario e recuperando o usuario através da chave da sessão usuario_id
        $usuarioModel = new \App\Models\UsuarioModel();

        $usuario = $usuarioModel->find(session()->get('usuario_id'));
        // Apenas retorna o objeto usuario se o mesmo for encontrado e estiver ativo
        if($usuario && $usuario->ativo){
            return $usuario;
        }
    }

    /**
     * Credenciais validadas. Regeneramos a session_id e inserimos o 'usuario_id' na sessão
     * 
     * @param object $usuario
     * 
     * @importante: Antes de inserimos os dados do usuario na sessão, devemos regenerar o ID da sessão.
     * Pois quando carregamos a view login pela primeira vez, o valor da variável 'ci_session' do debug toolbar é um,
     * ao fazermos isso, estamos previnindo session fixation attack
     */
    private function logaUsuario(object $usuario){

        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario->id);

    }

}