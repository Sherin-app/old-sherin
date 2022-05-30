<?php $__env->startSection('title', __('Propriétaire Panel')); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/chartist.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/owlcarousel.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/prism.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<h3><?php echo app('translator')->getFromJson('dashboard.dashboard'); ?></h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard/owner')); ?>"><?php echo app('translator')->getFromJson('dashboard.dashboard'); ?></a></li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div>
          <div class="container-fluid checkout ml-4 mr-4">
            <div class="card">
              <div class="card-header">
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="checkout-details">
                      <div class="order-box">
                        <div class="title-box">
                          <div class="checkbox-title">
                            <h4>Pack Gold </h4>
                            <span>Total</span>
                          </div>
                        </div>
                        <ul class="qty">
                          <li>SMS ( <?php echo e($price = auth()->user()->id===11 ? 1.99 : Config::get('constant.sms_price')); ?> MAD )<span><?php echo e($first_total = number_format((float)($countSms * ( $price ) ), 2, '.', '')); ?> MAD</span></li>
                          <li>EMAIL ( <?php echo e(Config::get('constant.email_price')); ?> MAD )<span><?php echo e($seconde_total = number_format((float)($emails * ( Config::get('constant.email_price') ) ), 2, '.', '')); ?> MAD</span></li>
                        </ul>
                        <ul class="sub-total">
                          <li>Subtotal <span class="count"> <?php echo e($seconde_total + $first_total); ?> MAD</span></li>
                        </ul>
                        <ul class="sub-total total">
                          <li>Total <span class="count"> <?php echo e($seconde_total + $first_total); ?> MAD</span></li>
                        </ul>
                        <div class="animate-chk">
                          <div class="row">
                            <div class="col">
                              <label class="d-block" for="edo-ani">
                                <input class="radio_animated" id="edo-ani" type="radio" name="rdo-ani" checked="" data-original-title="" title="">Check Payments
                              </label>
                              <label class="d-block" for="edo-ani1">
                                <input class="radio_animated" id="edo-ani1" type="radio" name="rdo-ani" data-original-title="" title="">Cash On Delivery
                              </label>
                              <label class="d-block" for="edo-ani2">
                                <input class="radio_animated" id="edo-ani2" type="radio" name="rdo-ani" checked="" data-original-title="" title="">PayPal<img class="img-paypal" src="<?php echo e(asset('assets/images/checkout/paypal.png')); ?>" alt="">
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="order-place"><a class="btn btn-primary" href="#">Place Order </a></div>
                      </div>
                    </div>
                  </div>
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
<script src="<?php echo e(asset('assets/js/chart/apex-chart/apex-chart.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/chart/apex-chart/stock-prices.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/prism/prism.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/clipboard/clipboard.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/counter/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/counter/jquery.counterup.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/counter/counter-custom.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/custom-card/custom-card.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/owlcarousel/owl.carousel.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dashboard/dashboard_2.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>