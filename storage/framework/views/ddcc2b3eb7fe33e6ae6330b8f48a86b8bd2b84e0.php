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
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                            title="Nouveau Magasin">Nouveau</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display datatables" id="render-datatable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('Nom')); ?></th>
                                        <th><?php echo e(trans('Propriétaire')); ?></th>
                                        <th><?php echo e(trans('Sender Id')); ?></th>
                                        <th><?php echo e(trans('Activitée')); ?></th>
                                        <th><?php echo e(trans('TVA')); ?></th>
                                        <th><?php echo e(trans('Téléphone')); ?></th>
                                        <th><?php echo e(trans('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row"><?php echo e($item->name); ?></th>
                                            <td><?php echo e($item->owner->firstname); ?></td>
                                            <td><?php echo e($item->sender_id); ?></td>
                                            <td><?php echo e($item->activity->name); ?></td>
                                            <td><?php echo e($item->tva); ?></td>
                                            <td><?php echo e($item->phone); ?></td>
                                            <td>
                                                <ul>
                                                    <li><i class="fa fa-eye" data-toggle="modal"
                                                            data-target=".bd-example-modal-lg-store-<?php echo e($item->id); ?>"
                                                            title="<?php echo e(trans('Consulter')); ?>"></i></li>
                                                    <li><a href="<?php echo e(url('/admin/stores/' . $item->id . '/edit')); ?>"><i
                                                                class="fa fa-pencil"
                                                                title="<?php echo e(trans('Modifier')); ?>"></i></a></li>
                                                    <?php if($item->status == 1): ?>
                                                        <li><a href="<?php echo e(url('/admin/stores/' . $item->id . '/delete')); ?>"><i
                                                                    class="fa fa-trash"
                                                                    title="<?php echo e(trans('Supprimer')); ?>"></i></a></li>
                                                    <?php else: ?>
                                                        <li><a href="<?php echo e(url('/admin/stores/' . $item->id . '/active')); ?>"><i
                                                                    class="fa fa-check"
                                                                    title="<?php echo e(trans('Activer')); ?>"></i></a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <div id="modal-owner"
                                            class="modal fade bd-example-modal-lg-store-<?php echo e($item->id); ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
                                            style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myLargeModalLabel">
                                                            <?php echo e(trans('Détail Magasin')); ?></h4>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                            aria-label="Close" data-original-title="" title=""><span
                                                                aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlSelect9">Activitées</label>
                                                                    <?php echo e($item->activity->name); ?>

                                                                </div>
                                                            </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlSelect9">Sender Id</label>
                                                                    <?php echo e($item->sender_id); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlSelect9">Propriétaire</label>
                                                                    <?php echo e($item->owner->firstname); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                                                                <input readonly class="form-control "
                                                                    id="validationServer01" type="text"
                                                                    value="<?php echo e($item->name); ?>" required=""
                                                                    data-original-title=""
                                                                    title="<?php echo e(trans('Nom du Magasin')); ?>">

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer02"><?php echo e(trans('Contact')); ?></label>
                                                                <input readonly class="form-control "
                                                                    id="validationServer02" type="text"
                                                                    value="<?php echo e($item->contact); ?>" name="contact"
                                                                    data-original-title=""
                                                                    title="<?php echo e(trans('Contact du Magasin')); ?>">

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer01"><?php echo e(trans('Addresse')); ?></label><br>
                                                                <?php echo e($item->address); ?>


                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                                                                <input readonly class="form-control "
                                                                    id="validationServer02" type="text" name="phone"
                                                                    value="<?php echo e($item->phone); ?>" data-original-title=""
                                                                    title="<?php echo e(trans('Téléphone Magasin')); ?>">

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="validationServer01"><?php echo e(trans('Logo')); ?></label>
                                                                <img src="<?php echo e($item->logo != '' ? asset(getImageByModel($item->id, 'stores', $item->logo)) : 'xxxxx'); ?>"
                                                                    width="25" height="25">

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer02"><?php echo e(trans('Base de calcul de la réduction')); ?></label>
                                                                <input readonly class="form-control "
                                                                    id="validationServer02" type="text" name="base_calcul"
                                                                    value="<?php echo e($item->base); ?>" required=""
                                                                    data-original-title=""
                                                                    title="Confirmation du mot de passe">

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer02"><?php echo e(trans('Réduction suivant la base')); ?></label>
                                                                <input readonly class="form-control "
                                                                    id="validationServer02" type="text" name="base_profit"
                                                                    value="<?php echo e($item->base_profit); ?>" data-original-title=""
                                                                    title="Confirmation du mot de passe">

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    for="validationServer02"><?php echo e(trans('Coéfficient (points)')); ?></label>
                                                                <input class="form-control " id="validationServer02"
                                                                    type="text" name="coeff" value="<?php echo e($item->coeff); ?>"
                                                                    data-original-title=""
                                                                    title="Confirmation du mot de passe">

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationServer02"><?php echo e(trans('TVA')); ?></label>
                                                                <input class="form-control " id="validationServer02"
                                                                    type="text" name="tva" value="<?php echo e($item->tva); ?>"
                                                                    data-original-title=""
                                                                    title="Confirmation du mot de passe">

                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" data-dismiss="modal"
                                                            aria-label="Close" data-original-title=""
                                                            title=""><?php echo e(trans('Fermer')); ?></button>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><?php echo e(trans('Nouveau Magasin')); ?></h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title=""
                        title=""><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('admin.stores.store')); ?>" method="POST" enctype='multipart/form-data'>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect9">Activitées</label>
                                    <select class="form-control digits" name="activity_id" id="exampleFormControlSelect9">
                                        <option>-- <?php echo e(trans('Choisir')); ?> --</option>
                                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
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
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->getFullNameAttribute()); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01"><?php echo e(trans('Nom')); ?></label>
                                <input class="form-control " id="validationServer01" type="text" name="store_name"
                                    required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01"><?php echo e(trans('Sender Id')); ?></label>
                                <input class="form-control " id="validationServer01" type="text" name="sender_id"
                                    required="" data-original-title="" title="<?php echo e(trans('Nom du Magasin')); ?>">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Contact')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="contact"
                                    data-original-title="" title="<?php echo e(trans('Contact du Magasin')); ?>">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01"><?php echo e(trans('Addresse')); ?></label>
                                <textarea class="form-control " id="validationServer01" type="text" name="address"
                                    data-original-title="" title="<?php echo e(trans('Addresse Magasin')); ?>"></textarea>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Téléphone')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="phone" required=""
                                    data-original-title="" title="<?php echo e(trans('Téléphone Magasin')); ?>">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validationServer01"><?php echo e(trans('Logo')); ?></label>
                                <input class="form-control" name="logo" type="file" data-original-title=""
                                    title="<?php echo e(trans('Logo Magasin')); ?>">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Base de calcul de la réduction')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="base_calcul"
                                    value="100" required="" data-original-title="" title="Confirmation du mot de passe">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Réduction suivant la base')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="base_profit"
                                    required="" data-original-title="" title="Confirmation du mot de passe">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('Coéfficient (points)')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="coeff" required=""
                                    data-original-title="" title="Confirmation du mot de passe">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02"><?php echo e(trans('TVA')); ?></label>
                                <input class="form-control " id="validationServer02" type="text" name="tva" required=""
                                    data-original-title="" title="Confirmation du mot de passe">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <label for="validationServer02"><?php echo e(trans('Remerciement Facture')); ?></label>
                                <div id="editor_container">
                                    <textarea id="editable" name="message_invoice">
                                        Merci pour votre entreprise! Le paiement est prévu dans les 31 jours; veuillez traiter cette facture dans ce délai. Il y aura une charge de 5 intérêts par mois sur les factures en retard.
                                    </textarea>
                                </div>
                                <div id="html_container"></div>
                            </div>
                            
                            <div class="col-md-2"></div>
                        </div>
                        <button class="btn btn-primary" type="submit" data-original-title=""
                            title=""><?php echo e(trans('Enregistrer')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/js/editor/simple-mde/simplemde.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/editor/simple-mde/simplemde.custom.js')); ?>"></script>
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