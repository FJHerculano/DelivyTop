<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal --> 
  
  <!-- select 2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .select2-container .select2-selection--single{
      display:block;
      width: 100%;
      height:2.875rem;
      padding: 0.875rem 1.375rem;
      font-size: 0.875rem;
      font-weight:400;
      line-height:1;
      color #495057;
      background-color: #ffffff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 2px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; 
    }

    .select2-container--default ..select2-selection--single .select2-selection__rendered{
      line-height: 18px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b{
      top: 80%;
    }


  </style>
  

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
        <?php echo form_open("admin/produtos/cadastrarespecificacoes/$produto->id"); ?>

        <div class="form-row ">
          <div class="form-group col-md-4">
            <label for="">Escolha a medida do produto (opcional)</label>
            <select name="medida_id"  class="form-control js-example-basic-single">
               
              <option value="">Escolha..</option>
              
              <?php foreach($medidas as $medida): ?>
                <option value="<?php echo $medida->id ?>"><?php echo esc($medida->nome); ?></option>
              <?php endforeach; ?>

            </select>
          </div>


          <div class="form-group col-md-4">
            <label for="preco">Preço</label>
            <input type="text" class="money form-control" name="preco" id="preco" 
                  value="<?php echo old('preco'); ?>">
          </div>   

          
          <div class="form-group col-md-4">
            <label for="">Produto customizável</label><a href="javascript:void" class="" data-toggle="popover" title="Produto meio a meio" data-content="Ex: Um produto customizavel pode ter mais de uma opção de sabores">&nbsp;Entenda a opção</a>

            <select class="form-control" name="customizavel">
               
            <option value="">Escolha..</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
                           
            </select>
          </div>
        </div>


        <button type="submit" class="btn btn-primary mt-4 mr-2 btn-sm">
          <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i> 
          Inserir especificação
        </button>

          <a href="<?php echo site_url("admin/produtos/show/$produto->id"); ?>" class="btn mt-4 btn-light btn-sm border-dark">
            voltar
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
          </a>

        <?php echo form_close(); ?>
        <hr class=" mt-5 mb-3">

        <div class="form-row">
          <div class="col-md-8">

            <?php if(empty($produtoEspecificacoes)): ?>
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Atenção!</h4>
                <p>Este produto não possui especificação até o momento, portanto ele <strong>Não</strong> será exibido como opção de compra.</p>
                <hr>
              <p class="mb-0">Aproveite para cadastrar uma especificação para o produto <strong><?php echo esc($produto->nome); ?></strong>.</p>
              </div>
            <?php else: ?>

              <h4 class="card-title">Especificações do produto</h4>
                  <p class="card-description">Aproveite para gerenciar as especificações</p>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Medida</th>
                          <th>Preço</th>
                          <th>Customizavel</th>
                          <th class="text-center">Remover</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php foreach($produtoEspecificacoes as $especificacao): ?>

                        <tr>
                          <td><?php echo esc($especificacao->medida); ?></td>
                          <td>R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2)); ?></td>
                          <td><?php echo ($especificacao->customizavel ? '<label class="badge badge-primary">Sim</label>' :  '<label class="badge badge-warning">Não</label>'); ?></td>
                          <td class="text-center" >
                          
                            <a href="<?php echo site_url("admin/produtos/excluirespecificacao/$especificacao->id/$especificacao->produto_id"); ?>" class="btn badge badge-danger">
                                  &nbsp;X&nbsp;
                            </a>
              
                          </td>

                        </tr>
                      
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                      <div class="mt-3">
                        <?php echo $pager->links() ?>
                      </div>
                  </div>
            <?php endif; ?>
            
          </div>
        </div>

    </div>
    </div>

  </div>
<?php echo $this->endsection() ?>





<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
  
  <!-- js do select 2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <!-- js me mascara de input -->
   <script src="<?php echo site_url('Admin/vendors/mask/app.js');?>"></script>
  <script src="<?php echo site_url('Admin/vendors/mask/jquery.mask.min.js');?>"></script>
  
  <script>
    $(function () {
      $('[data-toggle="popover"]').popover({
        placement: 'top',
        html: true, // Habilita html dentro do popover
      })
    })
  </script>
  
  <script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function(){
      $('.js-example-basic-single').select2({
        placeholder:'Digite o nome da medida ...',
        allowClear: false,

        "language":{
          "noResults": function(){
            return "Medida não encontrado &nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/medidas/criar'); ?>'>Cadastrar</a>"
          }
        },
        escapeMarkup: function(markup){
          return markup;
        }
      });
    });
  </script>

<?php echo $this->endsection() ?>


