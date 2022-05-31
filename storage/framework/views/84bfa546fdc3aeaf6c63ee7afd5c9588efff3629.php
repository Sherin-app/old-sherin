<?php $__env->startSection('title', 'Default'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/chartist.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<h3 class="text-left"><?php echo e(auth()->user()->getFullNameAttribute()); ?></h3>
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label></label>
                                <button class="btn btn-info" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" title="Nouveau Magasin">Nouveau</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <form id="importList" action="<?php echo e(route('admin.import.products')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <input type="hidden" id="store_id_hidden" name="store">
                                        <div class="col-md-4">
                                            <select class="form-control digits" name="store_id" id="store_id">
                                                <option>-- <?php echo e(trans('Choisir Magasin')); ?> --</option>
                                                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="custom-file">
                                                <input type="file" id="file" name="products" class="form-control" required>
                                                <span class="custom-file-control"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" onclick="importProducts($('#store_id').val())" class="btn btn-info"><?php echo e(trans('Importer')); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display datatables" id="render-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('libellé')); ?></th>
                                    <th><?php echo e(trans('Magasin')); ?></th>
                                    <th><?php echo e(trans('Prix')); ?></th>
                                    <th><?php echo e(trans('Promotion')); ?></th>
                                    <th><?php echo e(trans('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($item->label); ?></th>
                                    <td><?php echo e(!empty($item->store)? $item->store->name : ''); ?></td>
                                    <td><?php echo e($item->price); ?></td>
                                    <td><?php echo e($item->promotion_price); ?></td>
                                    <td>
                                        <ul>
                                            <li><i class="fa fa-eye" data-toggle="modal" data-target=".bd-example-modal-lg-product-<?php echo e($item->id); ?>" title="<?php echo e(trans('Consulter')); ?>"></i></li>
                                            <li><a href="<?php echo e(url('/admin/products/'.$item->id.'/edit')); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('Modifier')); ?>"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <div id="modal-owner" class="modal fade bd-example-modal-lg-product-<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Détail Produit')); ?></h4>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect9"><?php echo e(trans('Libellé')); ?></label>
                                                            <input readonly class="form-control " id="validationServer02" type="text" value="<?php echo e($item->label); ?>" data-original-title="" title="<?php echo e(trans('Libellé')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer02"><?php echo e(trans('Magasin')); ?></label>
                                                        <input readonly class="form-control " id="validationServer02" type="text" value="<?php echo e(!empty($item->store) ?  $item->store->name : ''); ?>" data-original-title="" title="<?php echo e(trans('Magasin')); ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect9"><?php echo e(trans('Prix')); ?></label>
                                                            <input readonly class="form-control " id="validationServer01" type="text" value="<?php echo e($item->price); ?>" required="" data-original-title="" title="<?php echo e(trans('Prix Produit')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer01"><?php echo e(trans('Prix d\'achat')); ?></label>
                                                        <input readonly class="form-control " id="validationServer01" type="text" value="<?php echo e($item->promotion_price); ?>" required="" data-original-title="" title="<?php echo e(trans('Prix Promotion')); ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationServer01"><?php echo e(trans('Quantité')); ?></label>
                                                        <input readonly class="form-control " id="validationServer01" type="text" name="quantite" value="<?php echo e($item->quantite); ?>" required="" data-original-title="" title="<?php echo e(trans('Prix Promotion')); ?>">
                                                    </div>

                                                </div>
                                                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><?php echo e(trans('Fermer')); ?></button>
                                            </div>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Nouveau Produit')); ?></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('admin.products.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect9"><?php echo e(trans('Magasin')); ?></label>
                                <select class="form-control digits" name="store_id" id="exampleFormControlSelect9">
                                    <option>-- <?php echo e(trans('Choisir')); ?> --</option>
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('libelle')); ?></label>
                            <input class="form-control " id="validationServer01" type="text" name="label" required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Prix')); ?></label>
                            <input class="form-control " id="validationServer01" type="text" name="price" required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02"><?php echo e(trans('Prix d\'achat')); ?></label>
                            <input class="form-control " id="validationServer02" type="text" name="promotion_price" data-original-title="" title="<?php echo e(trans('Prix d\'achat')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01"><?php echo e(trans('Quantité')); ?></label>
                            <input readonly class="form-control " id="validationServer01" type="text" name="quantite"  required="" data-original-title="" title="<?php echo e(trans('La quantité')); ?>">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" data-original-title="" title=""><?php echo e(trans('Enregistrer')); ?></button>
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
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.js²')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
<script>
    function importProducts(store_id) {
        if (store_id != 0) {
            $('#store_id_hidden').attr('value', store_id);
            $('#importList').submit();
        } else {
            alert('Vous devez selectionnez un magasin!')
        }

    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>