
<?php echo $this->extend('layout/principal_web') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>

  <!-- Aqui enviamos os estilos para o template principal -->
  <link rel="stylesheet" href="<?php echo site_url("web/src/assets/css/produto.css"); ?>" />
<?php echo $this->endsection() ?>




<?php echo $this->section('conteudo') ?>
    <!-- Begin Sections-->

    <div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">

        <div class="col-sm-12 col-md-12 col-lg-12">
            <!-- product -->
            <div class="product-content product-wrap clearfix product-deatil">
                <div class="row">
                    
                    <!-- mensagem de error na tela  -->
                    <?php if(session()->has('errors_model')): ?>
                    <ul>
                        <?php foreach(session('errors_model') as $error): ?>
                        <li class="text-danger"><?php echo  $error;?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="product-image">
                            <img src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>" />
                        </div>
                    </div>

                <?php echo form_open("carrinho/adicionar");?>
                    <div class="col-md-6 col-md-offset-1 col-sm-12 col-xs-12">
                        <h2 class="name">
                            <?php echo esc($produto->nome); ?>
                        </h2>
                        <hr />

                        <h3 class="price-container">


                            <hr>
                            <div class="text-center">
                                <h4>Medidas</h4>
                            </div>

                            <?php foreach($especificacoes as $especificacao): ?>

                                <div class="radio">
                                    <label style="font-size: 16px;" >
                                        <input type="radio" style="margin-top: 2px" class="especificacao" data-especificacao="<?php echo $especificacao->especificacao_id ?>"
                                                name="produto[preco]" value="<?php echo $especificacao->preco; ?>">
                                                <?php echo esc($especificacao->nome);?>
                                                <?php echo esc(number_format($especificacao->preco, 2));?>
                                    </label>
                                </div>

                            <?php endforeach; ?>

                            <?php if(isset($extras)):?>
                                <hr>
                                <div class="text-center">
                                    <h4>extras</h4>
                                </div>

                                <div class="radio">
                                    <label style="font-size: 16px;" >
                                        <input type="radio" class="extra" name="extra" checked=""> Sem extra
                                    </label>
                                </div>

                                <?php foreach($extras as $extra): ?>

                                    <div class="radio">
                                        <label style="font-size: 16px;">
                                            <input type="radio" style="margin-top: 2px" class="extra" data-extra="<?php echo $extra->id_principal; ?>"
                                                    name="extra" value="<?php echo $extra->preco; ?>">
                                                    <?php echo esc($extra->nome);?>
                                                    <?php echo esc(number_format($extra->preco, 2));?>
                                        </label>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif;?>
                            
                        </h3>
       
                        <div class="row" style="margin-top: 4rem" >
                            <div class="col-md-4">
                                <label for="">Quantidade</label>
                                <input type="number" placeholder="Quantidade" class="form-control" name="produto[quantidade]" value="1" min="1" max="10" step="1" required="">
                            </div>
                        </div>

                        <hr />
                        <div class="description description-tabs">
                           
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in" style="font-size: 16px" id="more-information">
                                    <br />
                                    <strong>Descrição</strong>
                                    <p>
                                    <?php echo esc($produto->ingredientes); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr />

                        <div>
                            <!--  Campos hidden que usaremos no controller  -->
                            <input type="text" name="produto[slug]" placeholder="produto[slug]" value="<?php echo $produto->slug;  ?>">
                            <input type="text" id="especificacao_id" name="produto[especificacao_id]" placeholder="produto[especificacao_id]">
                            <input type="text" id="extra_id"    name="produto[extra_id]" placeholder="produto[extra_id]">

                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <input id="btn-adiciona" type="submit" class="bt btn-success btn" value="Carrinho" >
                            </div>
                    
                            <?php foreach($especificacoes as $especificacao): ?>

                                <?php if($especificacao->customizavel):  ?>

                                    <div class="col-sm-4">
                                        <a href="<?php echo site_url("produto/customizar/$produto->slug");?>" class="btn btn-primary btn">Customizar</a>
                                    </div>
                                    
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
  
                            <div class="col-sm-4">
                                <a href="<?php echo site_url("/");?>" class="btn btn-info btn">Continuar comprando</a>
                            </div>
                        </div>

                    </div>
                <?php echo form_close();?>

                </div>
            </div>
            <!-- end product -->
        </div>
    </div>
    <!-- End Sections -->


<?php echo $this->endsection() ?>




<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
  <script>
      $(document).ready(function(){
        var especificacao_id;

        if(!especificacao_id){

            $("#btn-adiciona").prop("disabled", true);

            $("#btn-adiciona").prop("value", "Selecione um valor");

        }

        $(".especificacao").on('click', function(){
            especificacao_id = $(this).attr('data-especificacao');

            $("especificacao_id").val(especificacao_id);

            
            $("#btn-adiciona").prop("disabled", false);

            $("#btn-adiciona").prop("value", "Carrinho");

        });

        $(".extra").on('click', function(){
            extra_id = $(this).attr('data-extra');

            $("#extra_id").val(extra_id);

         
        });
      });
  </script>
  
<?php echo $this->endsection() ?>
      
