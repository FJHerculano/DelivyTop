<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal --> 
<?php echo $this->endsection() ?>




<?php echo $this->section('conteudo') ?>

  <!-- Aqui enviamos os conteudos para o template principal -->
  <div class="row" >

    <div class="col-lg-6 grid-margin stretch-card">
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
        <?php echo form_open("admin/medidas/atualizar/$medida->id"); ?>

          <?php echo $this->include('Admin/Medidas/form'); ?>

          <a href="<?php echo site_url("admin/medidas/show/$medida->id"); ?>" class="btn btn-light btn-sm border-dark">
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


