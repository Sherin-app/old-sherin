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
<h3 class="text-left">{{trans('Mes Produits')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{url('dashboard/owner')}}">{{trans('dashboard.dashboard')}}</a></li>
<li class="breadcrumb-item active">{{trans('Produits')}}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Ajax Deferred rendering for speed start-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-left">{{trans('Total des ventes')}} : {{$totalSell}} (MAD) </h1> <br>
                            <h1 class="text-left">{{trans('Total des marges brutes')}} : {{$totalMargeBrute}} (MAD) </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <form id="importList" action="{{route('owner.products.repport')}}" method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control digits" name="store_id" id="store_id">
                                                <option>-- {{trans('Choisir Magasin')}} --</option>
                                                @foreach ($stores as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" name="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" name="end_date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="form-control btn btn-primary">{{trans('Rechercher')}}</button>
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
                                    <th>{{ trans('Produits') }}</th>
                                    <th>{{ trans('Quantité du stock') }}</th>
                                    <th>{{ trans('Quantité vendue') }}</th>
                                    <th>{{ trans('Prix de vente') }}</th>
                                    <th>{{ trans('Prix d\'achat') }}</th>
                                    <th>{{ trans('Total de vente') }}</th>
                                    <th>{{ trans('Stock theorique') }}</th>
                                    <th>{{ trans('Marge brute') }}</th>
                                    <th>{{ trans('Total brute') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $item)
                                <tr>
                                    <td>{{$item->label}}</td>
                                    <td>{{$item->quantite}}</td>
                                    <td>{{$item->qte_total}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->promotion_price}}</td>
                                    <td>{{$item->price * $item->qte_total}}</td>
                                    <td>{{ $item->quantite -  $item->qte_total }}</td>
                                    <td>{{$margeBrute = $item->price - $item->promotion_price}}</td>
                                    <td><span style="color:green">{{$margeBrute * $item->qte_total}} {{trans('Mad')}}</span></td>
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

@endsection