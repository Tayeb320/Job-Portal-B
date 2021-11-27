@extends('auth.master')
@section('title')
    Login
@endsection
@section('main-content')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <span class="d-none d-lg-block">Job Portal</span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your email & password to login</p>
                        </div>

                        <form action="{{ route('login.post') }}" method="POST" class="row g-3 needs-validation" novalidate>
                            @csrf
                            @if(Session::has('success'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{Session::get('success')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @elseif(Session::has('danger'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{Session::get('danger')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="col-12">
                                <label for="email" class="form-label">email</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    <input type="email" autofocus name="email" class="form-control" id="email"
                                           required>
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                       required>
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="credits">

                </div>

            </div>
        </div>
    </div>

</section>
@endsection
