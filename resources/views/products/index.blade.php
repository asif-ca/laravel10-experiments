<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>
<body>
    <h1>Products List</h1>

    <ul>
        <li>
            <strong>Product Name --- Price</strong>
        </li>

        @forelse ($products as $product)
            <li>
                {{$product->name}} -- {{$product->price}}
            </li>
        @empty
            <h6>No Produts Found</h6>
        @endforelse
    </ul>
    
</body>
</html>