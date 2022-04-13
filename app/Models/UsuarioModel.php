<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'email', 'telefone'];
    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em'; // Nome da coluna no banco de dados
    protected $updatedField         = 'atualizado_em'; // Nome da coluna no banco de dados
    protected $deletedField         = 'deletado_em'; // Nome da coluna no banco de dados


    protected $validationRules    = [
        'nome'   => 'required|min_length[3]|max_length[120]',
        'email'  => 'required|valid_email|is_unique[usuarios.email]',
        'cpf'    => 'required|exact_length[14]|is_unique[usuarios.cpf]',
        'telefone'    => 'required|is_unique',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
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

    public function procurar($term){

        if($term === null){
            return[];
        }

        return $this->select('id,nome')->like('nome', $term)->get()->getResult();
    }

    public function desabilitaValidacaoSenha(){
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }
}
