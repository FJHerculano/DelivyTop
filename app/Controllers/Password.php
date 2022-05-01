<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController{

    private $usuarioModel;

    public function __construct(){
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }

    public function esqueci(){
        //
        $data =[
            'titulo' => 'Esqueci a minha senha',

        ];

        return view('Password/esqueci', $data);
    }

    public function processaEsqueci(){
        if($this->request->getMethod() === 'post'){

            $usuario = $this->usuarioModel->buscaUsuarioPorEmail($this->request->getPost('email'));

            if($usuario === null || !$usuario->ativo){
                return redirect()
                ->to(site_url('password/esqueci'))
                ->with('atencao', 'Não encontramos uma conta valida com esse email')
                ->withInput();
            }

            $usuario->iniciaPasswordReset();

            $this->usuarioModel->save($usuario);

            $this->enviaEmailRedefinicaoSenha($usuario);

            return redirect()->to(site_url('login'))->with('sucesso', 'E-mail de redefinição de senha enviado à sua caixa de entrada do email');
        
        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function reset($token = null){

        if($token === null){
            return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Link expirado ou e-email invalido');
        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token);

        dd($usuario);

    }

    private function enviaEmailRedefinicaoSenha(object $usuario){
        $email = service('email');

        $email->setFrom('no-reply@delivytop.com', 'Delivytop');
        $email->setTo($usuario->email);

        $email->setSubject('Redefinição de senha');

        $mensagem = view('Password/reset_email', ['token' => $usuario->reset_token]);
        
        $email->setMessage($mensagem);

        $email->send();

    }
}
