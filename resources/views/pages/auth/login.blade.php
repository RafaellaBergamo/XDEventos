@extends('layout.master-mini')
@section('content')
<link rel="stylesheet" href="/css/forgotpassword.css"> 
<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: linear-gradient(to bottom right, rgba(191, 224, 242, 0.29), rgba(191, 224, 242, 0)), url('/assets/images/auth/background-login.png'); background-size: cover;">
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">
      <div class="auto-form-wrapper">
      <h4 class="text-center mb-4">Login</h4>
        <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
          {{ csrf_field() }}
          <div class="form-group">
            <label class="label">Email</label>
            <div class="input-group">
              <input type="email" name="email" class="form-control inputs-login" placeholder="exemplo@email.com" required>
            </div>
          </div>
          <div class="form-group">
            <label class="label">Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="*********" required>
                <div class="input-group-append">
                    <span class="input-group-text eye-login">
                    <i id="icon" class="mdi mdi-eye-outline"></i>
                    </span>
                </div>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block">Entrar</button>
          </div>
          <div class="form-group d-flex justify-content-between">
            <a href="#" id="forgot-password" class="text-small forgot-password text-black">Esqueci a senha</a>
          </div>
          <div class="text-block text-center my-3">
            <span class="text-small font-weight-semibold">Novo por aqui ?</span>
            <a href="{{ url('/auth/register') }}" class="text-black text-small">Crie sua conta</a>
            <input type="hidden" id="token" value="{{ csrf_token() }}">
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

@endsection

@push('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@endpush

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script type="text/javascript" src="/assets/js/auth/login.js"></script>
<script type="text/javascript" src="/assets/js/auth/forgotpassword.js"></script>

<script>
 $(document).ready(function($){
    <?php
    if(isset($error))
    {
    ?> 
      error_login("<?php echo $error ;?>")
    <?php
      unset($error);
    }
    
    ?>
  })
</script>