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
        <?php echo form_open_multipart("admin/entregadores/upload/$entregador->id"); ?>

          <div class="form-group mb-5">
            <label>Cadastro de imagem</label>
            <input type="file" name="foto_entregador" class="file-upload-default">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled placeholder="Escolha uma imagem do alimento">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Escolher</button>
              </span>
            </div>
          </div>
                    
          <button type="submit" class="btn btn-primary mr-2 btn-sm">
              <i class="mdi mdi-check btn-icon-prepend"></i>
              Salvar
          </button>

          <a href="<?php echo site_url("admin/entregadores/show/$entregador->id"); ?>" class="btn btn-light btn-sm border-dark">
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

  <!-- Custom js for this page-->
  <script src="<?php echo site_url('admin/js/file-upload.js'); ?>"></script>
<?php echo $this->endsection() ?>


