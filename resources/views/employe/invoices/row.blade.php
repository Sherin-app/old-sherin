
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<?php $id=uniqid()?>
<br>
 
<div class="row" id="{{$id}}">
    <div class="col-md-6">
        <label for="validationServer01">{{ trans('communs.Produit') }} : :</label>
        <select class="js-example-basic-single col-sm-12" onchange="setPriceProduct(this, this.value,'{{$id}}')"  name="products[]">
           <option data-tokens="0">--- {{trans('communs.Choisir Produit/Service')}} ---</option>
            @foreach ($products as $item)
            <option value="{{ $item->id }}">
                {{ $item->label }} | {{ $item->price }} Mad </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
            <label for="validationServer02">{{trans('communs.Prix')}}</label>
            <input class="form-control prices" value="0"  id="price_{{$id}}" readonly type="text" name="price[]"  data-original-title="" title="{{trans('Prix Produit')}}">
    </div>
    <div class="col-md-2 row">
        <div class="row">
                <div class="col-md-8">
                    <label for="validationServer02">{{ trans('communs.Quantité') }}</label>
                    <input class="form-control qts" id="qte_{{$id}}" type="number" min="1" value="1" onchange="changeTotalOnce()" name="quantity[]"  required  data-original-title="" title="{{ trans('communs.Quantité') }}">
                </div>
                <div class="col-md-4 " style="margin-left: 75px!important;margin-top: -47px;" >
                   <div class="row" style="margin-top: -5px!important">
                        <span class="btn btn-primary" onclick="changeQuantity('{{$id}}',1)" style="width: 5px!important;height:25px!important">+</span>
                    </div>
                    <p></p>
                    <div class="row">
                        <span class="btn btn-primary" onclick="changeQuantity('{{$id}}',-1)" style="width: 5px!important;height:25px!important">-</span>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-2">
        <label for="validationServer02">{{trans('communs.Supprimer P/S')}}</label>
        <button class="form-control btn btn-primary " type="button" onclick="removeProductRow('{{$id}}')" title="{{trans('communs.Supprimer Produit')}}">-</button>
    </div>
</div>
