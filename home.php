<?php 
    session_start();
    if (isset($_SESSION['uid'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/global-styles.css">
    <link rel="stylesheet" href="/assets/css/home-styles.css">
    <link rel="stylesheet" href="/assets/css/nav-bar-styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/cecb91c862.js" crossorigin="anonymous"></script>
    <title>Home | Messenger</title>
</head>
<body>
    <main>
        <div class="main-container">
        <?php 
            include './assets/php/nav_bar.php'; 
        ?>
            <div class="container-1">
                <h1 class="title-1">Groups</h1>
                <ul class="group-list">
                    <?php 
                        include './assets/php/load_groups.php';
                    ?>
                </ul>
            </div>
            <div class="container-2">
                <h1 class="title-2">Chat</h1>
                <div class="chat-box" id="chat-box">
                    <!-- <div class="user-message-container">
                        <h1 class="message-username">Username</h1>
                        <p class="user-message">Hello!</p>
                    </div> -->
                    <?php 
                        include './assets/php/load_chat.php';
                    ?>
                </div>
                <div class="input-container">
                    <textarea id="chat-area" name="chat-area" placeholder="Enter Message"></textarea>
                    <div class="send-container">
                        <i class="fas fa-paper-plane fa-2x"></i>
                    </div>
                </div>  
            </div>
            <div class="container-3">
                <h1 class="title-3">Members</h1>
                <ul class="member-list">
                    <?php
                        include './assets/php/load_members.php';
                    ?>                
                </ul>
            </div>
        </div>
    </main>
    <script type="text/javascript">
		jQuery(function($){
			// Websocket
			var websocket_server = new WebSocket("ws://198.71.49.185/ws");
			websocket_server.onopen = function(e) {
				websocket_server.send(
					JSON.stringify({
						'type': 'enter',
						//'user_id': <?=$_SESSION['username']?>,
					})
				);
			};
        
			websocket_server.onerror = function(e) {
				// Errorhandling
			}
            
			websocket_server.onmessage = function(e) {
                const isScrolledToBottom = chat.scrollHeight - chat.clientHeight <= chat.scrollTop + 1
				var json = JSON.parse(e.data);
				switch(json.type) {
					case 'chat':
						$('#chat-box').append(json.msg);
						break;
                    //case 'enter':
                        //$('#chat-box').append(json.msg);
                        //break;
				}
                if (isScrolledToBottom) {
                    chat.scrollTop = chat.scrollHeight - chat.clientHeight
                }
			}

			// Events
			$('#chat-area').on('keyup',function(e){
				if(e.keyCode==13 && !e.shiftKey) {
					var chat_msg = $(this).val();
					websocket_server.send(
						JSON.stringify({
							'type': 'chat',
							'user_id': '<?php echo $_SESSION['uid'];?>',
							'chat_msg': chat_msg
						})
					);
					$(this).val('');
                    chat.scrollTop = chat.scrollHeight; // scrolls to bottom of chat if the user sends a message
				}
			});
            $('.send-container').click(function(e){
                var chat_msg = $('#chat-area').val();
                websocket_server.send(
				    JSON.stringify({
						'type': 'chat',
						'user_id': '<?php echo $_SESSION['uid'];?>',
						'chat_msg': chat_msg
					})
				);
				$('#chat-area').val('');
                chat.scrollTop = chat.scrollHeight; // scrolls to bottom of chat if the user sends a message
            });
            
		});
        const chat = document.getElementById("chat-box");
        chat.scrollTop = chat.scrollHeight;

	</script>
    <script src="/assets/js/nav-bar-script.js"></script>
    <script src="/assets/js/logout-script.js"></script>
</body>
</html>
<?php
    }
    else {
        header("Location: /index.php");
        exit();
    }
?>