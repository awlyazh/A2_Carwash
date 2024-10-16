<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Warna latar belakang */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333; /* Warna teks judul */
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555; /* Warna teks label */
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s; /* Transisi border */
        }
        input:focus {
            border-color: #007bff; /* Warna border saat fokus */
            outline: none; /* Menghilangkan outline default */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Warna biru */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transisi latar belakang */
        }
        button:hover {
            background-color: #0056b3; /* Warna biru lebih gelap saat hover */
        }
        .form-footer {
            text-align: center;
            margin-top: 15px;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline; /* Garis bawah saat hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <div class="form-footer">
            <p><a href="#">Forgot Password?</a></p> <!-- Tautan untuk mengatur ulang password -->
        </div>
    </div>
</body>
</html>
