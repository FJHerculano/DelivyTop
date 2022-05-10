<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Extra;

class Extras extends BaseController{

    private $extraModel;

    public function __construct(){
        $this->extraModel = new \App\Models\ExtraModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os extras de produtos',
            'extras' => $this->extraModel->withDeleted(true)->paginate(10),
            'pager' => $this->extraModel->pager,
        ];

        return view('Admin/Extras/index', $data);
    }

         /**
     * @uso Controller extra no método procurar com o autocomplete 
     * @param string $term
     * @return array extras
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $extras = $this->extraModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($extras as $extra){

            $data['id'] = $extra->id;
            $data['value'] = $extra->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }
        
    public function criar(){

        $extra = new Extra();

        $data = [
            
            'titulo' => "Criando um item de extra ",
            'extra' => $extra,

        ];

        return view('Admin/Extras/criar', $data);
    }

    public function cadastrar($id = null){

        if($this->request->getMethod() === 'post'){
            $extra = new Extra($this->request->getPost());

            if($this->extraModel->save($extra)){

                return redirect()->to(site_url("admin/extras/show/".$this->extraModel->getInsertID()))
                            ->with('sucesso', "Extra $extra->nome cadastrado com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->extraModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function show($id = null){

        $extra = $this->buscaExtraOu404($id);

        $data = [
            
            'titulo' => "Detalhando o item  extra $extra->nome",
            'extra' => $extra,

        ];

        return view('Admin/Extras/show', $data);
    }

    public function editar($id = null){

        $extra = $this->buscaExtraOu404($id);

        if($extra->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "O intem extra $extra->nome encontra-se excluida no momento. Portanto, não é possível editá-lo");
        }

        $data = [
            
            'titulo' => "Editando a extra $extra->nome",
            'extra' => $extra,

        ];
        return view('Admin/Extras/editar', $data);
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
            $extra = $this->buscaExtraOu404($id);

            if($extra->deletado_em != null){
                return redirect()
                        ->back()
                        ->with('info', "O intem extra $extra->nome encontra-se excluida no momento. Portanto, não é possível editá-lo");
            }

            $extra->fill($this->request->getPost());

            if(!$extra->hasChanged()){
                return redirect()->back()->with('info', 'Nenhum dado foi modificado');
            }

            if($this->extraModel->save($extra)){

                return redirect()->to(site_url("admin/extras/show/$extra->id"))
                            ->with('sucesso', "extra $extra->nome atualizado com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->extraModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function excluir($id = null){

        $extra = $this->buscaExtraOu404($id); 
        
        if($extra->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "O extra $extra->nome encontra-se excluido no momento. ");
        }

        if($this->request->getMethod() === 'post'){
            $this->extraModel->delete($id);
            return redirect()->to(site_url('admin/extras'))
            ->with('sucesso', "Extra $extra->nome excluida com sucesso!");
        }

        $data = [
            
            'titulo' => "Excluindo a extra $extra->nome",
            'extra' => $extra,

        ];

        return view('Admin/Extras/excluir', $data);
    }

    public function desfazerExclusao($id = null){

        $extra = $this->buscaExtraOu404($id);
        if($extra->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas extras excluídos podem ser recuperados');
        }

        if($this->extraModel->desfazerExclusao($id)){
            return redirect()
                    ->back()
                    ->with('sucesso', 'A exclusão foi desfeita, extra recadastrado no sistema');
        }else{
            return redirect()->back()
                ->with('errors_model', $this->extraModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }


      /**
     *  
     * @param int $id
     * @return object Extra
     */
    private function buscaExtraOu404(int $id = null){
        if(!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a extra $id");
        }

        return $extra;
    }

}
