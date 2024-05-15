<!DOCTYPE html>
<html>

<head>
    <title>Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 1rem;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- # Welcome to {{ config('app.name') }}! --}}

        <p>Hello {{ $user->name }},</p>

        <p>We are thrilled to inform you that your account has been successfully created. Please find your
            login details below:</p>

        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>One-Time Password (OTP):</strong> {{ $otp }}</li>
            <li><strong>OrderFlow Link:</strong> <a href="http://ordersystem.creatricx.com/">Click here</a></li>
        </ul>

        <p>Please use the provided credentials to log in to your account. If you have any questions or need further
            assistance, please don't hesitate to contact us.</p>

        <p>Thank you for joining us! We look forward to working with you.</p>

        <p>Regards,<br>
            {{ config('app.name') }}</p>
    </div>
</body>

</html>
