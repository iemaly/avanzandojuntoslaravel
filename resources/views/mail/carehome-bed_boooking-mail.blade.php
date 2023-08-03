<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed Booking</title>
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
        .button {
            display: inline-block;
            background-color: #007BFF;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bed Booking - Avanzando Juntos</h1>
        </div>
        <div class="content">
            <p>{{$data['body']}}</p>
            <p><a class="button" href="{{ env('CAREHOME_URL') }}/Chat">Chat</a></p>
            <p>Thank you for choosing Avanzando Juntos!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Avanzando Juntos</p>
        </div>
    </div>
</body>
</html>
