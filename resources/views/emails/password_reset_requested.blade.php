<!DOCTYPE html>
<html>

<head>
    <title>Password Reset Requested</title>
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
        <h1>Password Reset Requested</h1>
        <p>Hello Admin,</p>
        <p>The following user has requested a password reset:</p>
        <ul>
            <li>User ID: {{ $user->userid }}</li>
            <li>Name: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
        </ul>
        <p>Please take necessary actions to assist the user in resetting their password.</p>
        <p>Thank you.</p>
    </div>
</body>

</html>
