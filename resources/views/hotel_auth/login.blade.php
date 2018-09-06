<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" content="IE=9">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Awugo飯店後台管理_登入</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/signin.css">
        <style type="text/css">
          body{
            font-family: Microsoft JhengHei;
          }
        </style>
        <!--[if lt IE 9]>
        <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
        <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
 
    <body>
        <div class="container" style="max-width:100%;">
            <form class="form-signin" method="POST" role="form" action="{{$Hotel_ID}}">
                {{ csrf_field() }}
              <h1 class="h3 mb-3 font-weight-normal">Awugo飯店管理後台</h1>
              <label for="inputID" class="sr-only">請輸入帳號</label>
              <input type="text" id="inputID" name="inputID" class="form-control" placeholder="輸入帳號" value="{{ old('inputID') }}" required autofocus>
              <label for="inputPassword" class="sr-only">請輸入密碼</label>
              <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="輸入密碼" style="margin-top: 13px;" required>
              <div class="checkbox mb-3 d-none">
                <label>
                  <input type="checkbox" value="remember-me"> Remember me
                </label>
              </div>
              <button class="btn btn-lg btn-primary btn-block" type="submit">登　入</button>
              <!-- 錯誤訊息 -->
              @include('error_msg')
              <p class="mt-5 mb-3 text-center text-muted">&copy; 2017-2018 長龍科技股份有限公司</p>
            </form>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>
</html>
