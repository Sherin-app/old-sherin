<?php $__env->startSection('title', 'Default'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/chartist.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/select2.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<h3 class="text-left"><?php echo e(auth()->user()->store->name); ?></h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(url('dashboard/employe')); ?>"><?php echo e(trans('dashboard.dashboard')); ?></a></li>
    <li class="breadcrumb-item active"><a href="<?php echo e(route('employe.invoices')); ?>"><?php echo e(trans('Factures')); ?></a></li>
    <li class="breadcrumb-item active"><?php echo e(trans('Détails')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h3><?php echo e(trans('communs.Détail Facture')); ?> : <?php echo e(date("Y-m-d H:i:s")); ?> </h3>
				</div>
				<div class="card-body">
                
                    --------------------------------------------------------------------------------------------------------------
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $id=uniqid(); ?>
                    <div class="row" id="<?php echo e($id); ?>">
                        <div class="col-md-6">
                            <label for="validationServer01"><?php echo e($item->product->label); ?> | <?php echo e($item->product->price); ?> Mad </label>
                                <input type="hidden" name="products[]" value="<?php echo e($item->price); ?>">
                                
                        </div>
                        <div class="col-md-2">
                                <label for="validationServer02"><?php echo e(trans('communs.Prix')); ?></label>
                                <input class="form-control" value="<?php echo e($item->price); ?>" id="price_<?php echo e($id); ?>" type="text" name="price[]"  data-original-title="" title="<?php echo e(trans('communs.Prix')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="validationServer02"><?php echo e(trans('communs.Quantité')); ?></label>
                            <input class="form-control " id="qte_<?php echo e($id); ?>" value="<?php echo e($item->qte); ?>" type="number" name="quantity[]" required onchange="changeTotal(<?php echo e($item->price); ?>,this.value,<?php echo e(auth()->user()->store->tva); ?>)"  data-original-title="" title="<?php echo e(trans('communs.Quantité')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="validationServer02"><?php echo e(trans('communs.Supprimer')); ?></label>
                            <button class="form-control btn btn-primary " type="button" onclick="removeProductRow('<?php echo e($id); ?>','<?php echo e($item->price); ?>',$('#qte_<?php echo e($id); ?>').val(),'<?php echo e(auth()->user()->store->tva); ?>')" title="<?php echo e(trans('Supprimer Produit')); ?>">-</button>
                        </div>
                    </div>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div id="products-row">

                    </div>
                    --------------------------------------------------------------------------------------------------------------
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationServer02"><?php echo e(trans('communs.Description')); ?></label>
                            <textarea class="form-control " id="validationServer02" type="text" name="description"  title="<?php echo e(trans('communs.Description')); ?>"><?php echo e($invoice->description); ?></textarea>
                        </div>
                        <div class="col-md-6 ">
                            <br>
                              <div class="form-group">
                                <div class="checkbox checkbox-dark m-squar">
									<input id="inline-sqr-1" name="mode_payment" value="0" type="checkbox" checked>
									<label class="mt-0" for="inline-sqr-1" ><?php echo e(trans('communs.Espéces')); ?></label>
								</div>
                                <div class="checkbox checkbox-dark m-squar">
									<input id="inline-sqr-1" name="mode_payment" value="1" type="checkbox">
									<label class="mt-0" for="inline-sqr-1"><?php echo e(trans('communs.Carte Bancaire')); ?></label>
								</div>
                                <div class="checkbox checkbox-dark m-squar">
									<input id="inline-sqr-1" name="mode_payment" value="2" type="checkbox">
									<label class="mt-0" for="inline-sqr-1"><?php echo e(trans('communs.Chéque')); ?></label>
								</div>
                              </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="form-group">
                            <div class="checkbox checkbox-dark m-squar">
                                <input id="inline-sqr-1" name="use_points" type="checkbox">
                                <label class="mt-0" for="inline-sqr-1"><?php echo e(trans('communs.Utiliser la reduction ?')); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationServer02"><?php echo e(trans('communs.Total')); ?></label>
                            <input class="form-control " id="total" required type="text" readonly name="total" value="<?php echo e($invoice->total); ?>"  data-original-title="" title="<?php echo e(trans('communs.Montant Total')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer02"><?php echo e(trans('Montant Payé')); ?></label>
                                <input readonly class="form-control " id="to_paye" type="text" name="montant_paye" value="<?php echo e($invoice->paid_amount); ?>"  data-original-title="" title="<?php echo e(trans('communs.Montant â payer')); ?>">
                        </div>
                    </div>
                    <br>
                   
				</div>
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
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatable/datatable-extension/custom.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/select2/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/select2/select2-custom.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>