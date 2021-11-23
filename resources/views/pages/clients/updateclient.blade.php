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
            <h2 class="card-title mb-0"> Atualizar Cliente
            </h2>
            
        </div>

        <div class="card-body" style="padding-bottom: 0.229rem;">

            <form id="clients-update-form" class="needs-validation" action="{{ route('save-update-client') }}"
             method="POST" novalidate>
                {{ csrf_field() }}
                <div class="grid-new-client">
                    <div id="confm1" class="text-sm-center" >
                       <label> Código: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-center" name="id" value="{{ $client->id }}" readonly />
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Nome: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-left" name="name" value="{{ $client->client_name }}" required/>
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> E-Mail: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="email" class="form-control text-left"  value="{{ $client->client_email }}" name="email" required/>
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Doc.: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-center" id="cnpj" value="{{ $client->client_cnpj }}" 
                       pattern="^([0-9]{2}).([0-9]{3}).([0-9]{3})/([0-9]{4})-([0-9]{2})$" name="cnpj" required />
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Telefone: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                       <input type="text" class="form-control text-center" id="phone"  
                       value="{{ $client->client_phone }}" name="phone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" required />
                   </div>

                   <div id="confm1" class="text-sm-center" >
                       <label> Origem: </label>
                   </div>
                   <div id="confm2" class="text-sm-left">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="site" value="1" <?php if(str_contains($client->client_origin, "Site")) echo "checked"; ?> class="form-radio-flat"> Site </label>
                        </div>   
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="facebook" value="1" <?php if(str_contains($client->client_origin, "Facebook")) echo "checked"; ?> class="form-radio-flat radio"> Facebook </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" >
                            <input type="checkbox" name="indicacao" value="1" <?php if(str_contains($client->client_origin, "Indicação")) echo "checked"; ?> class="form-radio-flat radio"> Indicação </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="checkbox" name="boca" value="1" <?php if(str_contains($client->client_origin, "Boca")) echo "checked"; ?> class="form-radio-flat radio"> Boca a Boca </label>
                        </div>
                   </div>
                   
                   <div id="confm1" class="text-sm-center" >
                       <label> Situação: </label>
                   </div>
                   <div id="confm2" class="text-sm-left ">
                        <select class="form-control select-states-clients" name="sit" required>
                            <option value="A" <?php if($client->client_sit == "A") echo "selected";  ?> > Ativo </option>
                            <option value="I" <?php if($client->client_sit == "I") echo "selected";  ?> > Inativo </option>
                        </select>
                   </div>


                    <div id="confm1" class="text-sm-center" >
                       <label> UF: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <select class="form-control select-states-clients" id="state" name="state" required>
                            <option value=""></option>
                            @foreach ($states as $state)
                                <option value="{{ $state['sigla'] }}" <?php if($client->client_state == $state['sigla']) echo "selected";  ?>  > {{ $state['sigla'] }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="confm1" class="text-sm-center" >
                        <label> Cidade: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <select class="form-control select-states-clients" id="city" name="city" required>
                            <option value=""></option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['nome'] }}" <?php if($client->client_city == $city['nome']) echo "selected";  ?>  > {{ $city['nome'] }} </option>
                            @endforeach
                        </select>
                    </div> 
                    <div id="confm1" class="text-sm-center" >
                       <label> Obs: </label>
                    </div>
                    <div id="confm2" class="text-sm-left">
                        <input type="text" class="form-control text-left" value=" {{ $client->client_obs }}" name="obs" />
                    </div>
                </div>
                <hr>
                <div class="salvarEnt">
                    <button type="submit" class="btn btn-primary"> Salvar </button>
                    <button type="button" class="btn btn-secondary cancel-new-client"> Cancelar </button>
                    <input type="hidden" id="token" value="{{ csrf_token() }}" />
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
<script type="text/javascript" src="/assets/js/pages/clients.js"></script>

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

