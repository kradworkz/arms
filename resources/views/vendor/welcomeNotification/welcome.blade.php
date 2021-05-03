<!doctype html>
<html lang="en">

<head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Krad was here" name="description" />
    <meta content="KradWasHere" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

    <link rel="shortcut icon" href="assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>

    <body data-topbar="dark" data-layout="horizontal">
        <div id="app"> 

            <div class="account-pages my-5 pt-sm-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card overflow-hidden">
                                <div class="bg-soft-primary">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-4">
                                                <h5 class="text-primary"> Set Password</h5>
                                                <p>Set your new password.</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0"> 
                                    <div>
                                        <a href="index.html">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <span class="avatar-title rounded-circle bg-light">
                                                    <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <div class="p-2">
                                        <form class="form-horizontal" method="POST">
                                                @csrf
                                            <input type="hidden" name="email" value="{{ $user->email }}"/>
                                            <div class="form-group">
                                                <label for="useremail">Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Enter password" required autocomplete="new-password">
                                            </div>
                                            <div class="form-group">
                                                <label for="useremail">Confirm Password</label>
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="Re-enter password" required autocomplete="new-password">
                                            </div>
                        
                                            <div class="form-group row mb-0">
                                                <div class="col-12 text-right">
                                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                                </div>
                                            </div>
        
                                        </form>
                                    </div>
                
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <p>© 2021 DOST-IX</p>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
{{-- 
<form method="POST">
    @csrf

    <input type="hidden" name="email" value="{{ $user->email }}"/>

    <div>
        <label for="password">{{ __('Password') }}</label>

        <div>
            <input id="password" type="password" class="@error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">

            @error('password')
            <span>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div>
        <label for="password-confirm">{{ __('Confirm Password') }}</label>

        <div>
            <input id="password-confirm" type="password" name="password_confirmation" required
                   autocomplete="new-password">
        </div>
    </div>

    <div>
        <button type="submit">
            {{ __('Save password and login') }}
        </button>
    </div>
</form> --}}
