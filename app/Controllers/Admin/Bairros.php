<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Bairro;

class Bairros extends BaseController{

    private $bairroModel;

    public function __construct(){
        $this->bairroModel = new \App\Models\BairroModel();
    }

    public function index(){
        $data = [
            'titulo' => 'Listando os bairros atendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        return view('Admin/Bairros/index', $data);
    }

             /**
     * @uso Controller bairro no método procurar com o autocomplete 
     * @param string $term
     * @return array bairros
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $bairros = $this->bairroModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($bairros as $bairro){

            $data['id'] = $bairro->id;
            $data['value'] = $bairro->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }

        
    public function criar(){

        $bairro = new Bairro();

        $data = [
            
            'titulo' => "Cadastrando um novo bairro ",
            'bairro' => $bairro,

        ];

        return view('Admin/Bairros/criar', $data);
    }
        
    public function show($id = null){

        $bairro = $this->buscaBairroOu404($id);

        $data = [
            
            'titulo' => "Detalhando o item  bairro $bairro->nome",
            'bairro' => $bairro,

        ];

        return view('Admin/Bairros/show', $data);
    }

    public function editar($id = null){

        $bairro = $this->buscaBairroOu404($id);

        if($bairro->deletado_em != null){
            return redirect()
                    ->back()
                    ->with('info', "O bairro $bairro->nome encontra-se excluida no momento. Portanto, não é possível editá-lo");
        }

        $data = [
            
            'titulo' => "Editando o bairro $bairro->nome",
            'bairro' => $bairro,

        ];
        return view('Admin/Bairros/editar', $data);
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
            $bairro = $this->buscaBairroOu404($id);

            if($bairro->deletado_em != null){
                return redirect()
                        ->back()
                        ->with('info', "O bairro $bairro->nome encontra-se excluída no momento. Portanto, não é possível editá-lo");
            }

            $bairro->fill($this->request->getPost());

            $bairro->valor_entrega = str_replace(",", "", $bairro->valor_entrega);

            if(!$bairro->hasChanged()){
                return redirect()->back()->with('info', 'Nenhum dado foi modificado');
            }

            if($this->bairroModel->save($bairro)){

                return redirect()->to(site_url("admin/bairros/show/$bairro->id"))
                            ->with('sucesso', "bairro $bairro->nome atualizado com sucesso.");
            }else{

                return redirect()->back()
                            ->with('errors_model', $this->bairroModel->errors())
                            ->with('atencao', 'Por favor verifique os dados abaixo')
                            ->withInput();
            }

        }else{
            // Não é post
            return redirect()->back();
        }
    }

    public function consultaCep(){

        if(!$this->request->isAJAX()){
            return redirect()->to(site_url());
        }

        $validacao = service('validation');

        $validacao->setRule('cep', 'CEP', 'required|exact_length[9]');

        $retorno = [];

        if(!$validacao->withRequest($this->request)->run()){
            $retorno['erro'] = '<span class="text-danger small">'.$validacao->getError().'</span>';
            return $this->response->setJSON($retorno);
        }

        // cep formatado
        $cep = str_replace('-', '', $this->request->getGet('cep'));

        // Carregando o Helper
        helper('consulta_cep');

        $consulta = consultaCep($cep);



        echo '<pre>';
        print_r($consulta);
        die; 
    }
    
      /**
     *  
     * @param int $id
     * @return object bairro
     */
    private function buscaBairroOu404(int $id = null){
        if(!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o bairro $id");
        }

        return $bairro;
    }


}
