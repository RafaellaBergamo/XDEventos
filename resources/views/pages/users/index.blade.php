@extends('layout.master')

@push('plugin-styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@section('content')
<head>   
<link rel="stylesheet" href="/css/users.css"> </head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h2 class="card-title mb-0"> Lista de Usuários 
                <div class="float-right">
                    <a href="/users/new-user"> 
                        <button type="button" class="btn btn-info btn-sm"> 
                            <i class="mdi mdi-account-plus"></i>
                            Usuário
                        </button>
                    </a>
                </div>
                </h2>
                
            </div>

            <div class="card-body" style="padding-bottom: 0.200rem;">
                <form id="users-form" action="{{ route('get-users') }}" method="POST">
                {{ csrf_field() }}
                    <div class="container grid-filtro" style="margin-left: 0 !important;">

                        <div class="col-lg-12 col-md-8 col-sm-6 text-center">
                            <label> UF: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <select class="form-control select-states-users" id="state" name="state">
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
                            <select class="form-control select-states-users" id="city" name="city" disabled>
                                <option value=""></option>
                            </select>
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

                        <div class="col-lg-12 col-md-8 col-sm-6 text-center">
                            <label> Nome: </label>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-6">
                            <input type="text" class="form-control" name="name" value=""> 
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

    @if(isset($users))
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body" style="padding-bottom: 0.229rem;">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-users">
                        <thead class="text-center">
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Sexo</th>
                            <th>Telefone</th>
                            <th>UF</th>
                            <th>Cidade</th>
                            <th>Situação</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td class="text-primary" style="font-size: 18px; cursor: pointer;"><i class="mdi mdi-pencil"></i></td>
                                <td class="text-danger" style="font-size: 18px; cursor: pointer;"><i class="mdi mdi-delete"></i></td>
                                <td class="text-center"> {{ $user->id }} </td>
                                <td> {{ $user->user_name }} </td>
                                <td> {{ $user->user_email }} </td>
                                <td class="text-center"> {{ $user->user_gender }} </td>
                                <td class="text-center"> {{ $user->user_phone }} </td>
                                <td class="text-center"> {{ $user->user_state }} </td>
                                <td> {{ $user->user_city }} </td>
                                <td class="text-center"> {{ $user->user_sit }} </td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@endpush
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>

<script type="text/javascript" src="/assets/js/pages/users.js"></script>

