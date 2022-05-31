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
    <li class="breadcrumb-item active"><?php echo e(trans('Employés')); ?></li>
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
						<table class="display datatables" id="render-datatable">
							<thead>
								<tr>
									<th><?php echo e(trans('Magasin')); ?></th>
									<th><?php echo e(trans('Prénom')); ?></th>
									<th><?php echo e(trans('Nom')); ?></th>
									<th><?php echo e(trans('E-mail')); ?></th>
									<th><?php echo e(trans('Téléphone')); ?></th>
									<th><?php echo e(trans('Action')); ?></th>
								</tr>
							</thead>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($item->store->name); ?></th>
                                    <td><?php echo e($item->firstname); ?></td>
                                    <td><?php echo e($item->lastname); ?></td>
                                    <td><?php echo e($item->email); ?></td> 
                                    <td><?php echo e($item->phone); ?></td> 
                                    <td>
                                        <ul>
                                            <li><i class="fa fa-eye" data-toggle="modal" data-target=".bd-example-modal-lg-employe-<?php echo e($item->id); ?>"    title="<?php echo e(trans('Consulter')); ?>"></i></li>
                                            <li><a href="<?php echo e(url('/admin/employees/'.$item->id.'/edit')); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('Modifier')); ?>"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <div id="modal-owner" class="modal fade bd-example-modal-lg-employe-<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Détail D\'employer')); ?></h4>
                                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                                          </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect9"><?php echo e(trans('Nom')); ?></label>
                                                                <input readonly class="form-control " id="validationServer02" type="text" value="<?php echo e($item->firstname); ?>" data-original-title="" title="<?php echo e(trans('Libellé')); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationServer02"><?php echo e(trans('Prénom')); ?></label>
                                                            <input readonly class="form-control " id="validationServer02" type="text" value="<?php echo e($item->lastname); ?>" data-original-title="" title="<?php echo e(trans('Magasin')); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect9"><?php echo e(trans('E-mail')); ?></label>
                                                                <input readonly class="form-control " id="validationServer01" type="text" value="<?php echo e($item->email); ?>"  required="" data-original-title="" title="<?php echo e(trans('Prix Produit')); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationServer01"><?php echo e(trans('Téléphone')); ?></label>
                                                            <input readonly class="form-control " id="validationServer01" type="text" value="<?php echo e($item->phone); ?>"  required="" data-original-title="" title="<?php echo e(trans('Prix Promotion')); ?>">
                                                        </div>
                                                        
                                                    </div>
                                                    <button class="btn btn-primary"  data-dismiss="modal" aria-label="Close" data-original-title="" title=""><?php echo e(trans('Fermer')); ?></button>
                                                </div>
                                       </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
						</table>
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
             <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Nouveau Employé')); ?></h4>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
                <form action="<?php echo e(route('admin.employees.store')); ?>" method="POST">
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
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Magasin')); ?></label>
                            <select class="form-control digits" name="store_id" id="store_id">
                                <option>-- <?php echo e(trans('Choisir Magasin')); ?> --</option>
                                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            
                        </div>
                        <div class="col-md-6 mb-3 row">
                            <div class="col-md-4 mb-4">
                                <label for="validationServer01"><?php echo e(trans('O.Quotidien')); ?></label>
                                <input class="form-control" id="validationServer01" type="text" name="dayli" value="<?php echo e(old('dayli')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Ojective Quotidien ')); ?>">
                                <?php if($errors->has('firstname')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('dayli')); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationServer01"><?php echo e(trans('O.Hébdomadaire')); ?></label>
                                <input class="form-control" id="validationServer01" type="text" name="weekly" value="<?php echo e(old('weekly')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Objective Hébdomadiare')); ?>">
                                <?php if($errors->has('firstname')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('weekly')); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationServer01"><?php echo e(trans('O.Mensuel')); ?></label>
                                <input class="form-control" id="validationServer01" type="text" name="monthly" value="<?php echo e(old('monthly')); ?>"  required="" data-original-title="" title="<?php echo e(trans('Objective Mensuel')); ?>">
                                <?php if($errors->has('firstname')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('monthly')); ?></div>
                            <?php endif; ?>
                            </div>
                            
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