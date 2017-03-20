<!DOCTYPE html>
<html>
<head>

    <script>
        // rename myToken as you like
        window.myToken =  <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        console.log(myToken.csrfToken);
    </script>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="css/app.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="app">

    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>

</div>

<script src="/js/app.js"></script>
</body>
</html>