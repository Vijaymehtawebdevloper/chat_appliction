<?php
    session_start();
    if(!isset($_SESSION['username'])){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <title>Chat App - Login</title>
        </head>
        <body class = "d-flex justify-content-center align-items-center vh-100">
            <div class="w-400 p-5 shadow rounded">
                <form action="app/http/auth.php" method = "POST">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <img src="img/logo.png" alt="" class = "w-25">
                        <h3 class="display-4 fs-t text-center">LOGIN</h3>
                    </div>
                    <?php if(isset($_GET['error'])){
                        ?>
                            <div class = "alert alert-danger" role = "alert"><?php echo htmlspecialchars($_GET['error'])?></div>
                        <?php
                            }
                    ?>
                    <?php if(isset($_GET['success'])){
                        ?>
                            <div class = "alert alert-success" role = "alert"><?php echo htmlspecialchars($_GET['success'])?></div>
                        <?php
                            }
                    ?>

                    <div class="mb-3">
                        <label  class="form-label">User name</label>
                        <input type="email" class="form-control" name = "username">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">User name</label>
                        <input type="password" class="form-control" name = "password">
                    </div>
                    <button type = "submit" class = "btn btn-primary">Login</button>
                    <a href="signup.php">Sign up</a>
                </form>
            </div>
            <script src="script/bootstrap.js"></script>
        </body>
        </html>
        <?php
    }else{
        header("Location:home.php");
        exit;
    }
?>

