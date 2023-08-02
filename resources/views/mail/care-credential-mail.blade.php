<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avanzando Juntos Care Home Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            padding: 10px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Avanzando Juntos Care Home Credentials</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We are excited to provide you with your credentials for the Avanzando Juntos Care Home platform. Please use the following information to access your account:</p>
            <ul>
                <li><strong>Email:</strong> {{ $data['email'] }}</li>
                <li><strong>Password:</strong> {{ $data['password'] }}</li>
            </ul>
            <p>We recommend that you change your password after your initial login for security reasons.</p>
            <p>Thank you for choosing Avanzando Juntos Care Home!</p>
            <p>Best regards,<br>The Avanzando Juntos Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Avanzando Juntos Care Home</p>
        </div>
    </div>
</body>
</html>
