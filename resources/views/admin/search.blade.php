<!DOCTYPE html>

<html>

<head>

    <title>Laravel 5.7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</title>

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> --}}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

   

<div class="container">

    <h1>Laravel 5.7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</h1>   

    <input class="typeahead form-control" type="text">

</div>

   

<script type="text/javascript">

$(document).ready(function() {
    $( "input.typeahead" ).autocomplete({
      limit: 2,
      source: function(request, response) {
        $.ajax({
          url: "{{url('autocomplete')}}",
          data: {
            term : request.term
          },
          dataType: "json",
          success: function(data){
            var resp = $.map(data,function(obj){
                //   console.log(obj.title);
                  return obj.title;
            }); 

            response(resp);
          }
        });
      },
      minLength: 1
    });
  });
  
</script>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}

   

</body>

</html>