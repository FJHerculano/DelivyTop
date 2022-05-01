<?php

namespace App\Controllers;

class Home extends BaseController{
    public function index()
    {
        return view('welcome_message');
    }

    public function email(){
        $email = \Config\Services::email();

        $email->setFrom('your@example.com', 'Herculano');
        $email->setTo('herculano@aluno.fapce.edu.br');
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject('Email Test');
        $email->setMessage('é muito massa e tranquilo enviar email com codeigniter 4.');

        if($email->send()){
            echo 'Email enviado';
        }else{
            echo $email->printDebugger();
        }

    }

}
