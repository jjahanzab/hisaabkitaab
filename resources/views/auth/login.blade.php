@extends('layouts.app')

@section('content')
<div class="container">
    
  <div class="row">
    <div class="offset-md-3 col-md-6 login-form-box">
      
      <form method="POST" action="{{ route('login') }}" class="form-signin">
        @csrf
        <h1 class="h3 mb-3 font-weight-normal text-center">Sign in</h1>
        <hr>

        <div class="form-group">
          <label for="exampleInputEmail1">{{ __('E-Mail') }}</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">{{ __('Password') }}</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter your password">
          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <button class="btn btn-lg btn-secondary btn-block" type="submit">Sign in</button>
      </form>

    </div>
  </div>

</div>
@endsection
