<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Usuarios extends BaseController
{

    private $usuarioModel;

    public function __construct(){

        $this->usuarioModel = new \App\Models\UsuarioModel();

    }

    public function index(){
        
        $data=[
            'titulo' => 'Listando os usuarios',
            'usuarios' => $this->usuarioModel->findAll()
        ];

        return view('Admin/Usuarios/index', $data);

    }

    /**
     * @uso Controller usuario no método procurar com o autocomplete 
     * @param string $term
     * @return array usuarios
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($usuarios as $usuario){

            $data['id'] = $usuario->id;
            $data['value'] = $usuario->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }


    public function show($id = null){

        $usuario = $this->buscaUsuarioOu404($id);


        $data = [
            
            'titulo' => "Detalhando o usuário $usuario->nome",
            'usuario' => $usuario,

        ];

        return view('Admin/Usuarios/show', $data);
    }


    /**
     *  
     * @param int $id
     * @return object usuario
     */
    private function buscaUsuarioOu404(int $id = null){
        if(!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }

        return $usuario;
    }

}

