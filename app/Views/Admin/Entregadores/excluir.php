<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal --> 
<?php echo $this->endsection() ?>




<?php echo $this->section('conteudo') ?>

  <!-- Aqui enviamos os conteudos para o template principal -->
  <div class="row" >

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header bg-primary pb-0 pt-4">
            <h4 class="card-title text-white f"><?php echo esc($titulo) ?></h4>
          </div>
        <div class="card-body">

        <!-- mensagem de error na tela  -->
        <?php if(session()->has('errors_model')): ?>
          <ul>
            <?php foreach(session('errors_model') as $error): ?>
              <li class="text-danger"><?php echo  $error;?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <!-- Formulario de cadastro  -->
        <?php echo form_open("admin/usuarios/excluir/$usuario->id"); ?>

         <div class="alert alert-warning alert-dismissible fade show" role="alert" >
           <strong>Atenção</strong> Tem certeza da exclusão do usuario <strong><?php echo esc($usuario->nome); ?>?</strong>
         </div>

          <button type="submit" class="btn btn-danger mr-2 btn-sm">
            <i class="mdi mdi-trash-can btn-icon-prepend"></i>
            Excluir
          </button>
          
          <a  href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>" 
              class="btn btn-light btn-sm border-dark">
            voltar
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
          </a>

        <?php echo form_close(); ?>

    </div>
    </div>

  </div>
<?php echo $this->endsection() ?>





<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
  <script src="<?php echo site_url('Admin/vendors/mask/app.js');?>"></script>
  <script src="<?php echo site_url('Admin/vendors/mask/jquery.mask.min.js');?>"></script>
<?php echo $this->endsection() ?>


