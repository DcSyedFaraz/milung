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
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer {
            font-size: 0.9rem;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }

        .content {
            width: 90%;
            margin: 0 auto;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px 24px;
            text-decoration: none;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        .button-container {
            margin-top: 30px;
        }

        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h1>{{ $sub }}</h1>
            <p>{{ $messages }}</p>
            <p>Thank you!</p>
            <div class="button-container">
                <a href="{{ config('app.url') }}" class="button">Login</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
