
<div class="form-row">

    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" 
               value="<?php echo old('nome', esc($categoria->nome)); ?>">
    </div>   

</div>


<div class="form-check form-check-flat form-check-primary mb-3">
    <label for="ativo" class="form-check-label">

        <input type="hidden" name="ativo" value="0">

        <input class="form-check-input" type="checkbox" id="ativo"  name="ativo" 
               value="1" <?php if(old('ativo', $categoria->ativo)): ?> checked="" <?php endif; ?>>
        Ativo
    </label>
</div>  


<button type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-check btn-icon-prepend"></i>
    Salvar
</button>

