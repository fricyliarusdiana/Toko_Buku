<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c4a484);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
        }

        button {
            width: 100%;
            background-color: #4a90e2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c06c84;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Registrasi User</h2>
        <form action="proses_register_user.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" required>

            <label for="no_telepon">No Telepon:</label>
            <input type="number" name="no_telepon" id="no_telepon" required>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="3" required></textarea>

            <button type="submit">Register</button>
        </form>
    </div>

</body>

</html>
