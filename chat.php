<?php
    session_start();
    if(isset($_SESSION['username'])){
        include "app/db_connection.php";
        include "app/helpers/user.php";
        include "app/helpers/chat.php";
        include "app/helpers/timeAgo.php";
        include "app/helpers/opened.php";

        if(!isset($_GET['user'])){
            header("Location: home.php");
            exit;
        };
        $chatWith = getUser($_GET['user'], $conn);
        if(empty($chatWith)){
            header("Location: home.php");
            exit;
        };

        $chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);
        opened($chatWith['user_id'], $conn, $chats);

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
                <div class="w-400 shadow p-4 rounded">
                    <a href="home.php" class="fs-4 link-dark">&#8592</a>
                    <div class="d-flex align-items-center" title = "online">
                        <img src="uploads/<?=$chatWith['image']?>" alt="" class="w-15 rounded-circle">
                        <h3 class="display-4 fs-ms- m-2">
                            <?=$chatWith['name']?>
                            <div class="d-flex align-items-center" title = "online">
                                <?php
                                    if(last_seen($chatWith['last_seen'])=="Active"){
                                        ?>
                                            <div class="online"></div>
                                            <small class="d-block p-1">online</small>
                                        <?php
                                    }else{
                                        ?>
                                            <small class="d-block p-1">
                                                Last seen :
                                                <?=last_seen($chatWith['last_seen'])?>
                                            </small>
                                        <?php
                                    }
                                ?>
                            </div>
                        </h3>
                    </div>

                    <div class="d-flex shadow flex-column p-4 rounded mt-2 chat-box" id ="chatBox">
                        <?php
                            if(!empty($chats)){
                                foreach($chats as $chat){
                                    if($chat['from_id'] == $_SESSION['user_id']){
                                        ?>
                                            <p class="rtext align-self-end border rounded p-2 mb-1">
                                                <?=$chat['message']?>
                                                <small class="d-block">
                                                    <?=$chat['created_at']?>
                                                </small>
                                            </p>
                                        <?php
                                    }else{
                                        ?>
                                            <p class="ltext border rounded p-2 mb-1">
                                                <?=$chat['message']?>
                                                <small class="d-block">
                                                    <?= $chat['created_at']?>
                                                </small>
                                            </p>
                                        <?php
                                    }
                                }
                            }else{
                                ?>
                                    <div class="alert alert-info text-center">
                                        <i class="fa fa-comments d-block fs-big"></i>
                                        No message yet, Start the conversation.
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="input-group mb-3">
                        <textarea name="" id="message" cols="3"  class="form-control"></textarea>
                        <button class="btn btn-primary" id="sendBtn">
                            <i class="fa fa-paper-plane">send</i>
                        </button>
                    </div>
                </div>
                <script src="script/bootstrap.js"></script>
                <script src="script/jquery-3.6.0.min.js"></script>
                <script>
                    let scrollDown = function(){
                        let chatBox = document.getElementById('chatBox');
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }

                    scrollDown();

                    $(document).ready(function(){
                        $("#sendBtn").on("click", function(){
                            message = $("#message").val();
                            if(message == "")return;

                            $.post("app/ajax/insert.php",
                                {
                                    message : message,
                                    to_id :<?=$chatWith['user_id']?>
                                },
                                function(data, status){
                                    $("#message").val("");
                                    $("#chatBox").append(data);
                                    scrollDown();
                                })
                        });
                        let lastSeenUpdate = function(){
                            $.get("app/ajax/update_last_seen.php");
                        }

                        lastSeenUpdate();
                        setInterval(lastSeenUpdate, 10000);
                        let fetchData = function(){
                            $.post("app/ajax/getMessage.php",
                            {
                                id_2: <?=$chatWith['user_id']?>
                            },
                            function(data, status){
                                $("#chatBox").append(data);
                                if(data != "")scrollDown();
                            });
                        }
                        fetchData();
                        setInterval(fetchData, 500);
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