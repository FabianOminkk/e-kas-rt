<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | KAS RT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #f1c40f; /* Kuning Emas seperti Koin */
            --secondary-color: #27ae60; /* Hijau Uang */
            --dark-bg: #1e272e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            /* Background variasi pola titik-titik halus */
            background-image: radial-gradient(#34495e 1px, transparent 1px);
            background-size: 30px 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            width: 350px;
            position: relative;
            overflow: hidden;
        }

        /* Variasi hiasan di pojok box */
        .login-box::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0.2;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Icon Koin Sederhana pake CSS */
        .coin-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            font-weight: bold;
            color: #fff;
            box-shadow: 0 4px 0 #d4ac0d;
            margin-bottom: 10px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h2 {
            margin: 0;
            color: #2c3e50;
            letter-spacing: 2px;
            font-weight: 800;
        }

        .sub-title {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 600;
            color: #34495e;
        }

        .input-field input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ecf0f1;
            border-radius: 12px;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .input-field input:focus {
            border-color: var(--secondary-color);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #219150;
            letter-spacing: 1px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #bdc3c7;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="header">
            <div class="coin-icon">$</div>
            <h2>KAS RT</h2>
            <div class="sub-title">KEUANGAN DI KELOLA FULL DENGAN KOMANG DINA SETYAWATI S.M</div>
        </div>

   <form action="{{ route('login') }}" method="POST">
    @csrf 
    
    <div class="input-field">
        <label>ID PENGGUNA</label>
        <input type="email" name="email" placeholder="Masukkan ID..." required>
    </div>

    <div class="input-field">
        <label>KATA SANDI</label>
        <input type="password" name="password" placeholder="Masukkan Password..." required>
    </div>

    <button type="submit" class="btn-submit">LOGIN SEKARANG</button>
</form>

        <div class="footer">
            Dikembangkan oleh <b>Fabian Project</b> &copy; 2026
        </div>
    </div>

</body>
</html>
