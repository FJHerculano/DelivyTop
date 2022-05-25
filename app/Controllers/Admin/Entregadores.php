<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Entregador;


class Entregadores extends BaseController{

    private $entregadorModel;

    public function __construct(){
        $this->entregadorModel = new \App\Models\EntregadorModel();
    }

    public function index(){
        
        $data = [
            'titulo' => 'Listando os entregadores',
            'entregadores' => $this->entregadorModel->withDeleted(true)->paginate(10),
            'pager' => $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $data);
    }    

         /**
     * @uso Controller Entregador no método procurar com o autocomplete 
     * @param string $term
     * @return array entregadores
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $entregadores = $this->entregadorModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($entregadores as $entregador){

            $data['id'] = $entregador->id;
            $data['value'] = $entregador->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }
            
    
    public function show($id = null){

        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            
            'titulo' => "Detalhando o item  entregador $entregador->nome",
            'entregador' => $entregador,

        ];

        return view('Admin/Entregadores/show', $data);
    }

    
    public function editar($id = null){

        $entregador = $this->buscaEntregadorOu404($id);

        if($entregador->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "O entregador $entregador->nome encontra-se excluido no momento. Portanto, não é possível editá-lo");
        }

        $data = [
            
            'titulo' => "Editando o entregador $entregador->nome",
            'entregador' => $entregador,

        ];
        return view('Admin/Entregadores/editar', $data);
    }

    
    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
            $entregador = $this->buscaEntregadorOu404($id);

            if($entregador->deletado_em != null){
                return redirect()
                        ->back()
                        ->with('info', "O  entregador $entregador->nome encontra-se excluido no momento. Portanto, não é possível editá-lo");
            }

            $entregador->fill($this->request->getPost());

            if(!$entregador->hasChanged()){
                return redirect()->back()->with('info', 'Nenhum dado foi modificado');
            }

            if($this->entregadorModel->save($entregador)){

                return redirect()->to(site_url("admin/entregadores/show/$entregador->id"))
                            ->with('sucesso', "entregador $entregador->nome atualizado com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->entregadorModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }


      /**
     *  
     * @param int $id
     * @return object Entregador
     */
    private function buscaEntregadorOu404(int $id = null){
        if(!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o entregador $id");
        }

        return $entregador;
    }

}
