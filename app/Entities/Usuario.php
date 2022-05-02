<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class Usuario extends Entity
{

    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];

    public function verificaPassword(string $password){
        return password_verify($password, $this->password_hash);
    }

    public function iniciaPasswordReset(){
        
        // Instancio novo objeto da classe token
        $token = new Token();
        /**
         * @descricao: Atribuimos ao objeto Entitie Usuario ($this) o atributo 'reset_token' que conterá o token gerado
         *              para que possamos acessá-lo na view 'Password/reset_email',
        */
        $this->reset_token = $token->getValue();
         /**
         * @descricao: Atribuimos ao objeto Entitie Usuario ($this) o atributo 'reset_hash' que conterá o hash do token
          *             
        */
        $this->reset_hash = $token->getHash();
         /**
         * @descricao: Atribuimos ao objeto Entitie Usuario ($this) o atributo 'reset_expira_em' que conterá a data de expiração do token gerado 
         */
        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200); // Expira em 2 horas
    }

    public function completaPasswordReset(){
        $this->reset_hash = null;
        $this->reset_expira_em = null;
    }
}
