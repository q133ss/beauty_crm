<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Вход</title>
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
                        <h4>С возвращением!</h4>
                        <h6 class="font-weight-light">Рады видеть вас снова!</h6>
                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                          <span class="input-group-text bg-transparent border-right-0">
                                            <i class="mdi mdi-account-outline text-primary"></i>
                                          </span>
                                    </div>
                                    <input type="text" value="{{old('email')}}" name="email" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">Пароль</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                      </span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password">
                                </div>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                                        Оставаться в системе
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="auth-link text-black">Забыли пароль?</a>
                            </div>
                            @error('email')
                            <div class="col-md-12">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                            @error('password')
                            <div class="col-md-12">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="my-3">
                                <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn"  type="submit">Войти</button>
                            </div>
                            <div class="mb-2 d-flex">
                                <button type="button" class="btn btn-facebook auth-form-btn flex-grow mr-1">
                                    <i class="mdi mdi-facebook mr-2"></i>
                                    Facebook
                                </button>
                                <button type="button" class="btn btn-google auth-form-btn flex-grow ml-1">
                                    <i class="mdi mdi-google mr-2"></i>
                                    Google
                                </button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Нет аккаунта? <a href="{{route('register')}}" class="text-primary">Создайте</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; {{date('Y')}}  Все права защищены.</p>
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
