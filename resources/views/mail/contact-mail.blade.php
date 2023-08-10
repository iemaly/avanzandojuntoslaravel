<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Form Submission</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f3f5;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }
  .container {
    max-width: 600px;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  h1 {
    color: #3498db;
    font-size: 28px;
    margin-bottom: 20px;
  }
  h2 {
    color: #333;
    font-size: 20px;
    margin-top: 30px;
  }
  p {
    color: #666;
    line-height: 1.6;
  }
  strong {
    color: #444;
  }
  .note {
    color: #777;
    font-style: italic;
    margin-top: 20px;
  }
  .signature {
    margin-top: 40px;
    color: #777;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Contact Form Submission</h1>
    <p>An inquiry has been submitted through the contact form. Here are the details:</p>
    
    <h2>Contact Details:</h2>
    <p><strong>Name:</strong> {{ $request['name'] }}</p>
    <p><strong>Subject:</strong> {{ $request['subject'] }}</p>
    <p><strong>Email:</strong> {{ $request['email'] }}</p>
    
    <h2>Message:</h2>
    <p>{{ $request['text'] }}</p>
    
    <p class="note">Please respond to this inquiry as soon as possible.</p>
    
    <p class="signature">Best regards,<br>Avanzando Juntos</p>
  </div>
</body>
</html>
