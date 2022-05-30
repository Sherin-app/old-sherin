@extends('layouts.simple.master')
@section('title', __('Propriétaire Panel'))

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/prism.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>@lang('dashboard.dashboard')</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{url('/dashboard/owner')}}">@lang('dashboard.dashboard')</a></li>
{{-- <li class="breadcrumb-item active">Ecommerce</li> --}}
@endsection

@section('content')
<div class="table-responsive">
<div class="container-fluid">
   <div class="row size-column">

      <div class="row">
         <div class="col-md-6">
            <div class="card gradient-primary o-hidden">
               <div class="card-header">
                   <strong class="text-center">@lang('dashboard.quick-send')</strong>
               </div>
               <div class="card-body">
                    <form action="{{route('owner.singleCamp')}}" method="POST">
                    @csrf
                       <div class="row">

                           <div class="mb-3 col-md-12">
                               <label for="validationServer02">{{trans('dashboard.Emetteur')}}</label>
                               {{-- <select class="form-control">
                                <option>{{__('Choisir l\'Expediteur')}}</option>
                                @foreach (auth()->user()->stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                               </select> --}}
                               <input class="form-control" value="{{auth()->user()->stores->first()->sender_id}}" name="senderId" disabled id="validationServer02" type="text" placeholder="{{ (!is_null( auth()->user()->stores->first()->sender_id))  ?  auth()->user()->stores->first()->sender_id : __('XBEL STORE')}}" required="" data-original-title="" title="{{trans('dashboard.Nom d\'emetteur')}}">
                               {{-- <div class="valid-feedback">Looks good!</div> --}}
                           </div>
                           <div class="mb-3 col-md-12">
                               <label for="validationServer02">{{trans('dashboard.Téléphone')}}</label>
                               <input class="form-control" id="validationServer02" type="text" name="phone"  placeholder="06XX-XX-XX-XX" required="" data-original-title="" title="{{trans('dashboard.Téléphone Destinataire')}}">
                               {{-- <div class="valid-feedback">Looks good!</div> --}}
                           </div>
                           <div class="mb-3 col-md-12">
                               <label for="validationServer01">{{trans('dashboard.Message')}}</label>
                               <textarea class="form-control" id="validationServer01" type="text" name="message"  data-original-title="" title="{{trans('dashboard.Message')}}"></textarea>
                              
                               {{-- <div class="valid-feedback">Looks good!</div> --}}
                           </div>
                       </div>
                       <button class="btn btn-primary" type="submit" data-original-title="" title="">{{trans('dashboard.Envoyer')}}</button>
                   </form>
               </div>
           </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  <h5>{{trans('dashboard.Balance')}}</h5>
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
                                          <span>{{trans('dashboard.Elements')}}</span>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <p>{{trans('dashboard.Nombre')}}</p>
                                 </td>
                                 <td>
                                    <p>{{trans('dashboard.Prix Unitaire')}} HT</p>
                                 </td>
                                 <td>
                                    <p>{{trans('dashboard.Total HT')}}</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="media">
                                       <div class="media-body">
                                          <p class="font-roboto">{{trans('dashboard.SMS')}}</p>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <span>{{$countSms}}</span>
                                 </td>
                                 <td>
                                    <span>
                                        @if(auth()->user()->id===11)
                                         1.99
                                        @else 
                                         {{Config::get('constant.sms_price')}}
                                        @endif
                                       
                                    </span>
                                 </td>
                                 <td>
                                     @php 
                                        $price = auth()->user()->id===11 ? 1.99 :  Config::get('constant.sms_price');
                                     @endphp
                                    <span>{{ $first_total = number_format((float)($countSms * ( $price ) ), 2, '.', '')}} Mad</span>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="media">
                                       <div class="media-body">
                                          <p class="font-roboto">{{trans('dashboard.mails')}}</p>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <span>{{$emails}}</span>
                                 </td>
                                 <td>
                                    <span>{{Config::get('constant.email_price')}}</span>
                                 </td>
                                 <td>
                                    
                                    <span>{{ $seconde_total = number_format((float)($emails * ( Config::get('constant.email_price') ) ), 2, '.', '')}} Mad</span>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <p>{{trans('dashboard.Total TTC')}}</p>
                                 </td>
                                 <td>
                                     
                                 </td>
                                 <td>
                                     
                                 </td>
                                 <td>
                                    {{$seconde_total + $first_total}} Mad
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                   
                  </div>
                  <div class="row">
                     <!--<div class="col-md-6 " style="align-items: center">-->
                     <!--   <a class="btn btn-primary" type="submit"   href="{{url('owner/solde')}}"    title="">{{trans('dashboard.Détail')}}</a>-->
                     <!--</div>-->
                     <!--<div class="col-md-6 ml" style="align-items: center">-->
                     <!--   <a class="btn btn-primary" target="_blank" href="{{url('owner/payement')}}">{{trans('dashboard.Payer')}}</a>-->
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
                           <p><span class="f-w-500 font-roboto" title="T.M.C : Total des produits vendus aujourd'hui tous magasins confondus">{{trans('dashboard.Total de produit vendue ajourd\'hui  T.M.C'  )}}</span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span >{{$total_vente}}</span> {{trans('communs.Produits')}}</h4>
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
                           <!--<p><span class="f-w-500 font-roboto">{{trans('dashboard.Nombre de factures Aujourd\'hui')}}</span></p>-->
                           <h4 class="f-w-500 mb-0 f-26 "></h4>
                           <span class="f-w-500 font-roboto">{{trans('dashboard.Chiffre d\'affire Realiser/mois')}}</span>
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
                           <p class="f-w-500 font-roboto">{{trans('dashboard.C.A D\'AUJOURDHUI')}}<span class="badge pill-badge-primary ml-3">{{trans('dashboard.Nouveau')}}</span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span >{{$ca_today}}</span>Mad</h4>
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
                           <p class="f-w-500 font-roboto">{{trans('dashboard.C.A D\'HIER')}}<span class="ml-3 badge pill-badge-primary">{{trans('dashboard.Nouveau')}}</span></p>
                           <h4 class="mb-0 f-w-500 f-26"><span >{{$ca_last_day}}</span>Mad</h4>
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
                           <p class="f-w-500 font-roboto">{{trans('dashboard.C.A DE CETTE SEMAINE')}}<span class="badge pill-badge-primary ml-3">Hot</span></p>
                           <div class="progress-box">
                              <h4 class="f-w-500 mb-0 f-26"><span >{{$ca_week}}</span>Mad</h4>
                              <div class="progress sm-progress-bar progress-animate app-right d-flex justify-content-end">
                                 {{-- <div class="progress-gradient-primary" role="progressbar" style="width: 35%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="font-primary">88%</span><span class="animate-circle"></span></div> --}}
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
                           <p class="f-w-500 font-roboto">{{trans('dashboard.C.A DE CE MOIS')}}<span class="badge pill-badge-primary ml-3">{{trans('dashboard.Nouveau')}}</span></p>
                           <h4 class="f-w-500 mb-0 f-26"><span >{{$ca_month}}</span>Mad</h4>
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
                           <p class="f-w-500 font-roboto">{{trans('dashboard.C.A TOTAL')}}<span class="badge pill-badge-primary ml-3">Hot</span></p>
                           <div class="progress-box">
                              <h4 class="f-w-500 mb-0 f-26"><span >{{$ca}}</span>Mad</h4>
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
                     <p><span class="f-w-500 font-roboto">{{trans('dashboard.Panier Moyen')}}</span><span class="font-primary f-w-700 ml-2"></span></p>
                     <h4 class="f-w-500 mb-0 f-26"><span class="">{{ ceil($orderAverage) }}</span>Mad</h4>
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
               <h5>{{trans('dashboard.Magasins')}}</h5>
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
                           @foreach($stores->take(5) as $item)
                           <tr>
                              <td>
                                 <div class="media">
                                    <img class="img-fluid m-r-15 rounded-circle" src="" alt="">
                                    <div class="media-body">
                                       <span>{{trans('dashboard.Nom')}}</span>
                                       <p class="font-roboto">{{$item->name}}</p>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <p>{{trans('dashboard.Adresse')}}</p>
                                 <span>{{substr($item->address,0,20)}}...</span>
                              </td>
                              <td>
                                 <p>{{trans('dashboard.C.A D\'AUJOURDHUI')}}</p>
                                 <span>{{calculateTurnOverYesterdayByStore($item->invoices,0)}}Mad</span>
                              </td>
                              <td>
                                 <p>{{trans('dashboard.C.A D\'HIER')}}</p>
                                 <span>{{calculateTurnOverYesterdayByStore($item->invoices,1)}}Mad</span>
                              </td>
                           </tr>
                           @endforeach
                           
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
            {{-- Best seller section --}}
            <div class="col-xl-12">
               <div class="card">
                  <div class="card-header">
                     <strong>{{trans('dashboard.classement Vendeurs')}}</strong>
                  </div>
                  <div class="card-body">
                     <div class="best-seller-table responsive-tbl">
                        <div class="item">
                           <div class="table-responsive product-list">
                              <table class="table table-bordernone">
                                 <thead>
                                    <tr>
                                       <th class="f-22">
                                          {{trans('dashboard.classement Vendeurs')}}
                                       </th>
                                       <th>{{trans('Magasin')}}</th>
                                       <th>{{trans('C.A')}} {{trans('Réalisé')}}</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($sellers as $year=>$sellers)
                                    @foreach($sellers as $seller)
                                    <tr>
                                       <td>
                                          <div class="d-inline-block align-middle">
                                             <img class="img-40 m-r-15 rounded-circle align-top" src="{{asset('assets/images/avtar/7.jpg')}}" alt="">
                                             <div class="status-circle bg-primary"></div>
                                             <div class="d-inline-block">
                                                <span>{{$seller['firstname']}} - {{$seller['lastname']}}</span>
                                                 <p class="font-roboto">{{$year}}</p> 
                                             </div>
                                          </div>
                                       </td>
                                       <td>{{$seller['store']}}</td>
                                       <td><span class="label">{{$seller['total']}} (MAD)</span></td>
                                    </tr>
                                    @endforeach
                                    @endforeach
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
      "{{asset('assets/images/dashboard-2')}}/";
  
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
@endsection

@section('script')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/dashboard/dashboard_2.js')}}"></script>
@endsection
