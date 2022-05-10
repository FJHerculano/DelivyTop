
<div class="form-row ">

    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" 
               value="<?php echo old('nome', esc($medida->nome)); ?>">
    </div>       
    
    <div class="form-group col-md-12">
        <label for="descricao">Descricao</label>
        <textarea name="descricao" id="descricao" class="form-control" rows="3"><?php echo old('descricao', esc($medida->descricao)); ?></textarea>
    </div>   

</div> 


<div class="form-check form-check-flat form-check-primary mb-3">
    <label for="ativo" class="form-check-label">

        <input type="hidden" name="ativo" value="0">

        <input class="form-check-input" type="checkbox" id="ativo"  name="ativo" 
               value="1" <?php if(old('ativo', $medida->ativo)): ?> checked="" <?php endif; ?>>
        Ativo
    </label>
</div>  


<button type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-check btn-icon-prepend"></i>
    Salvar
</button>

