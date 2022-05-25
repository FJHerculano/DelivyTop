<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends Model
{
    protected $table            = 'entregadores';
    protected $returnType       = 'App\Entities\Entregador';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'nome', 'cpf', 'cnh', 'email', 
        'telefone', 'imagem', 'ativo', 
        'veiculo', 'placa', 'endereco',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

   
    // Validacoes
    protected $validationRules    = [
        'nome'   => 'required|min_length[3]|max_length[120]',
        'email'  => 'required|valid_email|is_unique[entregadores.email]',
        'cpf'    => 'required|exact_length[14]|validaCpf|is_unique[entregadores.cpf]',
        'cnh'    => 'required|exact_length[11]|is_unique[entregadores.cnh]',
        'telefone' => 'required|exact_length[15]|is_unique[entregadores.telefone]',
        'endereco' => 'required|max_length[230]',
        'veiculo'  => 'required|max_length[230]',
        'placa'    => 'required|min_length[7]|max_length[8]|is_unique[entregadores.placa]',

    ];

    protected $validationMessages = [
        'nome'        => [
            'required' => 'Desculpe. Campo nome é obrigatório.',
        ],
        'email'        => [
            'required' => 'Desculpe. Campo email é obrigatório.',
            'is_unique' => 'Desculpe. Esse email já existe.',
        ],
        'cpf'        => [
            'required' => 'Desculpe. Campo CPF é obrigatório.',
            'is_unique' => 'Desculpe. Esse CPF já existe.',
        ],
        'telefone'        => [
            'required' => 'Desculpe. Campo telefone é obrigatório.',
            'is_unique' => 'Desculpe. Esse telefone já existe.',
        ],
    ];

    
    /**
     * @uso Controller usuarios no método procurar com o autocomplete
     * @param string $term
     * @return array entregadores
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
