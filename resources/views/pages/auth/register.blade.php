@extends('layout.master-mini')

@section('content')
<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: linear-gradient(to bottom right, rgba(191, 224, 242, 0.29), rgba(191, 224, 242, 0)), url('/assets/images/auth/background-login.png'); background-size: cover;">
<link rel="stylesheet" href="/css/register.css">
  <div class="row w-100">
    <div class="col-lg-5 mx-auto">

      <div class="auto-form-wrapper">
      <h2 class="text-center mb-4">Nova Conta</h2>
        <form id="form-register" action="{{ route('create-account') }}" method="POST" class="needs-validation" novalidate>
          {{ csrf_field() }}
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control inputs-login" name="name" placeholder="Nome" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="email" class="form-control inputs-login" name="email" placeholder="Email" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select class="form-control inputs-login" id="state" name="state" required> 
                <option value=""> UF </option>
                @foreach ($states as $state)
                <option value="{{ $state['sigla'] }}"> {{ $state['sigla'] }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <select class="form-control inputs-login" id="city" name="city" disabled required> 
                <option value=""> Cidade </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control inputs-login" minlength="15" id="phone" name="phone" placeholder="Telefone" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select class="form-control  inputs-login" id="gender" name="gender" required> 
                <option value=""> Sexo </option>
                <option value="F"> Feminino </option>
                <option value="M"> Masculino </option>
              </select>
            
            </div>
          </div>
          
          <div class="form-group">
            <div class="input-group">
              <input type="password" onKeyUp="verifyPassword();" class="form-control inputs-login" name="password" required id="password"
              placeholder="Senha">
              <div class="input-group-append">
                <span class="input-group-text eye">
                  <i id="icon" class="mdi mdi-eye-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirme a Senha" required>
              <div class="input-group-append">
                <span class="input-group-text eye2">
                  <i id="icon2" class="mdi mdi-eye-outline"></i>
                </span>
              </div>
            </div>
          </div>

          <div id="password-status" style="display: none;">
            <span id="uppercase"> <i class="mdi mdi-close-circle"></i> Uma letra maiúscula </span> <br>
            <span id="special"> <i class="mdi mdi-close-circle"></i> Um caractere especial </span>  <br>
            <span id="number"> <i class="mdi mdi-close-circle"></i> Um número </span>  <br>
            <span id="lowercase"> <i class="mdi mdi-close-circle"></i> Uma letra minúscula </span> 
          </div>
         
          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block">Criar Conta</button>
          </div>
          <div class="text-block text-center my-3">
            <span class="text-small font-weight-semibold">Já tem uma conta ?</span>
            <a href="{{ url('/login') }}" class="text-black text-small">Entre</a>
          </div>

          <input type="hidden" id="token" value="{{ csrf_token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('plugin-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush

@push('custom-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@endpush

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js" integrity="sha512-Y/GIYsd+LaQm6bGysIClyez2HGCIN1yrs94wUrHoRAD5RSURkqqVQEU6mM51O90hqS80ABFTGtiDpSXd2O05nw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/assets/js/auth/register.js"> </script>

<script>
  $(document).ready(function($){
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