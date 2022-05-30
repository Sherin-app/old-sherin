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
    <li class="breadcrumb-item active"><?php echo e(trans('Infos Personnelles')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form action="<?php echo e(route('personal.info.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validationServer01"><?php echo e(trans(' Prénom')); ?></label>
                                <input class="form-control" id="validationServer02" type="text" name="firstname" value="<?php echo e(auth()->user()->firstname); ?>"  required="" data-original-title="" title="<?php echo e(trans('Nom')); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Nom')); ?></label>
                                <input class="form-control" id="validationServer02" type="text" name="lastname" value="<?php echo e(auth()->user()->lastname); ?>"  required="" data-original-title="" title="<?php echo e(trans('Prénom')); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                                <input class="form-control" id="validationServer02" type="text" name="phone" value="<?php echo e(auth()->user()->phone); ?>"  required="" data-original-title="" title="<?php echo e(trans('Téléphone')); ?>">
                                
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationServer02"><?php echo e(trans('E-mail')); ?></label>
                                <input class="form-control" id="validationServer02" type="text" name="email" value="<?php echo e(auth()->user()->email); ?>"  required="" data-original-title="" title="<?php echo e(trans('E-mail')); ?>">
                                
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" data-original-title="" title=""><?php echo e(trans('Enregistrer')); ?></button>
                    </form>
				</div>
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