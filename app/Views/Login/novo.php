<?php echo $this->extend('Admin/layout/principal_autenticacao') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal -->
<?php echo $this->endsection() ?>




<?php echo $this->section('conteudo') ?>

  <!-- Aqui enviamos os conteudos para o template principal_autenticacao -->
  
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
            <div class="col-lg-5 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">

    
                <?php if(session()->has('sucesso')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Perfeito!</strong><?php echo session('sucesso'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if(session()->has('info')): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Informação!</strong><?php echo session('info'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if(session()->has('atencao')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Opa!</strong><?php echo session('atencao'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Captura os erros de CSRF - ações não permitidas -->
                <?php if(session()->has('error')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Erro!</strong><?php echo session('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="brand-logo">
                    <img src="<?php echo site_url('admin/')?>images/logo.svg" alt="logo">
                </div>
                <h4>Olá, seja bem vindo(a)!</h4>
                <h6 class="font-weight-light">por favor preencha os campos para cotinuar.</h6>

                <?php echo form_open('login/criar'); ?>

                    <div class="form-group">
                    <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Digite o email">
                    </div>

                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Digite a senha">
                    </div>

                    <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"> Entrar </button>
                    </div>
            
                    <div class="mb-2 mt-3">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                        <i class="mdi mdi-facebook mr-2"></i>Entrar usando facebook
                    </button>
                    </div>

                    <div class="text-center mt-4 font-weight-light">
                    Você ainda não tem conta? <a href="<?php echo site_url('registrar');?>" class="text-primary">Criar conta</a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

<?php echo $this->endsection() ?>




<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
<?php echo $this->endsection() ?>
