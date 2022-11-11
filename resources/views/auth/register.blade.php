<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Регистрация</title>
    <!-- base:css -->
    <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/vendors/feather/feather.css">
    <link rel="stylesheet" href="/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo">
                            <img src="/images/logo-dark.svg" alt="logo">
                        </div>
                        <h4>Впервые у нас?</h4>
                        <h6 class="font-weight-light">Присоеденяйтесь и получите месяц подписки бесплатно</h6>

                        @error('email')
                        <div class="col-md-12">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror

                        @error('name')
                        <div class="col-md-12">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror

                        @error('password')
                        <div class="col-md-12">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror

                        <form class="pt-3" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label>Имя</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-account-outline text-primary"></i>
                                      </span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg border-left-0" name="name" value="{{old('name')}}" placeholder="Имя">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-email-outline text-primary"></i>
                      </span>
                                    </div>
                                    <input type="email" name="email" class="form-control form-control-lg border-left-0" value="{{old('email')}}" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Пароль</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                      </span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="********">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Повторите пароль</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                      </span>
                                    </div>
                                    <input type="password" name="password_confirmation" required autocomplete="new-password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="********">
                                </div>
                            </div>



                            {{--                            <div class="mb-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <label class="form-check-label text-muted">--}}
{{--                                        <input type="checkbox" class="form-check-input">--}}
{{--                                        I agree to all Terms & Conditions--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="mt-3">
                                <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">Зарегистрироваться</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Уже есть аккаунт? <a href="{{route('login')}}" class="text-primary">Войдите</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 register-half-bg d-flex flex-row">
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; {{date('Y')}}  Все права защищены</p>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable-collapse.js"></script>
<script src="/js/template.js"></script>
<!-- endinject -->
</body>

</html>
