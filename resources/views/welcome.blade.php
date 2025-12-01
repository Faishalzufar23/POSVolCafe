<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>POSVolCafe</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background: radial-gradient(circle at 20% 20%, #e0f2ff 0%, #f8fbff 40%, #ffffff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            padding: 20px;
        }

        .container {
            text-align: center;
            max-width: 650px;
            animation: fadeIn 1.2s ease forwards;
            opacity: 0;
        }

        h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        p {
            font-size: 18px;
            color: #475569;
            margin-bottom: 35px;
        }

        button {
            padding: 14px 34px;
            font-size: 16px;
            font-weight: 600;
            background: #0f172a;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1e293b;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Selamat Datang</h1>
        <p>POSVolCafe — Sistem Kasir Khusus untuk cafe Vol Fortuin</p>

        <button onclick="window.location.href='/admin'">Masuk</button>
    </div>
</body>
</html>
