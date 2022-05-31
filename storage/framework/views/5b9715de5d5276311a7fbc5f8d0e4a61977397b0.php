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
    <li class="breadcrumb-item"><?php echo e(trans('dashboard.dashboard')); ?></li>
    <li class="breadcrumb-item active"><?php echo e(trans('Activitées')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<button class="btn btn-info" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" title="Nouveau Propriétaire">Nouveau</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        
                                        <th scope="col"><?php echo e(trans('Nom')); ?></th>
                                        <th scope="col"><?php echo e(trans('Description')); ?></th>
                                        <th scope="col"><?php echo e(trans('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e($item->name); ?></th>
                                        <td><?php echo e($item->description); ?></td>
                                        <td>
                                            <ul>
                                                <li><i class="fa fa-eye" data-toggle="modal" data-target=".bd-example-modal-lg-owner-<?php echo e($item->id); ?>"    title="<?php echo e(trans('Consulter')); ?>"></i></li>
                                                <li><a href="<?php echo e(url('/admin/activities/'.$item->id.'/edit')); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('Modifier')); ?>"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <div id="modal-owner" class="modal fade bd-example-modal-lg-owner-<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                           <div class="modal-content">
                                              <div class="modal-header">
                                                 <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Détail Activitée')); ?></h4>
                                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                                              </div>
                                              <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                                                                <input class="form-control"  readonly value="<?php echo e($item->name); ?>" title="<?php echo e(trans('Nom')); ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationServer02"><?php echo e(trans('Description')); ?></label>
                                                                <textarea class="form-control " readonly ><?php echo e($item->description); ?></textarea>
                                                            </div>
                                                        </div>
                                              </div>
                                              <button class="btn btn-primary"  data-dismiss="modal" aria-label="Close" data-original-title="" title=""><?php echo e(trans('Fermer')); ?></button>
                                           </div>
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
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Nouvelle activitée')); ?></h4>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
                <form action="<?php echo e(route('admin.store.activities')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                            <input class="form-control" id="validationServer01" name="name" type="text" value="" required="" data-original-title="" title="<?php echo e(trans('name')); ?>">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Description')); ?></label>
                            <textarea class="form-control" name="description" type="text" data-original-title="" title="<?php echo e(trans('description')); ?>"></textarea>
                            
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
    <script src="<?php echo e(asset('assets/js/datatable/datatables/datatable.custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/chartist/chartist.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/knob/knob.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/knob/knob-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/apex-chart/apex-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/chart/apex-chart/stock-prices.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dashboard/default.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/notify/index.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>