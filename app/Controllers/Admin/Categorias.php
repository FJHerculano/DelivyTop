<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Categoria; 

class Categorias extends BaseController{
    private $categoriaModel;

    public function __construct(){

        $this->categoriaModel = new \App\Models\CategoriaModel();

    }

    public function index(){
        // 
        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager,
        ];

        // dd($data['categorias']);

        return view('Admin/Categorias/index' , $data);
    }

     /**
     * @uso Controller categoria no método procurar com o autocomplete 
     * @param string $term
     * @return array categorias
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($categorias as $categoria){

            $data['id'] = $categoria->id;
            $data['value'] = $categoria->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }

    public function criar(){

        $categoria = new Categoria();

        $data = [
            
            'titulo' => "Criando uma categoria ",
            'categoria' => $categoria,

        ];

        return view('Admin/Categorias/criar', $data);
    }

    public function cadastrar(){

        if($this->request->getMethod() === 'post'){

            $categoria = new Categoria($this->request->getPost());

            if($this->categoriaModel->save($categoria)){

                return redirect()->to(site_url("admin/categorias/show/".$this->categoriaModel->getInsertID()))
                            ->with('sucesso', "categoria $categoria->nome cadastrada com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->categoriaModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function show($id = null){

        $categoria = $this->buscaCategoriaOu404($id);

        $data = [
            
            'titulo' => "Detalhando a categoria $categoria->nome",
            'categoria' => $categoria,

        ];

        return view('Admin/Categorias/show', $data);
    }

    public function editar($id = null){

        $categoria = $this->buscaCategoriaOu404($id);

        if($categoria->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "A categoria $categoria->nome encontra-se excluida no momento. Portanto, não é possível editá-lo");
        }

        $data = [
            
            'titulo' => "Editando a categoria $categoria->nome",
            'categoria' => $categoria,

        ];
        return view('Admin/Categorias/editar', $data);
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
            $categoria = $this->buscaCategoriaOu404($id);

            if($categoria->deletado_em != null){
                return redirect()
                        ->back()
                        ->with('info', "A categoria $categoria->nome encontra-se excluida no momento. Portanto, não é possível editá-lo");
            }

            $categoria->fill($this->request->getPost());

            if(!$categoria->hasChanged()){
                return redirect()->back()->with('info', 'Nenhum dado foi modificado');
            }

            if($this->categoriaModel->save($categoria)){

                return redirect()->to(site_url("admin/categorias/show/$categoria->id"))
                            ->with('sucesso', "categoria $categoria->nome atualizada com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->categoriaModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function excluir($id = null){

        $categoria = $this->buscaCategoriaOu404($id); 
        
        if($categoria->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "A categoria $categoria->nome encontra-se excluida no momento. ");
        }

        if($this->request->getMethod() === 'post'){
            $this->categoriaModel->delete($id);
            return redirect()->to(site_url('admin/categorias'))
            ->with('sucesso', "Categoria $categoria->nome excluida com sucesso!");
        }

        $data = [
            
            'titulo' => "Excluindo a categoria $categoria->nome",
            'categoria' => $categoria,

        ];

        return view('Admin/Categorias/excluir', $data);
    }

    public function desfazerExclusao($id = null){

        $categoria = $this->buscaCategoriaOu404($id);
        if($categoria->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas categorias excluídas podem ser recuperadas');
        }

        if($this->categoriaModel->desfazerExclusao($id)){
            return redirect()
                    ->back()
                    ->with('sucesso', 'A exclusão foi desfeita, categoria recadastrada no sistema');
        }else{
            return redirect()->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    /**
     *  
     * @param int $id
     * @return object categoria
     */
    private function buscaCategoriaOu404(int $id = null){
        if(!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a categoria $id");
        }

        return $categoria;
    }

}