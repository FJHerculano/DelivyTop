<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class FormasPagamento extends BaseController{

    private $formaPagamentoModel;

    public function __construct(){
        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();
    }

    public function index(){

        $data = [
            'titulo' => 'Listando as formas de pagamento',
            'formas' => $this->formaPagamentoModel->withDeleted(true)->paginate(10),
            'pager' => $this->formaPagamentoModel->pager,
        ];

        return view('Admin/FormasPagamento/index', $data);

    }

    /**
     * @uso Controller formasPagamento no método procurar com o autocomplete 
     * @param string $term
     * @return array objetos formaPagamento
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($formas as $forma){

            $data['id'] = $forma->id;
            $data['value'] = $forma->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }
    
    public function criar (){
        $formaPagamento = new FormaPagamento();

        $data=[
            'titulo' => "Criando a forma de pagamento",
            'forma' => $formaPagamento,
        ];

        return view('Admin/formasPagamento/criar', $data);
    }

    public function show ($id = null){
        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        $data=[
            'titulo' => "Detalhando a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/formasPagamento/show', $data);
    }      

    public function editar ($id = null){
        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        $data=[
            'titulo' => "Editando a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/formasPagamento/editar', $data);
    }

    public function atualizar($id = null){
        if($this->request->getMethod() === 'post'){

            $formaPagamento = $this->buscaFormaPagamentoOu404($id);

            $formaPagamento->fill($this->request->getPost());

            if(!$formaPagamento->hasChanged()){
                return redirect()->back()->with('info', 'Não há dados para atualizar');

            }

            if($this->formaPagamentoModel->save($formaPagamento)){

                return redirect()->to(site_url("admin/formas/show/$formaPagamento->id"))
                                    ->with('sucesso', "Forma de pagamento $formaPagamento->nome atualizada com sucesso");

            }else{
                return redirect()->back()
                                ->with('errors_model', $this->formaPagamentoModel->errors())
                                ->with('atencao', 'Por favor verifique os erros abaixo')
                                ->withInput();
            }

        }else{
            return redirect()->back();
        }
    }

      /**
     *  
     * @param int $id
     * @return object forma de pagamento
     */
    private function buscaFormaPagamentoOu404(int $id = null){
        if(!$id || !$formaPagamento = $this->formaPagamentoModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento $id");
        }

        return $formaPagamento;
    }

        
}
