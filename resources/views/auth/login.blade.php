<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" type="image/png" href="{{ asset('images/Logo_PPATK_(2014).png') }}">
  <link rel="shortcut icon" href="{{ asset('images/Logo_PPATK_(2014).png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/Logo_PPATK_(2014).png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #1E3A8A 0%, #475569 100%);
      overflow: hidden;
      position: relative;
    }

    /* Animasi latar belakang */
    .circle {
      position: absolute;
      border-radius: 50%;
      opacity: 0.1;
      animation: float 8s infinite ease-in-out alternate;
    }

    .circle:nth-child(1) {
      width: 250px;
      height: 250px;
      background: #ffffff;
      top: 10%;
      left: 15%;
      animation-delay: 0s;
    }

    .circle:nth-child(2) {
      width: 300px;
      height: 300px;
      background: #ffffffcc;
      bottom: 10%;
      right: 10%;
      animation-delay: 2s;
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      100% { transform: translateY(25px); }
    }

    .login-container {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 380px;
      background: #fff;
      padding: 40px 32px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }

    .logo img {
      width: 80px;
      height: 80px;
      object-fit: contain;
      filter: drop-shadow(0 0 8px #1E3A8A44);
    }

    h2 {
      text-align: center;
      color: #1E3A8A;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 18px;
      position: relative;
    }

    .form-group i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #1E3A8A;
      font-size: 1.1rem;
    }

    .form-group input {
      width: 100%;
      padding: 10px 10px 10px 35px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-color: #1E3A8A;
      outline: none;
      box-shadow: 0 0 5px #1E3A8A44;
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      background: #1E3A8A;
      color: #fff;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    button:hover {
      background: #162E6A;
      transform: translateY(-2px);
    }

    .footer-text {
      text-align: center;
      font-size: 0.85rem;
      color: #666;
      margin-top: 18px;
    }

    .footer-text a {
      color: #1E3A8A;
      text-decoration: none;
      font-weight: 500;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 16px;
      font-size: 0.9rem;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 30px 20px;
        max-width: 90%;
      }
      h2 {
        font-size: 1.3rem;
      }
    }
  </style>
</head>

<body>
  <!-- Elemen dekorasi animasi -->
  <div class="circle"></div>
  <div class="circle"></div>

  <!-- Form Login -->
  <form method="POST" action="{{ route('login') }}" class="login-container">
    @csrf
    <div class="logo">
      <!-- Bootstrap Icon as Company Logo -->
      <i class="bi bi-building" style="font-size: 80px; color: #1E3A8A; filter: drop-shadow(0 0 8px #1E3A8A44);"></i>
    </div>
    <h2>Login</h2>
    <p style="text-align:center; font-weight:normal; ">Masukkan Username dan Password</p>

    <div class="form-group">
      <i class="bi bi-person-circle"></i>
      <input type="text" name="username" placeholder="Username" required>
    </div>

    <div class="form-group">
      <i class="bi bi-shield-lock-fill"></i>
      <input type="password" name="password" placeholder="Password" required>
    </div>

    <button type="submit">Login</button>

    @if($errors->any())
      <div class="error-message">{{ $errors->first() }}</div>
    @endif

    <div style="font-size:0.8rem" class="footer-text">
      © 2025 <a href="/login">Pusdiklat APU-PPT PPATK</a>. All rights reserved.
    </div>
  </form>

  {{-- Session Refresh JS --}}
  <script>
    // Intercept login submit: refresh session+CSRF first, then submit form with new token.
    (function(){
      const form = document.querySelector('form.login-container');
      if (!form) return;

      form.addEventListener('submit', async function(e){
        e.preventDefault();

        try {
          const resp = await fetch('/session/refresh', { credentials: 'same-origin' });
          if (!resp.ok) throw new Error('refresh-failed');
          const data = await resp.json();

          // Update meta and hidden input _token
          const meta = document.querySelector('meta[name="csrf-token"]');
          if (meta && data.new_token) meta.setAttribute('content', data.new_token);

          const tokenInput = form.querySelector('input[name="_token"]');
          if (tokenInput && data.new_token) tokenInput.value = data.new_token;

          // Now submit the form normally
          form.submit();
        } catch (err) {
          // On failure, still try to submit (user can refresh manually)
          form.submit();
        }
      });
    })();
  </script>

</body>
</html>
