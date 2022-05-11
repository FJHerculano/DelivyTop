
<div class="form-row ">

    <div class="form-group col-md-12">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" 
               value="<?php echo old('nome', esc($produto->nome)); ?>">
    </div>   

    <div class="form-group col-md-12">
        <label for="categoria_id">Categoria</label>
        <select class="custom-select" name="categoria_id" >
            <option value="">Escolha a categoria ...</option>
            
            <?php foreach($categorias as $categoria): ?>
                <!--Se possui id, tem que identificar qual categoria ta atrelada ao produto-->
                <?php if($produto->id): ?>

                    <option value="<?php echo $categoria->id; ?>" <?php echo($categoria->id == $produto->categoria_id ? 'selected' : '' ); ?>> <?php echo esc($categoria->nome); ?></option>
               
                <?php else: ?>

                    <option value="<?php echo $categoria->id; ?>" > <?php echo esc($categoria->nome); ?></option>

                <?php endif;?>

            <?php endforeach; ?>

        </select>
    </div>       
    
    <div class="form-group col-md-12">
        <label for="ingredientes">Ingredientes</label>
        <textarea name="ingredientes" id="ingredientes" class="form-control" rows="3"><?php echo old('ingredientes', esc($produto->ingredientes)); ?></textarea>
    </div>   

</div>


<div class="form-check form-check-flat form-check-primary mb-3">
    <label for="ativo" class="form-check-label">

        <input type="hidden" name="ativo" value="0">

        <input class="form-check-input" type="checkbox" id="ativo"  name="ativo" 
               value="1" <?php if(old('ativo', $produto->ativo)): ?> checked="" <?php endif; ?>>
        Ativo
    </label>
</div>  


<button type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-check btn-icon-prepend"></i>
    Salvar
</button>

