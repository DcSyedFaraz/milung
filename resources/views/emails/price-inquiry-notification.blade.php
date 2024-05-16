<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sub }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .footer {
            font-size: 0.8rem;
            color: #999;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $sub }}</h1>
        <p>{{ $messages }}</p>
        <p>Thank you!</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
