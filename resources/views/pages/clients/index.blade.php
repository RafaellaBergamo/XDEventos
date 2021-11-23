@extends('layout.master')

@push('plugin-styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@section('content')
<head>   
<link rel="stylesheet" href="/css/clients.css"> </head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h2 class="card-title mb-0"> Lista de Clientes 
                <div class="float-right">
                    <a href="/clients/new-client"> 
                        <button type="button" class="btn btn-info btn-sm"> 
                            <i class="mdi mdi-account-plus"></i>
                            Cliente
                        </button>
                    </a>
                </div>
                </h2>
                
            </div>

            <div class="card-body" style="padding-bottom: 0.200rem;">
                <form id="clients-form" action="{{ route('get-clients') }}" method="POST">
                {{ csrf_field() }}
                    <div class="container grid-filtro" style="margin-left: 0 !important;">

                        <div class="col-lg-12 col-md-8 col-sm-6 text-center">
                            <label> UF: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <select class="form-control select-states-clients" id="state" name="state">
                                <option value=""></option>
                                @foreach ($states as $state)
                                    <option value="{{ $state['sigla'] }}"> {{ $state['sigla'] }} </option>
                                @endforeach
                            </select>
                        </div>   

                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <label> Cidade: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <select class="form-control select-states-clients" id="city" name="city" disabled>
                                <option value=""></option>
                            </select>
                        </div>      
                        
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <label> Origem: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6 form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="site" value="1"  class="form-radio-flat"> Site </label>
                        </div>   
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="facebook" value="1" class="form-radio-flat radio"> Facebook </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" >
                            <input type="checkbox" name="indicacao" value="1" class="form-radio-flat radio"> Indicação </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="boca" value="1"class="form-radio-flat radio"> Boca a Boca </label>
                        </div>

                        <div class="col-lg-12 col-md-8 col-sm-6 text-center">
                            <label> Nome: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <input type="text" class="form-control" name="name" value=""> 
                        </div>   
                        <div class="col-lg-12 col-md-8 col-sm-6 text-center">
                            <label> Situação: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6 form-check-inline">
                            <label class="form-check-label">
                            <input type="radio" name="sit" value="A"  class="form-radio-flat"> Ativo </label>
                        </div>  
                        <div class="col-lg-12 col-md-8 col-sm-6 form-check-inline">
                            <label class="form-check-label">
                            <input type="radio" name="sit" value="I"  class="form-radio-flat"> Inativo </label>
                        </div>  

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary search">
                            Pesquisar
                            </button>
                        </div>
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($clients))
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body" style="padding-bottom: 0.229rem;">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-clients">
                        <thead class="text-center style-th">
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CNPJ</th>
                            <th>Telefone</th>
                            <th>Origem</th>
                            <th>UF</th>
                            <th>Cidade</th>
                            <th>Situação</th>
                            <th>Observação</th>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr data-id="{{ $client->id }}">
                                <td class="text-primary" style="font-size: 18px; cursor: pointer;"><i class="mdi mdi-pencil"></i></td>
                                <td class="text-danger" style="font-size: 18px; cursor: pointer;"><i class="mdi mdi-delete"></i></td>
                                <td class="text-center"> {{ $client->id }} </td>
                                <td> {{ $client->client_name }} </td>
                                <td> {{ $client->client_email }} </td>
                                <td class="text-center"> {{ $client->client_cnpj }} </td>
                                <td class="text-center"> {{ $client->client_phone }} </td>
                                <td class="text-center"> {{ $client->client_origin }} </td>
                                <td class="text-center"> {{ $client->client_state }} </td>
                                <td> {{ $client->client_city }} </td>
                                <td class="text-center"> {{ $client->client_sit == 'A' ? 'Ativo' : 'Inativo' }} </td>
                                <td> {{ $client->client_obs }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>


@endsection



@push('plugin-scripts')

@endpush

@push('custom-scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@endpush
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>


<script type="text/javascript" src="/assets/js/pages/clients.js"></script>

