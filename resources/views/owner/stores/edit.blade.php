@extends('layouts.simple.master')
@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-mde.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3 class="text-center"></h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{url('dashboard/owner')}}">{{trans('dashboard.dashboard')}}</a></li>
    <li class="breadcrumb-item active"><a href="{{url('owner/stores/')}}">{{trans('Magasin')}}</a></li>
    <li class="breadcrumb-item active">{{trans('Modification')}}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
       <div class="col">
          <span class="label text-center">{{trans('Balance')}} : 1007 SMS </span>
          
          <div class="progress">
           
             <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar" style="width: 80%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
       </div>
    </div>
    <div class="col-md-2"></div>
 </div>
 <br><br>


<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h2>{{trans('Modification Magasin')}} {{$store->name}}</h2>
				</div>
				<div class="card-body">
                <form action="{{route('owner.stores.update',$store->id)}}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect9">Activit??es</label>
                                <select class="form-control digits" name="activity_id" id="exampleFormControlSelect9">
                                    <option>-- {{trans('Choisir')}} --</option>
                                    @foreach ($activities as $item)
                                        @if($item->id==$store->activity_id)
                                        <option value="{{$store->activity_id}}" selected >{{$item->name}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('Contact')}}</label>
                            <input   class="form-control " id="validationServer02" type="text" value="{{$store->contact}}" name="contact" data-original-title="" title="{{trans('Contact du Magasin')}}">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer01">{{trans('Addresse')}}</label>
                            <textarea class="form-control " id="validationServer01" type="text" name="address"   data-original-title="" title="{{trans('Addresse Magasin')}}">{{$store->address}}</textarea>
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('T??l??phone')}}</label>
                            <input   class="form-control " id="validationServer02" type="text" name="phone" value="{{$store->phone}}" data-original-title="" title="{{trans('T??l??phone Magasin')}}">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationServer01">{{trans('Logo')}}</label>
                            <img src="{{($store->logo)!='' ? asset(getImageByModel($store->id,'stores',$store->logo)):'xxxxx' }}" width="25" height="25">
                            <input class="form-control" name="logo" type="file" data-original-title="" title="{{trans('Logo Magasin')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('Base de calcul de la r??duction')}}</label>
                            <input   class="form-control " id="validationServer02" type="text" name="base_calcul" value="{{$store->base}}"  required="" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('R??duction suivant la base')}}</label>
                            <input   class="form-control " id="validationServer02" type="text" name="base_profit" value="{{$store->base_profit}}" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('Co??fficient (points)')}}</label>
                            <input class="form-control " id="validationServer02" type="text" name="coeff"  value="{{$store->coeff}}" data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationServer02">{{trans('TVA')}}</label>
                            <input class="form-control " id="validationServer02" type="text" name="tva" value="{{$store->tva}}"  data-original-title="" title="Confirmation du mot de passe">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label for="validationServer02">{{ trans('Remerciement Facture') }}</label>
                            <div id="editor_container">
                                <textarea id="editable" name="message_invoice">
                                    {{$store->invoice_message}}
                                </textarea>
                            </div>
                            <div id="html_container"></div>
                        </div>
                        
                        <div class="col-md-2"></div>
                    </div>
                    <button class="btn btn-primary" type="submit" data-original-title="" title="{{trans('Modifier')}}">{{trans('Modifier')}}</button>
                </form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/editor/simple-mde/simplemde.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor/simple-mde/simplemde.custom.js') }}"></script>
@endsection
