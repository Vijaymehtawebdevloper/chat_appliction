<?php
    session_start();
    if(isset($_SESSION['username'])){
        include "app/db_connection.php";
        include "app/helpers/user.php";
        include "app/helpers/conversation.php";
        include "app/helpers/timeAgo.php";
        include "app/helpers/last_chat.php";

        $user = getUser($_SESSION['username'], $conn);
        $conversation = getConversation($user['user_id'], $conn);
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
            <body class = "d-flex justify-content-center align-atems-center vh-100">
                <div class="p-2 w-100 rounded shadow">
                    <div>
                        <div class="d-flex justify-content-center align-items-center mb-3 p-3 bg-light">
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?=$user['image']?>" alt="" class="w-25 rounded-circle">
                                <h3 class="fs-xs m-2"><?=$user['name']?></h3>
                            </div>
                            <a href="logout.php" class="btn btn-dark">Logout</a>
                        </div>
                        <div class="input-group mb-3">
                            <input type="search" placehollder = "searce..." id ="searchText" class = "form-controll">
                            <button class="btn btn-primary" id="searchBtn">Search</button>
                        </div>
                        <ul id="chatList" class = "list-group mvh-50 overflow-auto">
                            <?php 
                                if (!empty($conversation)){?>
                                    <?php
                                    foreach($conversation as $conversations)
                                        {
                                            ?>
                                            <li class="list-group-item">
                                                <a href="chat.php?user=<?=$conversations['username']?>" class = "d-flex justify-content-between align-items-center p-2">
                                                    <div class="d-flex align-items-center">
                                                        <img src="uploads/<?=$conversations['image']?>" alt="" class="w-10 rounded-circle">
                                                        <h3 class="fs-xs m-2">
                                                            <?=$conversations['name']?><br>
                                                            <small>
                                                                <?php echo lastChat($_SESSION['user_id'], $conversations['user_id'], $conn)?>
                                                            </small>
                                                        </h3>
                                                    </div>
                                                    <?php
                                                        if(last_seen($conversations['last_seen']) == "Active"){
                                                            ?>
                                                                <div title = "online">
                                                                    <div class="online"></div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            <?php
                                }else{
                                    ?>
                                        <div class="alert alert-info text-center">
                                            <i class="fa fa-comments d-block fs-big"></i>
                                            No message yet, start the conversation
                                        </div>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>

                <script src="script/bootstrap.js"></script>
                <script src="script/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function(){
                        $("#searchText").on("input", function(){
                            let searchText = $(this).val();
                            if(searchText == "") return;
                            $.post('app/ajax/search.php',
                            {
                                key: searchText
                            },
                            function(data, status){
                                $("#chatList").html(data);
                            });
                        });

                        $("#searchBtn").on("clilck", function(){
                            let searchText = $("#searchText").val();
                            if(searchText == "") return;
                            $.post('app/ajax/search.php',
                            {
                                key: searchText
                            },
                            function(data, status){
                                $("#chatList").html(data);
                            });
                        });

                        let lastSeenUpdate = function(){
                            $.get("app/ajax/update_last_seen.php");
                        };
                        lastSeenUpdate();

                        setInterval(lastSeenUpdate, 1000);
                    });
                </script>
            </body>
            </html>
        <?php
    }else{
        header("Location: index.php");
        exit;
    }
?>

