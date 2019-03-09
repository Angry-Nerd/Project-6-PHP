<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <style>
        .message{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            box-shadow 0 2px 4px -1px black;
            padding: 40px 30px;
            font-size: 20px;
        }
        a{
            display:block;
            padding: 10px 20px;
            width: 100px;
            color: white;
            background: #0dd;
            margin: 20px auto;
            text-decoration: none;
        }
        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="message">
        Please Login First Buddy.
        <a href="index.php" class="text-center">Go to Login</a>
    </div>
</body>
</html>