<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        .btn_primary {
            padding: 10px;
            background: rgb(88, 88, 251);
            color: white;
            font-weight: 600;
            text-decoration: none;
            border-radius: 3px
        }
        .container_cu{
            display: flex;
            justify-content: end;
        }
    </style>
</head>
<body>
    <h1>Products List</h1>

    @if(auth()->check() && auth()->user()->is_admin)
        <div class="container_cu">
            <a class="btn_primary" href="{{route('product.create')}}"> Create Product</a>
        </div>
    @endif
    
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