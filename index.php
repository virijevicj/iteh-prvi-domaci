<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <title>KKfon login</title>

</head>
<body>
   <div class="box">
    <div class="container">

        <div class="top">
            <header><b>Dobrodosli!</b></header>
        </div>

        <div class="input-field">
            <input type="text" class="input" placeholder="vas email" id="email">
            <i class='bx bx-user' ></i>
        </div>

        <div class="input-field">
            <input type="Password" class="input" placeholder="vasa lozinka" id="lozinka">
            <i class='bx bx-lock-alt'></i>
        </div>

        <div class="input-field">
            <input type="submit" class="submit" value="Login" onclick = login()>
        </div>
    </div>
</div>  

<script src="js/login.js"></script>
</body>
</html>