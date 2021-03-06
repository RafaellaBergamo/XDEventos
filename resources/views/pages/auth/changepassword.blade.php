@extends('layout.master-mini')
@section('content')
<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"  style="background-image: linear-gradient(to bottom right, rgba(191, 224, 242, 0.29), rgba(191, 224, 242, 0)), url('/assets/images/auth/background-login.png'); background-size: cover;">
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">
      <div class="auto-form-wrapper">
      <h4 class="text-center mb-4">Alterar Senha</h4>
        <form action="{{ route('change-password') }}" id="forgot-password-form" class="needs-validation" novalidate method="POST">
          {{ csrf_field() }}

            <div class="form-group">
                <label class="label">Nova Senha</label>
                <div class="input-group">
                <input type="password" class="form-control" onkeyup="verifyPassword()" name="password" id="password" placeholder="*********" required>
                <div class="input-group-append">
                    <span class="input-group-text eye">
                    <i id="icon" class="mdi mdi-eye-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <label class="label">Digite Novamente</label>
                <div class="input-group">
                <input type="password" class="form-control" onblur="matchPassowrd()"  name="newpassword" id="newpassword" placeholder="*********" required>
                <div class="input-group-append">
                    <span class="input-group-text eye">
                    <i id="icon" class="mdi mdi-eye-outline"></i>
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
                <button class="btn btn-primary submit-btn btn-block">Salvar</button>
                <input type="hidden" name="id" id="id" value="{{ $id }}">
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript" src="/assets/js/auth/forgotpassword.js"> </script>

<script>
  $(document).ready(function($){
    <?php 
      if(isset($success)){
    ?>
        response_modal("<?php echo $message; ?>")
    <?php
        unset($success);
      }
    ?>
  })
</script>
