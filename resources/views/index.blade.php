<!DOCTYPE html>
<html lang="en" ng-app="petMemories">

<head>
  <base href="{!! asset('') !!}" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Landing Page - Start Bootstrap Theme</title>

  <!-- Bootstrap core CSS -->
  <link href="{!!asset('vendor/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="{!!asset('vendor/fontawesome-free/css/all.min.css') !!}" rel="stylesheet">
  <link href="{!!asset('vendor/simple-line-icons/css/simple-line-icons.css') !!}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="{!!asset('css/landing-page.min.css') !!}" rel="stylesheet">
  <link href="{!!asset('css/product.css') !!}" rel="stylesheet">

</head>

<body>
<div class="maincontainer" ng-view="">

</div>
  <!-- Bootstrap core JavaScript -->
  <script src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>
  <script src="{!! asset('vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <script src="{!! asset('app/lib/angular.min.js') !!}"></script>
  <script src="{!! asset('app/app.js') !!}"></script>
  <script src="{!! asset('app/controller/homecontroller.js') !!}"></script>
  <script src="{!! asset('app/services/common.js') !!}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
</body>

</html>
