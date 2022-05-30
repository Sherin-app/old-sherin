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
     <h3 class="text-center">{{auth()->user()->getFullNameAttribute()}}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{url('dashboard/index')}}">{{trans('dashboard.dashboard')}}</a></li>
    <li class="breadcrumb-item active"><a href="{{route('admin.products')}}">{{trans('Produits')}}</a></li>
    <li class="breadcrumb-item active">{{trans('Modification')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- Ajax Deferred rendering for speed start-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
                    <h2>{{trans('Modification Produit')}} {{$product->label}} </h2>
				</div>
				<div class="card-body">
                    <form action="{{route('admin.products.update',$product->id)}}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect9">{{trans('Magasin')}}</label>
                                    <select class="form-control digits" name="store_id" id="exampleFormControlSelect9">
                                        <option>-- {{trans('Choisir')}} --</option>
                                        @foreach ($stores as $item)
                                            @if($product->store_id==$item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else 
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{trans('libelle')}}</label>
                                <input class="form-control " id="validationServer01" type="text" name="label" value="{{$product->label}}"  required="" data-original-title="" title="{{trans('Nom du Magasin')}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{trans('Prix de vente')}}</label>
                                <input class="form-control " id="validationServer01" type="text" name="price" value="{{$product->price}}"  required="" data-original-title="" title="{{trans('Nom du Magasin')}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{trans('Prix d\'achat')}}</label>
                                <input class="form-control " id="validationServer02" type="text" name="promotion_price" value="{{$product->promotion_price}}" data-original-title="" title="{{trans('Prix Promotion')}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{trans('Quantité du stock')}}</label>
                                <input class="form-control " id="validationServer02" type="text" name="quantite" value="{{$product->quantite}}" data-original-title="" title="{{trans('Quantité du stock')}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{trans('Quantité du stock')}}</label>
                                <input class="form-control " id="validationServer02" type="file" name="image" value="{{$product->image}}" data-original-title="" title="{{trans('Quantité du stock')}}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" data-original-title="" title="">{{trans('Modifier')}}</button>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


