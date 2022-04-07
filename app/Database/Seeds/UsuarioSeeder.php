<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        //
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Francisco José' ,
            'email' => 'admin@admin.com',
            'telefone' => '88 - 9999-9999',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'Fulano tal' ,
            'email' => 'fulano@fulano.com',
            'telefone' => '88 - 1111-1111',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());

    }
}
