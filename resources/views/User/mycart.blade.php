<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{url("posts")}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>


                            {{-- <p class="card-text">{{ $product['category']['name'] }}</p> <!-- Assuming category is part of the product array --> --}}
        <div class="container mt-5">
        {{-- <h2>Hello, {{ $user->name }}</h2> <!-- Displaying the user's name --> --}}

            @if(!empty($products))
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-3"> <!-- Each product takes up 4 columns in a 12-column grid -->
                            <div class="card" style="width: 100%;">
                                <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}">
                                <div class="card-body">
                                    <h1>{{ $product['name'] }}</h1>
                                    <p class="card-text">{{ $product['price'] }}</p>
                                    <p class="card-text">{{ $product['qty'] }}</p>
                                    {{-- <p class="card-text">{{ $product['category']['name'] }}</p> <!-- Assuming category is part of the product array --> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <form action="{{ url('makeOrder') }}" method="post">
                    @csrf
                    <input type="date" name="day" id="">
                    <button type="submit" class="btn btn-success">Make Order</button>
                </form>
            @else
                <div class="alert alert-warning">
                    Please add to cart first.
                </div>
            @endif
        </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>