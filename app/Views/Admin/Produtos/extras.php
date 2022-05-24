<?php echo $this->extend('Admin/layout/principal') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal --> 
  
  <!-- select 2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
        <?php echo form_open("admin/produtos/cadastrarextras/$produto->id"); ?>

        <div class="form-row ">
          <div class="form-group col-md-6">
            <label for="">Escolha o extra do produto (opcional)</label>
            <select name="extra_id"  class="form-control js-example-basic-single">
               
              <option value="">Escolha um extra</option>
              
              <?php foreach($extras as $extra): ?>
                <option value="<?php echo $extra->id ?>"><?php echo esc($extra->nome); ?></option>
              <?php endforeach; ?>

            </select>
          </div>
        </div>


        <button type="submit" class="btn btn-primary mr-2 btn-sm">
          <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i> 
          Inserir extra
        </button>

          <a href="<?php echo site_url("admin/produtos/show/$produto->id"); ?>" class="btn btn-light btn-sm border-dark">
            voltar
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
          </a>

        <?php echo form_close(); ?>
        <hr class=" mt-5 mb-3">

        <div class="form-row">
          <div class="col-md-8">

            <?php if(empty($produtoExtras)): ?>
              <p>Esse produto não possui extras até o momento</p>

            <?php else: ?>

              <h4 class="card-title">Extras do produto</h4>
                  <p class="card-description">Aproveite para gerenciar os extras</p>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Extra</th>
                          <th>Preço</th>
                          <th class="text-center">Remover</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php foreach($produtoExtras as $extraProduto): ?>

                        <tr>
                          <td><?php echo esc($extraProduto->extra); ?></td>
                          <td>R$&nbsp;<?php echo esc(number_format($extraProduto->preco, 2)); ?></td>

                          <td class="text-center" >

                            <?php echo form_open("admin/produtos/excluirextra/$extraProduto->id/$extraProduto->produto_id"); ?>
                            <button class="btn badge badge-danger">&nbsp;X&nbsp;</button>
                            <?php echo form_close(); ?>

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

  <script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function(){
      $('.js-example-basic-single').select2({
        placeholder:'Digite o nome do extra ...',
        allowClear: false,

        "language":{
          "noResults": function(){
            return "Extra não encontrado &nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/extras/criar'); ?>'>Cadastrar</a>"
          }
        },
        escapeMarkup: function(markup){
          return markup;
        }
      });
    });
  </script>

<?php echo $this->endsection() ?>


