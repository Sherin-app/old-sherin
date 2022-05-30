<?php $__env->startSection('title', 'Default'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/chartist.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
     <h3 class="text-center"><?php echo e(auth()->user()->getFullNameAttribute()); ?></h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(url('dashboard/index')); ?>"><?php echo e(trans('dashboard.dashboard')); ?></a></li>
    <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.products')); ?>"><?php echo e(trans('Produits')); ?></a></li>
    <li class="breadcrumb-item active"><?php echo e(trans('Modification')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
                    <h2><?php echo e(trans('Modification Produit')); ?> <?php echo e($product->label); ?> </h2>
				</div>
				<div class="card-body">
                    <form action="<?php echo e(route('admin.products.update',$product->id)); ?>" method="POST" enctype='multipart/form-data'>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect9"><?php echo e(trans('Magasin')); ?></label>
                                    <select class="form-control digits" name="store_id" id="exampleFormControlSelect9">
                                        <option>-- <?php echo e(trans('Choisir')); ?> --</option>
                                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($product->store_id==$item->id): ?>
                                            <option value="<?php echo e($item->id); ?>" selected><?php echo e($item->name); ?></option>
                                            <?php else: ?> 
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01"><?php echo e(trans('libelle')); ?></label>
                                <input class="form-control " id="validationServer01" type="text" name="label" value="<?php echo e($product->label); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01"><?php echo e(trans('Prix de vente')); ?></label>
                                <input class="form-control " id="validationServer01" type="text" name="price" value="<?php echo e($product->price); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Prix d\'achat')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="promotion_price" value="<?php echo e($product->promotion_price); ?>" data-original-title="" title="<?php echo e(trans('Prix Promotion')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Quantité du stock')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="quantite" value="<?php echo e($product->quantite); ?>" data-original-title="" title="<?php echo e(trans('Quantité du stock')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Quantité du stock')); ?></label>
                                <input class="form-control " id="validationServer02" type="file" name="image" value="<?php echo e($product->image); ?>" data-original-title="" title="<?php echo e(trans('Quantité du stock')); ?>">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" data-original-title="" title=""><?php echo e(trans('Modifier')); ?></button>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>