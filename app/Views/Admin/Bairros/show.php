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
            <h4 class="card-title text-white "><?php echo esc($titulo) ?></h4>
          </div>
        
        <div class="card-body">
        <p class="card-text">
                <span class="font-weight-bold">Nome: </span>
                <?php echo esc($bairro->nome) ?>
            </p>
            <p class="card-text">
                <span class="font-weight-bold">Cidade: </span>
                <?php echo esc($bairro->cidade) ?>
            </p>
            <p class="card-text">
                <span class="font-weight-bold">Valor da entrega: </span>
                R$&nbsp;<?php echo esc(number_format($bairro->valor_entrega, 2)) ?>
            </p>

            <p class="card-text">
                <span class="font-weight-bold">Ativo: </span>
                <?php echo $bairro->ativo ? 'Sim' : 'Não' ?>
            </p>

          
            <p class="card-text">
                <span class="font-weight-bold">Criado: </span>
                <?php echo ($bairro->criado_em->humanize()); ?>
            </p>

            <?php if($bairro->deletado_em == null): ?>

              <p class="card-text">
                <span class="font-weight-bold">Atualizado: </span>
                <?php echo ($bairro->atualizado_em->humanize()); ?>
              </p>
            
            <?php else: ?>
              <p class="card-text">
                <span class="font-weight-bold text-danger">Excluído: </span>
                <?php echo ($bairro->deletado_em->humanize()); ?>
              </p>
            <?php endif; ?>
              

            <div class="mt-4">

            <?php if($bairro->deletado_em == null): ?>

              <a href="<?php echo site_url("admin/bairros/editar/$bairro->id"); ?>" class="btn btn-dark btn-sm mr-2">
                    Editar
                    <i class="mdi mdi-pencil btn-icon-prepend"></i>
              </a>
              
              <a href="<?php echo site_url("admin/bairros/excluir/$bairro->id"); ?>" class="btn btn-danger btn-sm mr-2">
                    Excluir
                    <i class="mdi mdi-trash-can btn-icon-prepend"></i>
              </a>
              
              <a href="<?php echo site_url("admin/bairros"); ?>" class="btn btn-light btn-sm border-dark">
                    voltar
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
              </a>
            <?php else: ?>
              <a href="<?php echo site_url("admin/bairros"); ?>" class="btn btn-light btn-sm border-dark mr-2">
                    voltar
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
              </a>
              <a href="<?php echo site_url("admin/bairros/desfazerexclusao/$bairro->id"); ?>" class="btn btn-dark btn-sm ">
                Desfazer exclusão
                <i class="mdi mdi-undo btn-icon-prepend"></i>
              </a>   
            <?php endif; ?>

            </div>        
      
        </div>
    </div>
    </div>

  </div>
<?php echo $this->endsection() ?>





<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
  <script src="<?php echo site_url('Admin/vendors/auto-complete/jquery-ui.js');?>"></script>

<?php echo $this->endsection() ?>