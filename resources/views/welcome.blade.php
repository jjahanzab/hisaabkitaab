@php
  $shop_name = 'Store App';
  $shop_contact = '';
  $address = '';
  $setting = \App\Setting::first();
  if ($setting && $setting->shop_name) {
    $shop_name = $setting->shop_name;
  }
  if ($setting && $setting->shop_contact) {
    $shop_contact = $setting->shop_contact;
  }
  if ($setting && $setting->address) {
    $address = $setting->address;
  }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$shop_name}}</title>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title1 {
                font-size: 84px;
            }
            .title2 {
                font-size: 34px;
            }
            .title3 {
                font-size: 24px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 16px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}"><b>Home</b></a>
                    @else
                        <a href="{{ route('login') }}"><b>Login</b></a>
                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title1">{{$shop_name}}</div>
                <div class="title2">{{$address}}</div>
                <div class="title3 m-b-md">{{$shop_contact}}</div>
            </div>
        </div>
    </body>
</html>
