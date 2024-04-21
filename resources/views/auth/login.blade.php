<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Admin Login</title>
</head>

<body>
  <section>
    <div class="login-container">
      <div class="heading-wrapper">
        <img src="https://logowik.com/content/uploads/images/hilton-hotels-resorts4207.jpg" style="width: 300px; height:150px;" alt="">
        <h1>College Project</h1>
      </div>
      <form action="{{route('loginProcess')}}" method="post">
        @csrf
        <div class="form-group">
          <div class="form-group flex-col">
            <label for="">Username:</label>
            <input type="text" name="username">
            @error('username')
            <p class="validation-error">
              {{$message}}
            </p>
            @enderror
          </div>
          <div class="form-group flex-col">
            <label for="">Password:</label>
            <input type="password" name="password">
            @error('password')
            <p class="validation-error">
              {{$message}}
            </p>
            @enderror
          </div>

          <div class="form-group flex-row">
            <button type="submit">Login</button>
            <a href="">Forget Password?</a>
          </div>
        </div>
      </form>
    </div>
  </section>
</body>

</html>