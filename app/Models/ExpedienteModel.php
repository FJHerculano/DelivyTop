<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpedienteModel extends Model
{
    protected $table            = 'expediente';
    protected $returnType       = 'object';
    protected $allowedFields    = ['abertura', 'fechamento', 'situacao'];

      // Validacoes
      protected $validationRules    = [
        'abertura'   => 'required',
        'fechamento' => 'required',

    ];

    protected $validationMessages = [
        'abertura'        => [
            'required' => 'Desculpe. O campo abertura é obrigatorio.',
        ],
        'fechamento'        => [
            'required' => 'Desculpe. O campo fechamento é obrigatorio.',
        ],
    ];
}
