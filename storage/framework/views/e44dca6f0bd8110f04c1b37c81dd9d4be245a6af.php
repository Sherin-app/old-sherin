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
    <li class="breadcrumb-item active"><?php echo e(trans('Propriétataires')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<button class="btn btn-info" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" title="<?php echo e(trans('Nouveau Propriétaire')); ?>"><?php echo e(trans('Nouveau')); ?></button>
				</div>
				<div class="card-body">
					<table class="display" id="export-button">
                        <thead>
                            <tr>
                                <th><?php echo e(trans('Nom')); ?></th>
                                <th><?php echo e(trans('Prénom')); ?></th>
                                <th><?php echo e(trans('Téléphone')); ?></th>
                                <th><?php echo e(trans('E-mail')); ?></th>
                                <th><?php echo e(trans('Active')); ?></th>
                                
                                <th><?php echo e(trans('Action')); ?></th>
                            </tr>
                        </thead>
                       <tbody>
                           <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <tr>
                                   <td><?php echo e($item->firstname); ?></td>
                                   <td><?php echo e($item->lastname); ?></td>
                                   <td><?php echo e($item->phone); ?></td>
                                   <td><?php echo e($item->email); ?></td>
                                   <td><?php echo e(($item->is_active)==0?'Non':'Oui'); ?></td>
                                   
                                   <td>
                                       <ul>
                                            <li><i class="fa fa-eye" data-toggle="modal" data-target=".bd-example-modal-lg-owner-<?php echo e($item->id); ?>"    title="<?php echo e(trans('Consulter')); ?>"></i></li>
                                            <li><a href="<?php echo e(url('/admin/owners/'.$item->id.'/edit')); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('Modifier')); ?>"></i></a></li>
                                            <?php if($item->is_active==1): ?>
                                            <li><a href="<?php echo e(url('/admin/owners/'.$item->id.'/delete')); ?>"><i class="fa fa-trash"  title="<?php echo e(trans('Supprimer')); ?>"></i></a></li>
                                            <?php else: ?> 
                                            <li><a href="<?php echo e(url('/admin/owners/'.$item->id.'/active')); ?>"><i class="fa fa-check"  title="<?php echo e(trans('Activer')); ?>"></i></a></li>
                                            <?php endif; ?>
                                        </ul>
                                   </td>
                               </tr>
                               <div id="modal-owner" class="modal fade bd-example-modal-lg-owner-<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Détail Propriétataire')); ?></h4>
                                         <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                                                        <input class="form-control"  readonly value="<?php echo e($item->firstname); ?>" title="<?php echo e(trans('Nom')); ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer02"><?php echo e(trans('Prénom')); ?></label>
                                                        <input class="form-control " readonly value="<?php echo e($item->lastname); ?>"  title="<?php echo e(trans('Prénom')); ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer01"><?php echo e(trans('E-mail')); ?></label>
                                                        <input class="form-control"  readonly value="<?php echo e($item->email); ?>"  title="<?php echo e(trans('E-mail')); ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                                                        <input class="form-control" readonly value="<?php echo e($item->phone); ?>" title="<?php echo e(trans('Téléphone')); ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label" for="invalidCheck3"><?php echo e(trans('Données Partagées')); ?>: <?php echo e($item->allow_share); ?> </label>
                                                    </div>
                                                </div>
                                      </div>
                                   </div>
                                   <button class="btn btn-primary"  data-dismiss="modal" aria-label="Close" data-original-title="" title=""><?php echo e(trans('Fermer')); ?></button>
                                </div>
                             </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       </tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal-owner" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Nouveau Propriétataire')); ?></h4>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
                <form action="<?php echo e(route('admin.store.owner')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                            <input class="form-control" id="validationServer01" type="text" name="firstname" value="<?php echo e(old('firstname')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Prénom')); ?>">
                            <?php if($errors->has('firstname')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('firstname')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Prénom')); ?></label>
                            <input class="form-control " id="validationServer02" type="text" name="lastname" value="<?php echo e(old('lastname')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom')); ?>">
                            <?php if($errors->has('lastname')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('lastname')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('E-mail')); ?></label>
                            <input class="form-control" id="validationServer01" type="text" name="email" value="<?php echo e(old('email')); ?>"  required="" data-original-title="" title="<?php echo e(trans('E-mail')); ?>">
                            <?php if($errors->has('email')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('email')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                            <input class="form-control" id="validationServer02" type="text" name="phone" value="<?php echo e(old('phone')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Téléphone')); ?>">
                            <?php if($errors->has('phone')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('phone')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Mot de passe')); ?></label>
                            <input class="form-control" id="validationServer01" type="password" name="password" required="" data-original-title="" title="Mot de passe">
                            <div class="show-hide"><span class="show"></span></div>
                            <?php if($errors->has('password')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('password')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Confirmation')); ?></label>
                            <input class="form-control" id="validationServer02" type="password" name="password-confirmation"  required="" data-original-title="" title="Confirmation du mot de passe">
                            <div class="show-hide"><span class="show"></span></div>
                            <?php if($errors->has('password-confirmation')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('password-confirmation')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input is-invalid" name="allow_share" id="invalidCheck3" type="checkbox" value="1" data-original-title="" title="">
                            <label class="form-check-label" for="invalidCheck3"><?php echo e(trans('Permettre le partage des clients entre mes magasins')); ?> ?</label>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" data-original-title="" title="<?php echo e(trans('Enregistrer')); ?>"><?php echo e(trans('Enregistrer')); ?></button>
                </form>
          </div>
       </div>
    </div>
 </div>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.select.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/custom.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php if($errors->any()): ?>
<script>
    $('.modal').modal("show");
</script>
<?php endif; ?>
<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>