<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $returnType       = 'App\Entities\Categoria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'ativo', 'slug'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validacoes
    protected $validationRules    = [
        'nome'   => 'required|min_length[2]|max_length[120]|is_unique[categorias.nome]',
    ];

    protected $validationMessages = [
        'nome'        => [
            'required' => 'Desculpe. Campo nome é obrigatório.',
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

}
