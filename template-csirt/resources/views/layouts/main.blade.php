<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Core CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/custom.css" rel="stylesheet">
    <!-- Swiper CSS
    <link href="/css/swiper-bundle.min.css" rel="stylesheet"> -->
    <script nonce="{{ csp_nonce() }}" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style> 
      .hero {
        @foreach ($propertiez->take(1) as $property)
          background-image: url('{{ asset('storage/' . $property->image) }}');
        @endforeach
      }
      .pdfobject-container { 
        height: 100vh;
        border: 1rem solid rgba(0,0,0,.1);
      }
    </style>
    <title>{{ $nama }}</title>
    @foreach ($properties->where('property', 'Logo')->take(1) as $property)
      <link rel="icon" href="{{ asset('storage/' . $property->image) }}">
    @endforeach   
  </head>

  <body>
      @include('layouts.navbar')
      
      @includeWhen($includeHero, 'layouts.hero')

      <div class="m-0 p-0">
          @yield('container')
      </div>

      @include('layouts.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
      var nav=document.querySelector('nav');

      window.addEventListener('scroll', function(){
          if(window.pageYOffset > 30){
              nav.classList.add('bg-dark', 'shadow', 'navbar-dark');
          } else {
              nav.classList.remove('bg-dark', 'shadow', 'navbar-dark')
          }
      })

      $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '/login/reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
      });

      // Close the dropdown if the user clicks outside of it
      document.addEventListener('DOMContentLoaded', function() {
        var dropdownButton = document.getElementById('dropdownButton');
        var dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', function() {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown if clicked outside
        document.addEventListener('click', function(event) {
            var isClickInside = dropdownButton.contains(event.target) || dropdownMenu.contains(event.target);
            if (!isClickInside) {
                dropdownMenu.classList.add('hidden');
            }
        });
      });

    </script>
  </body>
</html>
