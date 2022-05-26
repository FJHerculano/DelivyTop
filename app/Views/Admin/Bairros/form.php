
<div class="form-row ">

    <?php if(!$bairro->id): ?>
        
        <div class="form-group col-md-12">
            <label for="cep">CEP</label>
            <input type="text" class="cep form-control" name="cep" id="cep" 
                value="<?php echo old('cep', esc($bairro->cep)); ?>">
        </div>   

    <?php endif; ?>

    <div class="form-group col-md-12">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" 
               value="<?php echo old('nome', esc($bairro->nome)); ?>" readonly="" >
    </div>   

    <div class="form-group col-md-12">
        <label for="valor_entrega">Valor de entrega</label>
        <input type="text" class="form-control money" name="valor_entrega" id="valor_entrega" 
               value="<?php echo old('valor_entrega', esc(number_format($bairro->valor_entrega, 2))); ?>">
    </div>   


    <div class="form-group col-md-12">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" name="cidade" id="cidade" 
               value="<?php echo old('cidade', esc($bairro->cidade)); ?>" readonly="">
    </div> 


    
    <?php if(!$bairro->id): ?>
        
        <div class="form-group col-md-12">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" name="estado" id="estado" 
                   value="<?php echo old('estado', esc($bairro->estado)); ?>" readonly="">
        </div>   

    <?php endif; ?>

 

</div>


<div class="form-check form-check-flat form-check-primary mb-3">
    <label for="ativo" class="form-check-label">

        <input type="hidden" name="ativo" value="0">

        <input class="form-check-input" type="checkbox" id="ativo"  name="ativo" 
               value="1" <?php if(old('ativo', $bairro->ativo)): ?> checked="" <?php endif; ?>>
        Ativo
    </label>
</div>  


<button id="btn-salvar" type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-check btn-icon-prepend"></i>
    Salvar
</button>

