<?php $__env->startSection('title', 'Default'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/simple-mde.css')); ?>">
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
    <li class="breadcrumb-item"><?php echo e(trans('dashboard.dashboard')); ?></li>
    <li class="breadcrumb-item active"><?php echo e(trans('Magasin')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h2><?php echo e(trans('Modification Magasin')); ?> <?php echo e($store->name); ?></h2>
				</div>
				<div class="card-body">
                <form action="<?php echo e(route('admin.stores.update',$store->id)); ?>" method="POST" enctype='multipart/form-data'>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect9">Activitées</label>
                                <select class="form-control digits" name="activity_id" id="exampleFormControlSelect9">
                                    <option>-- <?php echo e(trans('Choisir')); ?> --</option>
                                    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->id==$store->activity_id): ?>
                                        <option value="<?php echo e($store->activity_id); ?>" selected ><?php echo e($item->name); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect9">Propriétaire</label>
                                <select class="form-control digits" name="owner_id" id="exampleFormControlSelect9">
                                <option>-- <?php echo e(trans('Choisir')); ?> --</option>
                                <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->id==$store->user_id): ?>
                                    <option value="<?php echo e($store->user_id); ?>" selected ><?php echo e($item->getFullNameAttribute()); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                            <input   class="form-control " id="validationServer01" name="store_name" type="text" value="<?php echo e($store->name); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Sender Id')); ?></label>
                            <input   class="form-control " id="validationServer01" name="sender_id" type="text" value="<?php echo e($store->sender_id); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Contact')); ?></label>
                            <input   class="form-control " id="validationServer02" type="text" value="<?php echo e($store->contact); ?>" name="contact" data-original-title="" title="<?php echo e(trans('Contact du Magasin')); ?>">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Addresse')); ?></label>
                            <textarea class="form-control " id="validationServer01" type="text" name="address"   data-original-title="" title="<?php echo e(trans('Addresse Magasin')); ?>"><?php echo e($store->address); ?></textarea>
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                            <input   class="form-control " id="validationServer02" type="text" name="phone" value="<?php echo e($store->phone); ?>" data-original-title="" title="<?php echo e(trans('Téléphone Magasin')); ?>">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Logo')); ?></label>
                            <img src="<?php echo e(($store->logo)!='' ? asset(getImageByModel($store->id,'stores',$store->logo)):'xxxxx'); ?>" width="25" height="25">
                            <input class="form-control" name="logo" type="file" data-original-title="" title="<?php echo e(trans('Logo Magasin')); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Base de calcul de la réduction')); ?></label>
                            <input   class="form-control " id="validationServer02" type="text" name="base_calcul" value="<?php echo e($store->base); ?>"  required="" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Réduction suivant la base')); ?></label>
                            <input   class="form-control " id="validationServer02" type="text" name="base_profit" value="<?php echo e($store->base_profit); ?>" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Coéfficient (points)')); ?></label>
                            <input class="form-control " id="validationServer02" type="text" name="coeff"  value="<?php echo e($store->coeff); ?>" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('TVA')); ?></label>
                            <input class="form-control " id="validationServer02" type="text" name="tva" value="<?php echo e($store->tva); ?>"  data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label for="validationServer02"><?php echo e(trans('Remerciement Facture')); ?></label>
                            <div id="editor_container">
                                <textarea id="editable" name="message_invoice">
                                    <?php echo e($store->invoice_message); ?>

                                </textarea>
                            </div>
                            <div id="html_container"></div>
                        </div>
                        
                        <div class="col-md-2"></div>
                    </div>
                    <button class="btn btn-primary" type="submit" data-original-title="" title="<?php echo e(trans('Modifier')); ?>"><?php echo e(trans('Modifier')); ?></button>
                </form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/js/editor/simple-mde/simplemde.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/editor/simple-mde/simplemde.custom.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>