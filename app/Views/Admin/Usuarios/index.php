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

                    
          <a href="<?php echo site_url("admin/usuarios/criar/"); ?>" class="btn btn-success float-right mb-5">
              Cadastrar
              <i class="mdi mdi-plus btn-icon-prepend"></i>
          </a>
      
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>CPF</th>
                  <th>Ativo</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($usuarios as $usuario): ?>

                  <tr>
                  <td>
                    <a href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>">
                    <?php echo $usuario->nome?>
                    </a>
                  </td>
                  <td><?php echo $usuario->email?></td>
                  <td><?php echo $usuario->cpf?></td>
                  <td><?php echo ($usuario->ativo && $usuario->deletado_em == null ? '<label class="badge badge-primary">Ativo</label>' :' <label class="badge badge-warning">Desativado</label>') ?></td>
                  <td>

                    <?php echo ($usuario->deletado_em === null ? '<label class="badge badge-success">Disponivel</label>' : ' <label class="badge badge-danger">Excluido</label>') ?>
                   
                    <?php if($usuario->deletado_em !== null): ?>

                      <a href="<?php echo site_url("admin/usuarios/desfazerexclusao/$usuario->id"); ?>" class="badge badge-dark ml-2">
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

            url: "<?php echo site_url('admin/usuarios/procurar'); ?>",
            dataType:"json",
            data:{
              term: request.term
            },
            success:function(data){

              if(data.length < 1){

                var data = [
                  {
                    label:'Usuario não encontrado',
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

            window.location.href = '<?php echo site_url('admin/usuarios/show/'); ?>' + ui.item.id;

          }

        }

      }); // Fim do auto complete

    });

  </script>

<?php echo $this->endsection() ?>