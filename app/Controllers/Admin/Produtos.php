<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Produto;

class Produtos extends BaseController{
    
    private $produtoModel;
    private $categoriaModel;

    public function __construct(){
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }

    public function index(){

        $data = [
            'titulo' => 'Listando os produtos',
            'produtos' => $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                                             ->join('categorias', 'categorias.id = produtos.categoria_id')
                                             ->withDeleted(true)
                                             ->paginate(10),
            'pager' => $this->produtoModel->pager,
        ];

        return view('Admin/Produtos/index', $data);

    }
    
         /**
     * @uso Controller produto no método procurar com o autocomplete 
     * @param string $term
     * @return array produtos
     */
    public function procurar(){
        if(!$this->request->isAJAX()){
            exit( 'Pagina não encontrada' );
        }

        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach($produtos as $produto){

            $data['id'] = $produto->id;
            $data['value'] = $produto->nome;

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);
        
    }
    
    public function criar(){

        $produto = new Produto();

        $data = [
            
            'titulo' => "Criando um novo produto",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll()

        ];

        return view('Admin/Produtos/criar', $data);
    }
    
    public function cadastrar(){
        if($this->request->getMethod() === 'post'){

            $produto = new Produto($this->request->getPost());

            if($this->produtoModel->save($produto)){
                return redirect()->to(site_url("admin/produtos/show/".$this->produtoModel->getInsertID()))
                        ->with('sucesso', 'Produto cadastrado com sucesso');
            }else{
                // Erro de validação da model
                return  redirect()->back()
                        ->with('errors_model', $this->produtoModel->errors())
                        ->with('atencao', 'Por favor verifique os dados abaixo')
                        ->withInput();
            }

        }else{
            return redirect()->back();
        }
    }

    public function show($id = null){

        $produto = $this->buscaProdutoOu404($id);

        $data = [
            
            'titulo' => "Detalhando o produto $produto->nome",
            'produto' => $produto,

        ];

        return view('Admin/Produtos/show', $data);
    }
    
    public function editar($id = null){

        $produto = $this->buscaProdutoOu404($id);

        $data = [
            
            'titulo' => "Editando o produto $produto->nome",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/editar', $data);
    }

    public function atualizar($id = null){
        if($this->request->getMethod() === 'post'){

            $produto = $this->buscaProdutoOu404($id);

            $produto->fill($this->request->getPost());

            if(!$produto->hasChanged()){
                return redirect()->back()->with('info', 'Não há dados para atualizar' );
            }

            if($this->produtoModel->save($produto)){
                return redirect()->to(site_url("admin/produtos/show/$id"))->with('sucesso', 'Produto editado com sucesso');
            }else{
                // Erro de validação da model
                return  redirect()->back()
                        ->with('errors_model', $this->produtoModel->errors())
                        ->with('atencao', 'Por favor verifique os dados abaixo')
                        ->withInput();
            }

        }else{
            return redirect()->back();
        }
    }

    public function editarImagem($id = null){
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo' => "Editando a imagem do produto $produto->nome",
            'produto' => $produto,
        ];

        return view("Admin/Produtos/editar_imagem", $data);
    }

    public function upload($id = null){
        $produto = $this->buscaProdutoOu404($id);
        // Recuperando arquivo de acordo com a documentação ci
        $imagem = $this->request->getFile('foto_produto');

        if(!$imagem->isValid()){
            
            $codigoErro = $imagem->getError();

            if($codigoErro == UPLOAD_ERR_NO_FILE){
                return redirect()->back()->with('atencao', 'Nenhum arquivo foi selecionado');
            }
        }

        $tamanhoImagem = $imagem->getSizeByUnit('mb');

        if($tamanhoImagem > 2){
            return redirect()->back()->with('atencao', 'Imagem selecionada é muito grande, o maximo permitido é 2MB');
        }

        $tipoImagem = $imagem->getMimeType();
        $tipoImagemLimpo = explode('/', $tipoImagem);

        $tiposPermitidos = [
            'jpeg', 'png', 'webp',
        ];

        if(!in_array($tipoImagemLimpo[1], $tiposPermitidos )){
            return redirect()->back()->with('atencao', 'Por ser de um tipo diferente do permitido, a imagem não foi carregada, tente novamente com imagens que tenha a extenção, '.implode(', ', $tiposPermitidos));
        }

        list($largura, $altura) = getimagesize($imagem->getPathName());

        if($largura < "400" || $altura < "400"){
            return redirect()->back()->with('atencao', 'A imagem não pode ser menor que 400 x 400 pixels');
        }

        //  A partir desse ponto realizamos o store da imagem

        // fazendo o store da imagem e recuperando o caminho da mesma
        $imagemCaminho = $imagem->store('produtos');

        $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;

        // diminuindo a imagem para o padrão requerido
        service('image')
            ->withFile($imagemCaminho)
            ->fit(400, 400, 'center')
            ->save($imagemCaminho);

        // Recuperando imagem antiga para exclui-la  
        $imagemAntiga = $produto->imagem;

        // atribuindo a nova imagem ao campo imagem na tabela produto
        $produto->imagem = $imagem->getName();

        // Atualizando a imagem do produto no banco
        $this->produtoModel->save($produto);
        // Definindo o caminho da imagem antiga 
        $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagemAntiga;

        if(is_file($caminhoImagem)){
            unlink($caminhoImagem);
        }

        return redirect()->to(site_url("admin/produtos/show/$produto->id"))->with('sucesso', 'Imagem alterada com sucesso');

    }

    public function imagem(string $imagem = null){
        if($imagem){

            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;

            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);

            header("Content-Type: $tipoImagem");

            header("Content-Length: " . filesize($caminhoImagem));

            readfile($caminhoImagem);

            exit;
        }
    }

          /**
     *  
     * @param int $id
     * @return object produto
     */
    private function buscaProdutoOu404(int $id = null){
        if(!$id || !$produto = $this->produtoModel
            ->select('produtos.*, categorias.nome AS categoria')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->where('produtos.id' , $id)
            ->withDeleted(true)
            ->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o produto $id");
        }

        return $produto;
    }

       
}
