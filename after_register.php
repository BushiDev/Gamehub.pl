<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Stron główna</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="manifest.json">

</head>
<body>

    <header>

        <span class="logo">

            Game<span class="logo_color">hub</span>

        </span>

    </header>

    <main class="after_register">

        <h1>Dziękujemy za rejestrację!</h1>

        <span>
            
            Na podany, w trakcie, rejestracji adres e-mail został wysłany link, aktywujący konto<br><br>

            Przekierowanie na stronę logowania za <span id="timer">5</span>...

        </span>

        <script>

            var span = document.querySelector("span#timer");

            var time = 5;

            setInterval(function(){

                if(time < 0){

                    window.location.href = "login.php";

                }else{

                    span.innerHTML = time;
                    time--;

                }

            }, 1000);

        </script>

    </main>
   
</body>
</html>