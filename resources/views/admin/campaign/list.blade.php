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
    <h3 class="text-center">{{ auth()->user()->getFullNameAttribute() }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('dashboard.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('Campagnes') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax Deferred rendering for speed start-->
            <div class="col-sm-12">
                @if ($errors->any())
                    {!! implode('', $errors->all('<span class="text text-danger">:message</span>')) !!}
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-info" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" title="{{ trans('Nouvelle Campagne') }}">Nouveau</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-info" type="button" data-toggle="modal" data-target=""
                                    title="{{ trans('FILTRES') }}">
                                    <i class="fa fa-sliders" title="{{ trans('filtres') }}" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <select style="width:80px;margin-left:auto"
                                    onchange="ShowItems($(this).val(),'{{ url('/admin/campaigns') }}')" class="form-control digits">
                                    @foreach (Config::get('constant.items') as $item)
                                        <option value="{{ $item }}"
                                            {{ isset($_GET['items']) && $_GET['items'] == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>  
                        </div>
                       
                    </div>
                   
                    <div class="card-body">
                        <table class="display" id="render-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ trans('Campagne') }}</th>
                                    <th scope="col">{{ trans('Modèle') }}</th>
                                    <th scope="col">{{ trans('Date Création') }}</th>
                                    <th scope="col">{{ trans('Nature D\'Envoie') }}</th>
                                    <th scope="col">{{ trans('Statut') }}</th>
                                    <th scope="col">{{ trans('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaigns as $item)
                                    <tr>
                                        <td>{{ $item->campaign_name }}</td>
                                        <td>{{ $item->template->template_name }}</td>
                                        <td>{{ $item->create_date }}</td>
                                        <td>{{ getSendNature($item->nature_sending) }}</td>
                                        <td>{{ getCampaignStatus($item->status) }}</td>
                                        <td>
                                            
                                        <a title="{{ trans('Consulter') }}" class="btn"style="background-color: #a927f9;width:25px !important" href="#" data-toggle="modal"
                                                data-target=".bd-example-modal-lg-template-{{ $item->id }}"><i
                                                    class="fa fa-eye text-center" alt="{{ trans('Consulter') }}"
                                                    title="{{ trans('Consulter') }}"></i></a>
                                        <a title="{{ trans('Modifier') }}" class="btn" style="background-color: #ea2087;width:25px !important" href="{{ url('/admin/campaigns/' . $item->id . '/edit') }}"><i class="fa fa-pencil" alt="{{ trans('Modifier') }}"
                                                        title="{{ trans('Modifier') }}"></i></a>            
                                        {{-- <a title="{{ trans('Desactiver') }}" class="btn" style="background-color: #ea2087;width:25px !important" href="{{ url('/admin/campaigns/' . $item->id . '/edit') }}"><i class="fa fa-pencil" alt="{{ trans('Modifier') }}"
                                                            title="{{ trans('Modifier') }}"></i></a> --}}
                                        </td>

                                    </tr>
                                    <div id="modal-owner"
                                        class="modal fade bd-example-modal-lg-template-{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
                                        style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        {{ trans('Détail Template') }}</h4>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close" data-original-title="" title=""><span
                                                            aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label
                                                                for="validationServer01">{{ trans('Nom Campagne') }}</label>
                                                            <input readonly class="form-control" name="campaign_name"
                                                                value="{{ $item->campaign_name }}"
                                                                title="{{ trans('Nom Campagne') }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label
                                                                for="validationServer01">{{ trans('Models/Templates') }}</label>
                                                            <input readonly class="form-control"
                                                                value="{{ $item->template->template_name }}"
                                                                title="{{ trans('Nom Campagne') }}">

                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label
                                                                for="validationServer02">{{ trans('Nature Envoie') }}</label>
                                                            <input readonly class="form-control"
                                                                value="{{ $item->nature_sending }}"
                                                                title="{{ trans('Nature D\'Envoie') }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationServer02">{{ trans('Message') }}</label>
                                                            <textarea readonly class="form-control"
                                                                title="{{ trans('Message de Campagne') }}">{{ $item->message }}</textarea>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"
                                                        data-original-title="" title="">{{ trans('Fermer') }}</button>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">{{ trans('Nouvelle Campagne') }}</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title=""
                        title=""><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.campaigns.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('Nom Campagne') }}</label>
                                <input class="form-control" name="campaign_name" value="{{ old('campaign_name') }}"
                                    placeholder="{{ trans('Happy New Year') }}" required="" data-original-title=""
                                    title="{{ trans('Nom Campagne') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('Models/Templates') }}</label>
                                <select class="form-control digits" name="model" id="exampleFormControlSelect9" required>
                                    <option value="0">--{{ trans('Choisir la template') }}--</option>
                                    @foreach ($templates as $item)
                                        <option value="{{ $item->id }}">{{ $item->template_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{ trans('Nature Envoie') }}</label>
                                <select class="form-control digits" name="send_nature" id="exampleFormControlSelect9">
                                    <option value="-1">--{{ trans('Choisir la nature d\'envoie') }}--</option>
                                    @foreach (Config::get('constant.send_nature') as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{ trans('Message') }}</label>
                                <textarea class="form-control" name="message" value="{{ old('message') }}" id="editable"
                                    required="" title="{{ trans('Message de Campagne') }}"></textarea>
                            </div>

                        </div>
                        <button class="btn btn-primary" type="submit" data-original-title=""
                            title="{{ trans('Enregistrer') }}">{{ trans('Enregistrer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/editor/simple-mde/simplemde.custom.js') }}"></script>
@endsection
