@extends('layouts.simple.restau')
@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3 class="text-left">{{auth()->user()->store->name}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{url('dashboard/employe')}}">{{trans('dashboard.dashboard')}}</a></li>
<li class="breadcrumb-item active">{{trans('communs.POS')}}</li>
@endsection

@section('content')
<div class="container-fluid row">
    @if($errors->any())
    {{ implode('', $errors->all(':message')) }}
    @endif
    <div class="col-xl-6 col-md-6 box-col-6">
        <div class="file-content">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body text-end">

                            <div class="row">
                                <div class="col-10">
                                    <select id="customers" class="js-example-basic-single col-sm-12" onchange="getCustomerPoints($(this).val())" required name="customer">
                                        <option value="0">--- {{ trans('communs.Choisir un client') }} ---</option>
                                        @foreach ($customers as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['firstname'] . ' ' . $item['lastname'] }} : {{ $item['phone'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-sm" type="button">Nouveau Client</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body file-manager">
                    <br>
                    <div class="row">
                        <div class="col-4" style="    display: flex;justify-content: start;align-items: baseline;white-space: pre-wrap;">
                            <span class="badge rounded-pill badge-success" id="redPts" style="    height: 35px;width: 35px;text-align: center;align-items: center;justify-content: center;display: flex;font-weight: 31px;font-size: 14px;">0</span> Points de Reduction
                            <input type="hidden" id="redPtsHidden">
                        </div>
                        <div class="col-4" style="    display: flex;justify-content: start;align-items: baseline;white-space: pre-wrap;">
                            <span class="badge rounded-pill badge-primary" id="redMad" style="    height: 35px;width: 35px;text-align: center;align-items: center;justify-content: center;display: flex;font-weight: 31px;font-size: 14px;">0.00</span> Reduction en Mad
                            <input type="hidden" id="redMadHidden" value='0'>
                        </div>
                        <div class="col-4">
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">Utiliser la réduction? </label>
                                <div class="media-body text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" onchange="reduction()" id='switchReduction'><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive wishlist" style="height: 414px;position: relative;overflow: auto;border: solid;">
                            <table class="col-12">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Prdouct Name</th>
                                        <th style="text-align: left;">Price</th>
                                        <th style="text-align: left;">Action</th>
                                        <th style="text-align: left;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="order">

                                </tbody>

                            </table>
                        </div>
                        <table class="table" style="text-align:left">
                            <tr>
                                <td>
                                    <label>Total HT : <span id="totalHt">00.00</span></label>
                                    <input type="hidden" id="totalHtHidden">
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-2"></div>
                                        <div class="col-8">
                                            <label> <strong> Total : <span id="total">00.00 </span> MAD </strong> </label>
                                        </div>
                                        <input type="hidden" id="totalHidden">
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-8">
                                            <label>CODE DE REDUCTION </label>
                                            <input type="text" id="redCode" class="form-control"> <br>
                                            <button class="btn btn-primary col-12" type="button" onclick="reductionCode()">Appliquer</button>
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-2"></div>

                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-2"></div>
                                        <div class="col-8">
                                            <label>TVA : <span>{{ auth()->user()->store->tva }}</span></label>
                                            <button class="btn btn-primary col-12" type="button" onclick='print()'>Terminer</button> <br> <br>
                                            <button class="btn btn-primary col-12" type="button" onclick='calculator()'>Calculatrice</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <span id="code_red_error" style="color:red"></span>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 box-col-6">
        <div class="file-content">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body text-end">
                            <div class="row">
                                <div class="col-10">
                                    <select id="customers" class="js-example-basic-single col-sm-12" onchange="addFromSearchProducts($(this).val())" required name="customer">
                                        <option value="0">--- {{ trans('communs.Choisir un Produit') }} ---</option>
                                        @if(!empty($products))
                                        @foreach ($products as $items)
                                        @foreach($items as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->label }}
                                        </option>
                                        @endforeach
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body file-manager" style="height: 714px;position: relative;overflow: auto;">
                    <ul class="files">
                        @if(!empty($menus))
                        @foreach($menus as $menu)
                        <li class="file-box" style="width: 15%;" onclick="getProductsByMenuid('{{$menu->id}}')">
                            <div class="file-bottom">
                                <h6>{{$menu->name}} </h6>
                                <p class="mb-1">total : {{$menu->products->count()}}</p>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <br><br>
                    <div class="tabcontent">
                        <div class="active" id="0">
                            <ul class="files" id="listProducts">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-calculator" class="modal fade bd-example-modal-calculator" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">{{ trans('Calculator') }}</h4>
                    <button id="close" class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <table border="1" class="col-md-12 table">
                        <tr>
                            <td colspan="3"><input type="text" id="result" class="form-control"/></td>
                            <!-- clr() function will call clr to clear all value -->
                            <td><input type="button" value="c" onclick="clr()" class="form-control"/> </td>
                        </tr>
                        <tr>
                            <!-- create button and assign value to each button -->
                            <!-- dis("1") will call function dis to display value -->
                            <td><input type="button" value="1" onclick="dis('1')" class="form-control" /> </td>
                            <td><input type="button" value="2" onclick="dis('2')" class="form-control"/> </td>
                            <td><input type="button" value="3" onclick="dis('3')" class="form-control"/> </td>
                            <td><input type="button" value="/" onclick="dis('/')" class="form-control"/> </td>
                        </tr>
                        <tr>
                            <td><input type="button" value="4" onclick="dis('4')" class="form-control"/> </td>
                            <td><input type="button" value="5" onclick="dis('5')" class="form-control"/> </td>
                            <td><input type="button" value="6" onclick="dis('6')" class="form-control"/> </td>
                            <td><input type="button" value="-" onclick="dis('-')"class="form-control" /> </td>
                        </tr>
                        <tr>
                            <td><input type="button" value="7" onclick="dis('7')" class="form-control"/> </td>
                            <td><input type="button" value="8" onclick="dis('8')" class="form-control"/> </td>
                            <td><input type="button" value="9" onclick="dis('9')" class="form-control"/> </td>
                            <td><input type="button" value="+" onclick="dis('+')" class="form-control"/> </td>
                        </tr>
                        <tr>
                            <td><input type="button" value="." onclick="dis('.')" class="form-control"/> </td>
                            <td><input type="button" value="0" onclick="dis('0')" class="form-control"/> </td>
                            <!-- solve function call function solve to evaluate value -->
                            <td><input type="button" value="=" onclick="solve()" class="form-control"/> </td>
                            <td><input type="button" value="*" onclick="dis('*')" class="form-control"/> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-owner" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">{{ trans('Nouveau Client') }}</h4>
                    <button id="close" class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="customersErrors">

                    </div>
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('Nom') }}</label>
                                <input class="form-control" id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" data-original-title="" title="{{ trans('Prénom') }}">
                                @if ($errors->has('firstname'))
                                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{ trans('Prénom') }}</label>
                                <input class="form-control " id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" data-original-title="" title="{{ trans('Nom') }}">
                                @if ($errors->has('lastname'))
                                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('E-mail') }}</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" data-original-title="" title="{{ trans('E-mail') }}">
                                @if ($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">{{ trans('Téléphone') }}</label>
                                <input class="form-control" id="phone" type="text" name="phone" value="212{{ old('phone') }}" required="" data-original-title="" title="{{ trans('Téléphone') }}">
                                @if ($errors->has('phone'))
                                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('Date de Naissance') }}</label>
                                <input id="birth" class="form-control" type="date" name="birth" data-language="en">
                                @if ($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('birth') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">{{ trans('Sexe') }}</label>
                                <select class="form-control digits" name="sexe" id="sexe">
                                    <option>--- {{ trans('Choisir Sexe') }} --</option>
                                    <option value="0">{{ trans('Homme') }}</option>
                                    <option value="1">{{ trans('Femme') }}</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="createCustomer()" title="{{ trans('Enregistrer') }}">{{ trans('Enregistrer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
<script>
    $(document).ready(function() {
        var menu_id = '{{  $products->count() > 0 ? $products->first()[0]->menu_id : 0}}';
        getProductsByMenuid(menu_id);
    });

    function calculator() {
        var total = document.getElementById('totalHidden').value;
        if(total !='' ){
            document.getElementById('result').value = total+'-';
            $("#modal-calculator").modal()
        }
       
    }

    function addFromSearchProducts(productId) {
        $.ajax({
            url: "{{ route('employe.productPrice') }}",
            type: 'GET',
            data: {
                productId: productId
            },
            success: function(data) {
                let tbody = document.getElementById("order");
                let tr = '<tr id="tr_' + data.id + '"><td><div class="product-name" style="text-align: left;">' + data.label + '</div></td><td>' + data.price + '</td><td><button onclick="remove(' + data.id + ')" data-feather="x-circle" style="color:red">Supprimer</button></td><td>' + data.price + ' <input type="hidden" value="' + data.price + '"></td></tr>';
                tbody.innerHTML += tr;
                setTotal();
            }
        })

    }

    function add(id, label, price) {
        let tbody = document.getElementById("order");
        let tr = '<tr id="tr_' + id + '"><td><div class="product-name" style="text-align: left;">' + label + '</div></td><td>' + price + '</td><td><button onclick="remove(' + id + ')" data-feather="x-circle" style="color:red">Supprimer</button></td><td>' + price + ' <input type="hidden" value="' + price + '"></td></tr>';
        tbody.innerHTML += tr;
        setTotal();
    }

    function remove(id) {
        document.getElementById('tr_' + id).remove();
        setTotal();
    }

    function setTotal() {
        var totalHt = 0;
        let elements = document.getElementById('order');
        for (let i = 0; i < elements.children.length; i++) {
            totalHt = totalHt + parseFloat(elements.children[i].children[3].children[0].value);
        }
        total = totalHt + (totalHt * "{{ auth()->user()->store->tva }}" / 100);
        total = total.toFixed(2);
        document.getElementById('total').innerHTML = total;
        document.getElementById('totalHidden').value = total;
        document.getElementById('totalHt').innerHTML = totalHt;
        document.getElementById('totalHtHidden').value = totalHt;
    }

    function getCustomerPoints(customerId) {
        $.ajax({
            url: "{{ route('employe.customers.points') }}",
            type: 'GET',
            data: {
                customer_id: customerId
            },
            success: function(data) {
                document.getElementById('redMad').innerHTML = data.mad_red;
                document.getElementById('redMadHidden').value = data.mad_red;
                document.getElementById('redPts').innerHTML = data.points_red;
                document.getElementById('redPtsHidden').value = data.points_red;
            }
        })
    }

    function reduction() {
        if (document.getElementById('switchReduction').checked == true) {
            if (document.getElementById('customers').value == 0) {
                alert('Please choose the customer')
                document.getElementById('switchReduction').checked = false;
            } else {
                var totalHt = document.getElementById('totalHtHidden').value;
                var redMadElement = document.getElementById('redMadHidden');
                var redMad = redMadElement.value;
                var diff = totalHt - redMad;
                var newtotal = (Math.ceil(diff * (1 + ("{{ auth()->user()->store->tva }}" / 100))))
                document.getElementById('total').innerHTML = newtotal;
                document.getElementById('totalHidden').innerHTML = newtotal;
            }
        } else {
            if (document.getElementById('customers').value == 0) {
                alert('Please choose the customer')
                document.getElementById('switchReduction').checked = false;
            } else {
                var totalHt = document.getElementById('totalHidden').value;
                document.getElementById('total').innerHTML = totalHt;
                document.getElementById('totalHidden').innerHTML = totalHt;
            }
        }
    }

    function getProductsByMenuid(menuId) {
        $.ajax({
            url: "{{ route('employe.products.menus') }}",
            type: 'GET',
            data: {
                menu_id: menuId
            },
            success: function(data) {
                console.log(data);
                var html = '';
                Object.values(data).forEach(element => {
                    let label = element.label;
                    path = element.image!='' ?  "{{asset('uploads/products/')}}"+"/"+element.store_id+"/"+element.image : "https://via.placeholder.com/100x100";
                    html = html + "<li class='file-box' style='margin: 1%;width: 155px;' onclick='add(" + element.id + "," + "`" + label + "`" + "," + element.price + ")'><div class=''><img  style='width:100%' height='100' src='"+ path + "'></div> <p style='text-align:center;white-space: nowrap;'>" + element.label + "<br>  " + element.price + " MAD</p></li>"
                });
                document.getElementById('listProducts').innerHTML = html;
            }
        })
    }

    function reductionCode() {
        var code = document.getElementById('redCode').value;
        var customerId = document.getElementById('customers').value;
        var totalHtElement = document.getElementById('totalHtHidden');
        var errorElement = document.getElementById('code_red_error');
        var error = 'Veuillez choisir un client et un code valide !';

        if (totalHtElement.value == '') {
            error = error + '<br> Veuillez choisir des produits';
        }
        if (customerId != 0 && code != '' && totalHtElement.value != '') {
            errorElement.innerHTML = '';
            $.ajax({
                url: "{{url('employe/customer/code/red')}}",
                data: {
                    code: code,
                    customer_id: customerId
                },
                type: 'GET',
                success: function(data) {
                    if (data.success == 1) {
                        var totalHt = parseFloat(totalHtElement.value);
                        var red_value = data.code;
                        var newTotal = totalHt - totalHt * red_value;
                        total = newTotal + (newTotal * "{{ auth()->user()->store->tva }}" / 100);
                        total = total.toFixed(2);
                        document.getElementById('total').innerHTML = total;
                        document.getElementById('totalHidden').value = total;
                        document.getElementById('totalHt').innerHTML = totalHt;
                        document.getElementById('totalHtHidden').value = totalHt;
                    } else {
                        $('#code_red_error').html(data.message);
                        document.getElementById('redCode').value = '';
                    }
                }

            })
        } else {
            errorElement.innerHTML = error;
            document.getElementById('redCode').value='';
        }
    }

    function createCustomer() {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('#phone').val();
        var sexe = $('#sexe').val();
        var email = $('#email').val();
        var birth = $('#birth').val();
        var user_id = "{{ auth()->user()->id }}";
        var store_id = "{{ auth()->user()->store->id }}";
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('employe.customers.store') }}",
            type: 'POST',
            data: {
                type: 1,
                firstname: firstname,
                lastname: lastname,
                phone: phone,
                sexe: sexe,
                email: email,
                birth: birth,
                user_id: user_id,
                store_id: store_id,
                _token: _token
            },
            success: function(data) {
                $('#customers').append(data);
                $('#close').click();
            },
            error: function(error) {
                console.log(error.responseText.errors)
                $('#customersErrors').html(error.responseText.errors); //
            }
        })
    }

    function dis(val) {
        document.getElementById("result").value += val
    }

    //function that evaluates the digit and return result
    function solve() {
        let x = document.getElementById("result").value
        let y = eval(x)
        document.getElementById("result").value = y
    }

    //function that clear the display
    function clr() {
        document.getElementById("result").value = ""
    }

    function print()
    {
        
        let productsId = getProducts();
        let customerId = document.getElementById('customers').value;
        let reductionCode = document.getElementById('redCode').value;
        let isUseReduction = document.getElementById('switchReduction').checked;
        let total = document.getElementById('totalHidden').value;
        let totalHt = document.getElementById('totalHtHidden').value;
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                url: "{{route('employe.invoices.store')}}",
                data: {
                    code_valide: reductionCode,
                    customer: customerId,
                    products:productsId,
                    use_points:isUseReduction,
                    montant_paye:total,
                    total : total,
                    total_ht : totalHt,
                    _token: _token,
                },
                type: 'POST',
                success: function(data) {
                    window.location.href = "{{route('employe.invoices')}}"
                }

            })
    }

    function getProducts(){
        let productsId =  [];
        var elements = document.getElementById('order').childNodes;
        var trIds = Array.from(elements);
        delete trIds[0];
        trIds.map((element)=> {
            trId = element.id;
            id = trId.replace('tr_','');
             productsId.push(id);
        })
        return productsId;
    }

</script>
@endsection