<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal -->

  <link rel="stylesheet" href="<?php echo site_url('Admin/vendors/auto-complete/jquery-ui.css'); ?>">
 
<?php echo $this->endsection() ?>





<?php echo $this->section('conteudo') ?>

  <!-- Aqui enviamos os conteudos para o template principal -->
  <div class="row" >

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?php echo $titulo ?></h4>

          <div class="ui-widget">
            <input id="query" name="query" placeholder="Pesquise por um usuário " class="form-control bg-light mb-5 border-dark"  >
          </div>

                    
          <a href="<?php echo site_url("admin/entregadores/criar/"); ?>" class="btn btn-success float-right mb-5">
              Cadastrar
              <i class="mdi mdi-plus btn-icon-prepend"></i>
          </a>
      
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Nome</th>
                  <th>Telefone</th>
                  <th>Placa</th>
                  <th>Ativo</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($entregadores as $entregador): ?>

                  <tr>
                  <td class="py-1" >

                  <?php if($entregador->imagem): ?>
                    <img src="<?php echo site_url("admin/entregadores/imagem/$entregador->imagem"); ?>" alt="<?php echo esc($entregador->nome)?>">
                  <?php else:  ?>
                    <img src="<?php echo site_url('admin/images/user.png'); ?>" alt="Entregador sem imagem">
                  <?php endif; ?>

                  </td>     

                  <td>
                    <a href="<?php echo site_url("admin/entregadores/show/$entregador->id"); ?>">
                    <?php echo $entregador->nome?>
                    </a>
                  </td>

                  <td><?php echo $entregador->telefone ?></td>
                  <td><?php echo $entregador->placa ?></td>
                  <td><?php echo ($entregador->ativo && $entregador->deletado_em == null ? '<label class="badge badge-primary">Ativo</label>' :' <label class="badge badge-warning">Desativado</label>') ?></td>
                  <td>

                    <?php echo ($entregador->deletado_em === null ? '<label class="badge badge-success">Disponivel</label>' : ' <label class="badge badge-danger">Excluido</label>') ?>
                   
                    <?php if($entregador->deletado_em !== null): ?>

                      <a href="<?php echo site_url("admin/entregadores/desfazerexclusao/$entregador->id"); ?>" class="badge badge-dark ml-2">
                          Desfazer
                          <i class="mdi mdi-undo btn-icon-prepend"></i>
                      </a>                              
       
                    <?php endif;?>
                  </td>
                  </tr>

                <?php endforeach; ?>

              </tbody>
            </table>

            <div class="mt-3">
              <?php echo $pager->links()?>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
<?php echo $this->endsection() ?>





<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
  <script src="<?php echo site_url('Admin/vendors/auto-complete/jquery-ui.js');?>"></script>

  <script>

    $(function(){

      $("#query").autocomplete({
        
        source: function(request, response){
          $.ajax({

            url: "<?php echo site_url('admin/entregadores/procurar'); ?>",
            dataType:"json",
            data:{
              term: request.term
            },
            success:function(data){

              if(data.length < 1){

                var data = [
                  {
                    label:'Entregador não encontrado',
                    value: -1
                  }
                ];
              }
              response(data);//  Aqui temos valores sendo retornados
            },

          }); // fim do ajax 

        },

        minLenght: 1,
        select: function(event, ui){

          if(ui.item.value == -1){

            $(this).val("");
            return false;

          }else{

            window.location.href = '<?php echo site_url('admin/entregadores/show/'); ?>' + ui.item.id;

          }

        }

      }); // Fim do auto complete

    });

  </script>

<?php echo $this->endsection() ?>