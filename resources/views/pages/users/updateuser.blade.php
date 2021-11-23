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
            <h2 class="card-title mb-0"> Atualizar Cliente
            </h2>
            
        </div>

        <div class="card-body" style="padding-bottom: 0.229rem;">

            <form id="users-form" action="{{ route('save-update-user') }}" class="needs-validation" novalidate method="POST">
                {{ csrf_field() }}
                <div class="grid-update-user">
                    <div id="confm1" class="text-sm-center" >
                       <label> Código: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control chvAcesso text-center" name="id" value="{{ $user->id }}" readonly />
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Nome: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-left" name="name" value="{{ $user->user_name }}" required/>
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Sexo: </label>
                   </div>
                    <div class="col-lg-12 col-md-8 col-sm-6 form-check-inline">
                        <label class="form-check-label">
                        <input type="radio" name="gender" value="F" <?php if($user->user_gender == "F") echo "checked" ?> class="form-radio-flat"> Feminino </label>
                    </div>  
                    <div class="col-lg-12 col-md-8 col-sm-6 form-check-inline">
                        <label class="form-check-label">
                        <input type="radio" name="gender" value="M" <?php if($user->user_gender == "M") echo "checked" ?> class="form-radio-flat"> Masculino </label>
                    </div> 

                    <div id="confm1" class="text-sm-center" >
                       <label> Telefone: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-center" id="phone" value="{{ $user->user_phone }}" name="phone" required />
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Situação: </label>
                   </div>
                   <div id="confm2" class="text-sm-left ">
                        <select class="form-control select-states-users" name="sit" required>
                            <option value="A"  <?php if($user->user_sit == "A") echo "selected" ?> > Ativo </option>
                            <option value="I"  <?php if($user->user_sit == "I") echo "selected" ?> > Inativo </option>
                        </select>
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> UF: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <select class="form-control select-states-users" id="state" name="state" required>
                            <option value=""></option>
                            @foreach ($states as $state)
                                <option value="{{ $state['sigla'] }}" <?php if($user->user_state == $state['sigla']) echo "selected" ?>  > {{ $state['sigla'] }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="confm1" class="text-sm-center" >
                        <label> Cidade: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <select class="form-control select-states-users" id="city" name="city" required>
                            <option value=""></option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['nome'] }}" <?php if($user->user_city == $city['nome']) echo "selected" ?>  > {{ $city['nome'] }} </option>
                            @endforeach
                        </select>
                    </div> 

                    <div id="confm1" class="text-sm-center" >
                       <label> Email: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <input type="email" class="form-control" name="email" value="{{ $user->user_email }}" required>
                    </div>  

                    <div id="confm1" class="text-sm-center" >
                       <label> Atual: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <input type="password" class="form-control" id="oldpassword" onkeyup="enabledNewPassword()" name="password" placeholder="digite a senha atual">
                    </div>

                    <div id="confm1" class="text-sm-center" >
                       <label> Nova: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <input type="password" class="form-control" readonly name="newpassword" onkeyup="verifyPassword()" id="password" placeholder="digite a nova senha">
                    </div>

                    <div id="password-status" style="display: none;">
                        <span id="uppercase"> <i class="mdi mdi-close-circle"></i> Uma letra maiúscula </span> <br>
                        <span id="special"> <i class="mdi mdi-close-circle"></i> Um caractere especial </span>  <br>
                        <span id="number"> <i class="mdi mdi-close-circle"></i> Um número </span>  <br>
                        <span id="lowercase"> <i class="mdi mdi-close-circle"></i> Uma letra minúscula </span> 
                    </div>
                </div>
                <hr>
                <div class="salvarEnt">
                    <button type="submit" class="btn btn-primary"> Salvar </button>
                    <button type="button" class="btn btn-secondary cancel-new-user"> Cancelar </button>
                </div>

                <input type="hidden" id="token" value="{{ csrf_token() }}">

            </form>
        </div>
    </div>
  </div>

 

</div>


@endsection



@push('plugin-scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
@endpush

@push('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@endpush
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js" integrity="sha512-Y/GIYsd+LaQm6bGysIClyez2HGCIN1yrs94wUrHoRAD5RSURkqqVQEU6mM51O90hqS80ABFTGtiDpSXd2O05nw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="/assets/js/pages/users.js"></script>

<script>
$(document).ready(function($){
    $("#cnpj").mask("99.999.999/9999-99")
    $("#phone").mask("(99) 99999-9999")
    <?php
    if(isset($saved))
    {
    ?> 
      response_modal("<?php echo $message ?>")
    <?php
      unset($saved);
    }
    
    ?>
})
</script>

