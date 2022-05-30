@extends('layouts.simple.master')
@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3 class="text-center">{{trans('Mes Produits')}}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{url('dashboard/employe')}}">{{trans('dashboard.dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{trans('Produits')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				</div>
				<div class="card-body row">
                        <div class="table-responsive">
                            	<table class="display" id="render-datatable">
							<thead>
								<tr>
									<th>{{trans('libellé')}}</th>
									<th>{{trans('Magasin')}}</th>
									<th>{{trans('Prix')}}</th>
									<th>{{trans('Promotion')}}</th>
									<th>{{trans('Action')}}</th>
								</tr>
							</thead>
                            <tbody>
                                @foreach ($products as $item)
                                <tr>
                                    <th scope="row">{{$item->label}}</th>
                                    <td>{{$item->store->name}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->promotion_price}}</td> 
                                    <td>
                                        <a class="btn" style="background-color: #a927f9" data-toggle="modal" data-target=".bd-example-modal-lg-product-{{$item->id}}" title="{{trans('Consulter')}}"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <div id="modal-owner" class="modal fade bd-example-modal-lg-product-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title" id="myLargeModalLabel">{{trans('Détail Produit')}}</h4>
                                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                                          </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect9">{{trans('Libellé')}}</label>
                                                                <input readonly class="form-control " id="validationServer02" type="text" value="{{$item->label}}" data-original-title="" title="{{trans('Libellé')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationServer02">{{trans('Magasin')}}</label>
                                                            <input readonly class="form-control " id="validationServer02" type="text" value="{{$item->store->name}}" data-original-title="" title="{{trans('Magasin')}}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect9">{{trans('Prix')}}</label>
                                                                <input readonly class="form-control " id="validationServer01" type="text" value="{{$item->price}}"  required="" data-original-title="" title="{{trans('Prix Produit')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationServer01">{{trans('Prix Promotion')}}</label>
                                                            <input readonly class="form-control " id="validationServer01" type="text" value="{{$item->promotion_price}}"  required="" data-original-title="" title="{{trans('Prix Promotion')}}">
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    <button class="btn btn-primary"  data-dismiss="modal" aria-label="Close" data-original-title="" title="">{{trans('Fermer')}}</button>
                                                </div>
                                       </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
						</table>
                        </div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/chart/knob/knob.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/knob/knob-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    <script src="{{ asset('assets/js/notify/index.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js²') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script>
         function importProducts(store_id) {
               if(store_id!=0){
                $('#store_id_hidden').attr('value',store_id);
                $('#importList').submit();
              }else{
                alert('Vous devez selectionnez un magasin!')
              }
             
            }
        function ShowItems(value,url)
        {
           window.location=url+"?items="+value
        }    
    </script>
@endsection
