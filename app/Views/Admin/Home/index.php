<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal -->
<?php echo $this->endsection() ?>









<?php echo $this->section('conteudo') ?>

  <!-- Aqui enviamos os conteudos para o template principal -->
  <?php echo $titulo; ?>

<?php echo $this->endsection() ?>










<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
<?php echo $this->endsection() ?>