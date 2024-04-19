<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css">
  <title>Admin Login</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="login-wrapper">
        <div class="logo">
          <img src="https://i.pinimg.com/originals/df/23/cf/df23cfda033104aa114abff01769a1ab.png" style="width: 200px; height: 120px;" alt="logo">
          <h1>College Project</h1>
        </div>
        <div class="login-form-wrapper">
          <form method="post" action="{{route('loginProcess')}}">
            @csrf
            <div class="form-group group-row align-center">
              <label style="width:35%;color:var(--textPrimary);font-weight:400">Username</label>
              <input type="text" name="username" class="grey-bg">
            </div>
            @error('username')
            <p class="validation-error">
              {{$message}}
            </p>
            @enderror
            <div class="form-group group-row align-center">
              <label style="width:35%;color:var(--textPrimary);font-weight: 400">Password</label>
              <input type="password" name="password" class="grey-bg">
            </div>
            @error('password')
            <p class="validation-error">
              {{$message}}
            </p>
            @enderror
            <div class="form-group group-column justify-center">
              <label style="width:25%"></label>
              <button class="login-btn" type="submit">Login</button>
              <a href="#" id="forgotPassword">Forgot Password?</a>
            </div>
          </form>
        </div>

      </div>
  </section>
</body>

</html>