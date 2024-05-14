<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP for Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            width: 200px;
        }

        p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
            text-align: center;
            max-width: 500px;
        }

        h2 {
            color: #007bff;
            font-size: 64px;
            text-align: center;
            margin: 20px 0;
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
            font-weight: bold;
        }

        .otp-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <h1>Hello,</h1>
        <p>Your one-time password (OTP) for resetting your password is:</p>
        <h2>{{ $otp }}</h2>
        <p>Please use this OTP to proceed with the password reset.</p>
        <p>If you did not request a password reset or have any concerns, please contact our support team immediately.
        </p>
        <p>Thanks for using our service.</p>
        <p>Best regards,</p>
        <p>{{ config('app.name') }}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
