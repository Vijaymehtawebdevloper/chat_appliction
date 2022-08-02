<?php
    session_start();

    // check if username and password submited
    if(isset($_POST['username']) && isset($_POST['password'])){
        include "../db_connection.php";

        // get data from POST request and store them in variable
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo $username;

        // form validation
        if(empty($username)){
            // error massege
            $em = "username is required";

            // redirect to index/php and passing error message
            header("Location: ../../index.php?error=$em");
            exit;
        }else if(empty($password)){
            // error massege
            $em = "Password is required";


            // redirect to index/php and passing error message
            header("Location: ../../index.php?error=$em");
            exit;
        }else{
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username,]);
            

            // if the user is exit
            if($stmt->rowCount() === 1){
                // fetching user data 
                
                $user = $stmt->fetch();
                echo ($user);

                // if both username are strictly equal
                if($user['username']===$username){


                    // varifying the encrypted password
                    if(password_verify($password, $user['password'])){

                        // successfully loggedin 
                        // create the SESSION
                        $_SESSION['username'] = $user['username'];
                        echo $_SESSION['username'];
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['user_id'] = $user['user_id'];

                        // redirect the home.php
                        header('Location: ../../home.php');
                    }else{
                        // error message
                        $em = "Incorect username and password";

                        // redirect the index.php and passing error message
                        header("Location: ../../index.php?error=$em");
                    }
                }else{
                    $em = "Incorect username and password";
                    header("Location: ../../index.php?error=$em");
                }
            }
        }
    }else{
        header ("Location:../../index.php");
        exit;
    }
?>