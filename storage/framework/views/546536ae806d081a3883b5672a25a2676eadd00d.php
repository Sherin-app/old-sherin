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
<div class="table-responsive">
<div class="container-fluid">
   <div class="row size-column">

      <div class="row">
         <div class="col-md-6">
            <div class="card gradient-primary o-hidden">
               <div class="card-header">
                   <strong class="text-center"><?php echo app('translator')->getFromJson('dashboard.quick-send'); ?></strong>
               </div>
               <div class="card-body">
                    <form action="<?php echo e(route('owner.singleCamp')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                       <div class="row">

                           <div class="mb-3 col-md-12">
                               <label for="validationServer02"><?php echo e(trans('dashboard.Emetteur')); ?></label>
                               
                               <input class="form-control" value="<?php echo e(auth()->user()->stores->first()->sender_id); ?>" name="senderId" disabled id="validationServer02" type="text" placeholder="<?php echo e((!is_null( auth()->user()->stores->first()->sender_id))  ?  auth()->user()->stores->first()->sender_id : __('XBEL STORE')); ?>" required="" data-original-title="" title="<?php echo e(trans('dashboard.Nom d\'emetteur')); ?>">
                               
                           </div>
                           <div class="mb-3 col-md-12">
                               <label for="validationServer02"><?php echo e(trans('dashboard.Téléphone')); ?></label>
                               <input class="form-control" id="validationServer02" type="text" name="phone"  placeholder="06XX-XX-XX-XX" required="" data-original-title="" title="<?php echo e(trans('dashboard.Téléphone Destinataire')); ?>">
                               
                           </div>
                           <div class="mb-3 col-md-12">
                               <label for="validationServer01"><?php echo e(trans('dashboard.Message')); ?></label>
                               <textarea class="form-control" id="validationServer01" type="text" name="message"  data-original-title="" title="<?php echo e(trans('dashboard.Message')); ?>"></textarea>
                              
                               
                           </div>
                       </div>
                       <button class="btn btn-primary" type="submit" data-original-title="" title=""><?php echo e(trans('dashboard.Envoyer')); ?></button>
                   </form>
               </div>
           </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  <h5><?php echo e(trans('dashboard.Balance')); ?></h5>
               </div>
               <div class="card-body ">
                  <div class="our-product">
                     <div class="table-responsive">
                        <table class="table table-bordernone">
                           <tbody class="f-w-500">
                              <tr>
                                 <td>
                                    <div class="media">
                                       <div class="media-body">
                                          <span><?php echo e(trans('dashboard.Elements')); ?></span>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <p><?php echo e(trans('dashboard.Nombre')); ?></p>
                                 </td>
                                 <td>
                                    <p><?php echo e(trans('dashboard.Prix Unitaire')); ?> HT</p>
                                 </td>
                                 <td>
                                    <p><?php echo e(trans('dashboard.Total HT')); ?></p>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="media">
                                       <div class="media-body">
                                          <p class="font-roboto"><?php echo e(trans('dashboard.SMS')); ?></p>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <span><?php echo e($countSms); ?></span>
                                 </td>
                                 <td>
                                    <span>
                                        <?php if(auth()->user()->id===11): ?>
                                         1.99
                                        <?php else: ?> 
                                         <?php echo e(Config::get('constant.sms_price')); ?>

                                        <?php endif; ?>
                                       
                                    </span>
                                 </td>
                                 <td>
                                     <?php 
                                        $price = auth()->user()->id===11 ? 1.99 :  Config::get('constant.sms_price');
                                     ?>
                                    <span><?php echo e($first_total = number_format((float)($countSms * ( $price ) ), 2, '.', '')); ?> Mad</span>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="media">
                                       <div class="media-body">
                                          <p class="font-roboto"><?php echo e(trans('dashboard.mails')); ?></p>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <span><?php echo e($emails); ?></span>
                                 </td>
                                 <td>
                                    <span><?php echo e(Config::get('constant.email_price')); ?></span>
                                 </td>
                                 <td>
                                    
                                    <span><?php echo e($seconde_total = number_format((float)($emails * ( Config::get('constant.email_price') ) ), 2, '.', '')); ?> Mad</span>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <p><?php echo e(trans('dashboard.Total TTC')); ?></p>
                                 </td>
                                 <td>
                                     
                                 </td>
                                 <td>
                                     
                                 </td>
                                 <td>
                                    <?php echo e($seconde_total + $first_total); ?> Mad
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                   
                  </div>
                  <div class="row">
                     <!--<div class="col-md-6 " style="align-items: center">-->
                     <!--   <a class="btn btn-primary" type="submit"   href="<?php echo e(url('owner/solde')); ?>"    title=""><?php echo e(trans('dashboard.Détail')); ?></a>-->
                     <!--</div>-->
                     <!--<div class="col-md-6 ml" style="align-items: center">-->
                     <!--   <a class="btn btn-primary" target="_blank" href="<?php echo e(url('owner/payement')); ?>"><?php echo e(trans('dashboard.Payer')); ?></a>-->
                     <!--</div>-->
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      
      <div class="col-xl-7 box-col-12 xl-100">
         <div class="row dash-chart">
            <div class="col-xl-6 box-col-6 col-md-6">
               <div class="card o-hidden">
                  <div class="card-header card-no-border">
                     <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                           <li><i class="fa fa-spin fa-cog"></i></li>
                           <li><i class="view-html fa fa-code"></i></li>
                           <li><i class="icofont icofont-maximize full-card"></i></li>
                           <li><i class="icofont icofont-minus minimize-card"></i></li>
                           <li><i class="icofont icofont-refresh reload-card"></i></li>
                           <li><i class="icofont icofont-error close-card"></i></li>
                        </ul>
                     </div>
                     <div class="media">
                        <div class="media-body">
                           <p><span class="f-w-500 font-roboto" title="T.M.C : Total des produits vendus aujourd'hui tous magasins confondus"><?php echo e(trans('dashboard.Total de produit vendue ajourd\'hui  T.M.C'  )); ?></span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span ><?php echo e($total_vente); ?></span> <?php echo e(trans('communs.Produits')); ?></h4>
                        </div>
                     </div>
                  </div>
                  <div class="card-body p-0">
                     <div class="media">
                        <div class="media-body">
                           <div class="profit-card">
                              <!--<div id="spaline-chart"></div>-->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-6 box-col-6 col-md-6">
               <div class="card o-hidden">
                  <div class="card-header card-no-border">
                     <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                           <li><i class="fa fa-spin fa-cog"></i></li>
                           <li><i class="view-html fa fa-code"></i></li>
                           <li><i class="icofont icofont-maximize full-card"></i></li>
                           <li><i class="icofont icofont-minus minimize-card"></i></li>
                           <li><i class="icofont icofont-refresh reload-card"></i></li>
                           <li><i class="icofont icofont-error close-card"></i></li>
                        </ul>
                     </div>
                     <div class="media">
                        <div class="media-body">
                           <!--<p><span class="f-w-500 font-roboto"><?php echo e(trans('dashboard.Nombre de factures Aujourd\'hui')); ?></span></p>-->
                           <h4 class="f-w-500 mb-0 f-26 "></h4>
                           <span class="f-w-500 font-roboto"><?php echo e(trans('dashboard.Chiffre d\'affire Realiser/mois')); ?></span>
                        </div>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <div class="monthly-visit">
                        <div id="column-chart"></div>
                     </div>
                   
                  </div>
               </div>
            </div>
            <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
               <div class="card o-hidden">
                  <div class="card-body">
                     <div class="ecommerce-widgets media">
                        <div class="media-body">
                           <p class="f-w-500 font-roboto"><?php echo e(trans('dashboard.C.A D\'AUJOURDHUI')); ?><span class="badge pill-badge-primary ml-3"><?php echo e(trans('dashboard.Nouveau')); ?></span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span ><?php echo e($ca_today); ?></span>Mad</h4>
                        </div>
                        <div class="ecommerce-box light-bg-primary"><i class="fa fa-heart" aria-hidden="true"></i></div>
                     </div>
                  </div>
               </div>
            </div>
             <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
               <div class="card o-hidden">
                  <div class="card-body">
                     <div class="ecommerce-widgets media">
                        <div class="media-body">
                           <p class="f-w-500 font-roboto"><?php echo e(trans('dashboard.C.A D\'HIER')); ?><span class="ml-3 badge pill-badge-primary"><?php echo e(trans('dashboard.Nouveau')); ?></span></p>
                           <h4 class="mb-0 f-w-500 f-26"><span ><?php echo e($ca_last_day); ?></span>Mad</h4>
                        </div>
                        <div class="ecommerce-box light-bg-primary"><i class="fa fa-heart" aria-hidden="true"></i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
               <div class="card o-hidden">
                  <div class="card-body">
                     <div class="media">
                        <div class="media-body">
                           <p class="f-w-500 font-roboto"><?php echo e(trans('dashboard.C.A DE CETTE SEMAINE')); ?><span class="badge pill-badge-primary ml-3">Hot</span></p>
                           <div class="progress-box">
                              <h4 class="f-w-500 mb-0 f-26"><span ><?php echo e($ca_week); ?></span>Mad</h4>
                              <div class="progress sm-progress-bar progress-animate app-right d-flex justify-content-end">
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
               <div class="card o-hidden">
                  <div class="card-body">
                     <div class="ecommerce-widgets media">
                        <div class="media-body">
                           <p class="f-w-500 font-roboto"><?php echo e(trans('dashboard.C.A DE CE MOIS')); ?><span class="badge pill-badge-primary ml-3"><?php echo e(trans('dashboard.Nouveau')); ?></span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span ><?php echo e($ca_month); ?></span>Mad</h4>
                        </div>
                        <div class="ecommerce-box light-bg-primary"><i class="fa-3x fa-money" aria-hidden="true"></i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
               <div class="card o-hidden">
                  <div class="card-body">
                     <div class="media">
                        <div class="media-body">
                           <p class="f-w-500 font-roboto"><?php echo e(trans('dashboard.C.A TOTAL')); ?><span class="badge pill-badge-primary ml-3">Hot</span></p>
                           <div class="progress-box">
                              <h4 class="f-w-500 mb-0 f-26"><span ><?php echo e($ca); ?></span>Mad</h4>
                              <div class="progress sm-progress-bar progress-animate app-right d-flex justify-content-end">
                                
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
             <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
                <div class="card o-hidden dash-chart">
            <div class="card-header card-no-border">
               <div class="card-header-right">
                  <ul class="list-unstyled card-option">
                     <li><i class="fa fa-spin fa-cog"></i></li>
                     <li><i class="view-html fa fa-code"></i></li>
                     <li><i class="icofont icofont-maximize full-card"></i></li>
                     <li><i class="icofont icofont-minus minimize-card"></i></li>
                     <li><i class="icofont icofont-refresh reload-card"></i></li>
                     <li><i class="icofont icofont-error close-card"></i></li>
                  </ul>
               </div>
               <div class="media">
                  <div class="media-body">
                     <p><span class="f-w-500 font-roboto"><?php echo e(trans('dashboard.Panier Moyen')); ?></span><span class="font-primary f-w-700 ml-2"></span></p>
                     <h4 class="f-w-500 mb-0 f-26"><span class=""><?php echo e(ceil($orderAverage)); ?></span>Mad</h4>
                  </div>
               </div>
            </div>
           
         </div>
             </div>
           
        </div>


         </div>
      </div>
     
      <div class="col-xl-9 xl-100 box-col-12">
          <div class="row">
              <div class="col-xl-12">
                  <div class="card">
                        <div class="card-header card-no-border">
               <h5><?php echo e(trans('dashboard.Magasins')); ?></h5>
               <div class="card-header-right">
                  <ul class="list-unstyled card-option">
                     <li><i class="fa fa-spin fa-cog"></i></li>
                     <li><i class="view-html fa fa-code"></i></li>
                     <li><i class="icofont icofont-maximize full-card"></i></li>
                     <li><i class="icofont icofont-minus minimize-card"></i></li>
                     <li><i class="icofont icofont-refresh reload-card"></i></li>
                     <li><i class="icofont icofont-error close-card"></i></li>
                  </ul>
               </div>
            </div>
                        <div class="card-body pt-0">
               <div class="our-product">
                  <div class="table-responsive">
                     <table class="table table-bordernone">
                        <tbody class="f-w-500">
                           <?php $__currentLoopData = $stores->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td>
                                 <div class="media">
                                    <img class="img-fluid m-r-15 rounded-circle" src="" alt="">
                                    <div class="media-body">
                                       <span><?php echo e(trans('dashboard.Nom')); ?></span>
                                       <p class="font-roboto"><?php echo e($item->name); ?></p>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <p><?php echo e(trans('dashboard.Adresse')); ?></p>
                                 <span><?php echo e(substr($item->address,0,20)); ?>...</span>
                              </td>
                              <td>
                                 <p><?php echo e(trans('dashboard.C.A D\'AUJOURDHUI')); ?></p>
                                 <span><?php echo e(calculateTurnOverYesterdayByStore($item->invoices,0)); ?>Mad</span>
                              </td>
                              <td>
                                 <p><?php echo e(trans('dashboard.C.A D\'HIER')); ?></p>
                                 <span><?php echo e(calculateTurnOverYesterdayByStore($item->invoices,1)); ?>Mad</span>
                              </td>
                           </tr>
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
      
      
      <div class="col-xl-9 xl-100 box-col-12">
         <div class="row">
            
            <div class="col-xl-12">
               <div class="card">
                  <div class="card-header">
                     <strong><?php echo e(trans('dashboard.classement Vendeurs')); ?></strong>
                  </div>
                  <div class="card-body">
                     <div class="best-seller-table responsive-tbl">
                        <div class="item">
                           <div class="table-responsive product-list">
                              <table class="table table-bordernone">
                                 <thead>
                                    <tr>
                                       <th class="f-22">
                                          <?php echo e(trans('dashboard.classement Vendeurs')); ?>

                                       </th>
                                       <th><?php echo e(trans('Magasin')); ?></th>
                                       <th><?php echo e(trans('C.A')); ?> <?php echo e(trans('Réalisé')); ?></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$sellers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       <td>
                                          <div class="d-inline-block align-middle">
                                             <img class="img-40 m-r-15 rounded-circle align-top" src="<?php echo e(asset('assets/images/avtar/7.jpg')); ?>" alt="">
                                             <div class="status-circle bg-primary"></div>
                                             <div class="d-inline-block">
                                                <span><?php echo e($seller['firstname']); ?> - <?php echo e($seller['lastname']); ?></span>
                                                 <p class="font-roboto"><?php echo e($year); ?></p> 
                                             </div>
                                          </div>
                                       </td>
                                       <td><?php echo e($seller['store']); ?></td>
                                       <td><span class="label"><?php echo e($seller['total']); ?> (MAD)</span></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      </div>
   </div>
</div>
<script>
  var map;
  function initMap() {
    map = new google.maps.Map(
      document.getElementById('map'),
      {center: new google.maps.LatLng(-33.91700, 151.233), zoom: 18});
  
    var iconBase =
      "<?php echo e(asset('assets/images/dashboard-2')); ?>/";
  
    var icons = {
      userbig: {
        icon: iconBase + '1.png'
      },
      library: {
        icon: iconBase + '3.png'
      },
      info: {
        icon: iconBase + '2.png'
      }
    };
  
    var features = [
      {
        position: new google.maps.LatLng(-33.91752, 151.23270),
        type: 'info'
      }, {
        position: new google.maps.LatLng(-33.91700, 151.23280),
        type: 'userbig'
      },  {
        position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
        type: 'library'
      }
    ];
  
    // Create markers.
    for (var i = 0; i < features.length; i++) {
      var marker = new google.maps.Marker({
        position: features[i].position,
        icon: icons[features[i].type].icon,
        map: map
      });
    };
  }
</script>
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