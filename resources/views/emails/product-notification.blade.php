<!DOCTYPE html>
<html>

<head>
    <title>{{ $action === 'create' ? 'New Product Created' : 'Product Updated' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            margin-top: 0;
            color: #333;
        }

        p {
            font-size: 1.1rem;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        strong {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $action === 'create' ? 'New Product Created' : 'Product Updated' }}</h1>
        @if ($action === 'create')
            <p>A new product has been created:</p>
        @else
            <p>The product has been updated:</p>
        @endif

        @if ($action === 'create')
            <ul>
                <li><strong>Name:</strong> {{ $productDetails['name'] }}</li>
                <li><strong>Description:</strong> {{ $productDetails['description'] }}</li>
                {{-- <li><strong>Price:</strong> {{ $productDetails['price'] }}</li> --}}
            </ul>
        @endif

        <p>If you have any questions or require further information, please feel free to contact us.</p>
        <p>Thank you for your attention.</p>
    </div>
</body>

</html>
