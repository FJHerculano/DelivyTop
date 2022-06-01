<?php echo $this->extend('layout/principal_web') ?> 

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?> <?php echo $this->endsection() ?>

<?php echo $this->section('estilos') ?>
  <!-- Aqui enviamos os estilos para o template principal -->
<?php echo $this->endsection() ?>




<?php echo $this->section('conteudo') ?>
  <!-- Begin Sections-->

        <!--    Menus   -->
        <div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
            <div class="title-block">
                <h1 class="section-title">Nosso cardapio</h1>
            </div>

            <!--    Menus filter    -->
            <div class="menu_filter text-center">
                <ul class="list-unstyled list-inline d-inline-block">
                    
                        <li id="todas" class="item active">
                            <a href="javascript:;" class="filter-button" data-filter="todas">Todas</a>
                        </li>
                    <?php foreach($categorias as  $categoria): ?>
                        <li class="item">
                            <a href="javascript:;" class="filter-button" data-filter="<?php echo $categoria->slug?>"><?php echo esc($categoria->nome);?></a>
                        </li>
                    <?php endforeach;?>
                    
                </ul>
            </div> 

            <!--    Menus items     -->
            <div id="menu_items">

                <div class="row"> 
                    <?php foreach($produtos as  $produto): ?>
                        <div class="col-sm-6 filtr-item image filter active <?php echo $produto->categoria_slug; ?>">

                            <a href="<?php echo site_url("produto/detalhes/$produto->slug"); ?>" class="block fancybox" data-fancybox-group="fancybox" >
                                <div class="content">
                                    <div class="filter_item_img">
                                        <i class="fa fa-search-plus"></i>
                                        <img src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>" />
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo esc($produto->nome); ?></div>
                                        <div class="short"><?php echo word_limiter($produto->ingredientes, 5) ?></div>
                                        <span class="filter_item_price">À partir de R$&nbsp;<?php echo esc(number_format($produto->preco)); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>


                <div class="text-center">
                    <!-- BEGIN pagination -->
                    <ul class="pagination">
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                    </ul>
                    <!-- END pagination -->
                </div>

            </div>
        </div>



        <!-- End Sections -->


<?php echo $this->endsection() ?>




<?php echo $this->section('scripts') ?>
  <!-- Aqui enviamos os scripts para o template principal -->
<?php echo $this->endsection() ?>
      