<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.min.css"
  rel="stylesheet"
/>
<!-- MDB JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <title>@yield('title') | {{config('app.name')}}</title>
    <link rel="icon"  href="{{asset('logo1.svg')}}"/>
</head>
<body>


<div class="container-fluid ">
   
  <div class="row">
    @hasSection('sidebar')
    <!--sidebar-->
    <div class="col-2">
        @yield('sidebar')
    @endif
    </div>
    <!--content-->
   <div class="col">
    @if ($errors->any())

    <div class="alert alert-danger" role="alert">
      <strong>errors</strong>
      
        @foreach ($errors->all() as $error )
            <li class="list-group-item">{{$error}} </li>
        @endforeach
    </div>
    @endif
    @yield('content')
   </div>
    
  </div>

   
    @yield('styles')

    @yield('footer')
    @yield('scripts')
   
</div>

</body>
</html>
