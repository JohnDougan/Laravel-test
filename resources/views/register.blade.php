<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Регистрация</title>

    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>

    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-4 mt-3">
                <h3 class="mb-3">Регистрация</h3>

                @if (!empty($errors))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors }}
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="login">Ваш логин</label>
                        <input type="text" id="login" class="form-control" name="login" required="required">
                    </div>
                    <div class="form-group">
                        <label for="pass">Ваш пароль</label>
                        <input type="password" id="pass" class="form-control" name="pass" required="required">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Вы хотите</label>
                        <select class="form-select" name="type">
                            <option value="buyer">Покупать</option>
                            <option value="seller">Продавать</option>
                        </select>
                    </div>
                    <div class="text-end"><input type="submit" class="btn btn-primary" value="Регистрация"></div>
                    <div class="text-end"><a href="{{ url('/login') }}">Вход</a></div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
