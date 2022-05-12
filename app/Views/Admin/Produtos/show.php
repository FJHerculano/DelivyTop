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

            <div class="text-center">
              
              <?php if($produto->imagem): ?>
                  <img class="card-img-top w-75" src="<?php echo site_url("admin/produtos/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>">
              <?php else: ?>
                  <img class="card-img-top border border-secondary w-75 "  src="<?php echo site_url('admin/images/produto-padrao.jpg'); ?>" alt="Produto sem imagem por enquanto">
              <?php endif; ?>
            
            </div>
            <div class="text-center">
              <a href="<?php echo site_url("admin/produtos/editarimagem/$produto->id"); ?>" class="btn btn-outline-dark btn-sm mb-2 mt-2">
                  Cadastrar imagem
                  <i class="mdi mdi-image btn-icon-prepend"></i>
              </a>
            </div>
      
            <hr>
 
            <p class="card-text">
                <span class="font-weight-bold">Nome: </span>
                <?php echo esc($produto->nome) ?>
            </p>

            <p class="card-text">
                <span class="font-weight-bold">Categoria: </span>
                <?php echo esc($produto->categoria) ?>
            </p>

            <p class="card-text">
                <span class="font-weight-bold">Slug da produto: </span>
                <?php echo esc($produto->slug) ?>
            </p>

            <p class="card-text">
                <span class="font-weight-bold">Ativo: </span>
                <?php echo $produto->ativo ? 'Sim' : 'Não' ?>
            </p>

          
            <p class="card-text">
                <span class="font-weight-bold">Criado: </span>
                <?php echo ($produto->criado_em->humanize()); ?>
            </p>

            <?php if($produto->deletado_em == null): ?>

              <p class="card-text">
                <span class="font-weight-bold">Atualizado: </span>
                <?php echo ($produto->atualizado_em->humanize()); ?>
              </p>
            
            <?php else: ?>
              <p class="card-text">
                <span class="font-weight-bold text-danger">Excluído: </span>
                <?php echo ($produto->deletado_em->humanize()); ?>
              </p>
            <?php endif; ?>
              

            <div class="mt-4">

            <?php if($produto->deletado_em == null): ?>

              <a href="<?php echo site_url("admin/produtos/editar/$produto->id"); ?>" class="btn btn-dark btn-sm mr-2">
                    Editar
                    <i class="mdi mdi-pencil btn-icon-prepend"></i>
              </a>
            
              <a href="<?php echo site_url("admin/produtos/extras/$produto->id"); ?>" class="btn btn-outline-github btn-sm mr-2">
                    Extras
                    <i class="mdi mdi-pencil btn-icon-prepend"></i>
              </a>
              
              <a href="<?php echo site_url("admin/produtos/excluir/$produto->id"); ?>" class="btn btn-danger btn-sm mr-2">
                    Excluir
                    <i class="mdi mdi-trash-can btn-icon-prepend"></i>
              </a>
              
              <a href="<?php echo site_url("admin/produtos"); ?>" class="btn btn-light btn-sm border-dark">
                    voltar
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
              </a>
            <?php else: ?>
              <a href="<?php echo site_url("admin/produtos"); ?>" class="btn btn-light btn-sm border-dark mr-2">
                    voltar
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
              </a>
              <a href="<?php echo site_url("admin/produtos/desfazerexclusao/$produto->id"); ?>" class="btn btn-dark btn-sm ">
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