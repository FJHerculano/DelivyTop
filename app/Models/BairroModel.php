<?php

namespace App\Models;

use CodeIgniter\Model;

class BairroModel extends Model
{
    protected $table            = 'bairros';
    protected $returnType       = 'App\Entities\Bairro';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'slug', 'valor_entrega', 'ativo'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';


    
    // Validacoes
    protected $validationRules    = [
        'nome'   => 'required|min_length[2]|max_length[120]|is_unique[bairros.nome]',
        'cidade'   => 'required|equals[Juazeiro do Norte]',
        'valor_entrega' => 'required',
    ];

    protected $validationMessages = [
        'nome'        => [
            'required' => 'Desculpe. O campo nome é obrigatorio.',
            'is_unique' => 'Desculpe. Este Bairro já existe.',
        ],
        'valor_entrega'        => [
            'required' => 'Desculpe. O campo valor da entrega  é obrigatorio.',
        ], 
        'cidade'        => [
            'equals' => 'Desculpe. O cep deverá ser de Juazeiro do Norte - CE.',
        ],
   
   
    ];

    // Eventos callback
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data){
        if(isset($data['data']['nome'])){

            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', TRUE);

        }

        return $data;
    }

     /**
     * @uso Controller Bairros no método procurar com o autocomplete
     * @param string $term
     * @return array Bairros
     */
    public function procurar($term){

        if($term === null){
            return[];
        }

        return $this->select('id,nome')
                    ->like('nome', $term)
                    ->withDeleted(true)
                    ->get()
                    ->getResult();
    }

    public function desfazerExclusao(int $id){
        return $this->protect(false)
                ->where('id', $id)
                ->set('deletado_em', null)
                ->update();
    }


}
