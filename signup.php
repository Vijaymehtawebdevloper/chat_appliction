<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Chat App - Sign Up</title>
</head>
<body class = "d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form action="app/http/signup.php" method = "POST">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="img/logo.png" alt="" class = "w-25">
                <h3 class="display-4 fs-t text-center">Sign up</h3>
            </div>
            <?php if(isset($_GET['error'])){?>
            <div class="alert alert-danger" role = "alert">
                <?php echo htmlspecialchars($_GET['error']);?>
            </div>
            <?php } 
            if(isset($_GET['name'])){
                $name = $_GET['name'];
            }else $name = '';

            if(isset($_GET['username'])){
                $username = $_GET['username'];
            }else $username = '';

            if(isset($_GET['passwoed'])){
                $passwoed = $_GET['passwoed'];
            }else $passwoed = '';
            ?>
            <div class="mb-3">
                <label  class="form-label">Name</label>
                <input type="text" class="form-control" name = "name" value = "<?=$name?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">User name</label>
                <input type="email" class="form-control" name = "username" value = "<?=$username?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Password</label>
                <input type="password" class="form-control" name = "password" value = "<?=$passwoed?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Image</label>
                <input type="file" class="form-control" name = "img">
            </div>
            <button type = "submit" class = "btn btn-primary">Sign up</button>
            <a href="index.php">Login</a>
        </form>
    </div>
    <script src="script/bootstrap.js"></script>
</body>
</html>