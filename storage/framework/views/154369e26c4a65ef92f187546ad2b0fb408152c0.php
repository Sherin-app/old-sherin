
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/select2.css')); ?>">
<script src="<?php echo e(asset('assets/js/select2/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/select2/select2-custom.js')); ?>"></script>
<?php $id=uniqid()?>
<br>
 
<div class="row" id="<?php echo e($id); ?>">
    <div class="col-md-6">
        <label for="validationServer01"><?php echo e(trans('communs.Produit')); ?> : :</label>
        <select class="js-example-basic-single col-sm-12" onchange="setPriceProduct(this, this.value,'<?php echo e($id); ?>')"  name="products[]">
           <option data-tokens="0">--- <?php echo e(trans('communs.Choisir Produit/Service')); ?> ---</option>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id); ?>">
                <?php echo e($item->label); ?> | <?php echo e($item->price); ?> Mad </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-2">
            <label for="validationServer02"><?php echo e(trans('communs.Prix')); ?></label>
            <input class="form-control prices" value="0"  id="price_<?php echo e($id); ?>" readonly type="text" name="price[]"  data-original-title="" title="<?php echo e(trans('Prix Produit')); ?>">
    </div>
    <div class="col-md-2 row">
        <div class="row">
                <div class="col-md-8">
                    <label for="validationServer02"><?php echo e(trans('communs.Quantité')); ?></label>
                    <input class="form-control qts" id="qte_<?php echo e($id); ?>" type="number" min="1" value="1" onchange="changeTotalOnce()" name="quantity[]"  required  data-original-title="" title="<?php echo e(trans('communs.Quantité')); ?>">
                </div>
                <div class="col-md-4 " style="margin-left: 75px!important;margin-top: -47px;" >
                   <div class="row" style="margin-top: -5px!important">
                        <span class="btn btn-primary" onclick="changeQuantity('<?php echo e($id); ?>',1)" style="width: 5px!important;height:25px!important">+</span>
                    </div>
                    <p></p>
                    <div class="row">
                        <span class="btn btn-primary" onclick="changeQuantity('<?php echo e($id); ?>',-1)" style="width: 5px!important;height:25px!important">-</span>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-2">
        <label for="validationServer02"><?php echo e(trans('communs.Supprimer P/S')); ?></label>
        <button class="form-control btn btn-primary " type="button" onclick="removeProductRow('<?php echo e($id); ?>')" title="<?php echo e(trans('communs.Supprimer Produit')); ?>">-</button>
    </div>
</div>
