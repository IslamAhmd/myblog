<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    
    <h1>Hi Admin</h1>
    <p>You Have New Message from {{ $name }}</p>
    <p>Email : {{ $email }}</p>
    <p>Subject : {{ $subject }}</p>   
    <hr>
    <p>The Message is : {{ $body }}</p>

</body>
</html>