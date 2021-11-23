<?php
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require_once '../vendor/autoload.php';

class Chat implements MessageComponentInterface {
	protected $clients;
	// protected $users;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
		// $this->users[$conn->resourceId] = $conn;
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
		// unset($this->users[$conn->resourceId]);
	}

	public function onMessage(ConnectionInterface $from,  $data) {
		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;
		switch ($type) {
			case 'chat':
				include '../assets/php/db_connection.php';
				date_default_timezone_set('America/New_York');
				$chat_msg = trim($data->chat_msg);
				$chat_msg = stripslashes($chat_msg);
				$chat_msg = htmlspecialchars($chat_msg);
				$user_id = $data->user_id;
				$timestamp = date('Y-m-d h:i:s');	
				$gid = 1;
				try {
					$insert = $db->prepare("INSERT INTO message (gid, uid, msg, timestamp) values (?, ?, ?, ?)");
					$insert->bindparam(1, $gid);
					$insert->bindparam(2, $user_id);
					$insert->bindparam(3, $chat_msg);
					$insert->bindparam(4, $timestamp);
					$insert->execute();
				}
				catch (Exception $e) {
					
				}
				
				$select = $db->prepare("SELECT * FROM users WHERE uid=?");
				$select->bindparam(1, $user_id);
				$select->execute();
				$result = $select->fetch(PDO::FETCH_ASSOC);
				if (empty($result['displayname'])) {
					$response_from = "<div class='user-message-container my-msg'><h1 class='message-username'>".$result['username']." <span class='tag-line'>#".$result['uid']."</span></h1><p class='user-message'>".$chat_msg."</p></div>";
					$response_to = "<div class='user-message-container'><h1 class='message-username'>".$result['username']." <span class='tag-line'>#".$result['uid']."</span></h1><p class='user-message'>".$chat_msg."</p></div>";
				}
				else {
					$response_from = "<div class='user-message-container my-msg'><h1 class='message-username'>".$result['displayname']." <span class='tag-line'>#".$result['uid']."</span></h1><p class='user-message'>".$chat_msg."</p></div>";
					$response_to = "<div class='user-message-container'><h1 class='message-username'>".$result['displayname']." <span class='tag-line'>#".$result['uid']."</span></h1><p class='user-message'>".$chat_msg."</p></div>";
				}
			
				// Output
				$from->send(json_encode([
					"type"=>$type,"msg"=>$response_from
				]));
				foreach($this->clients as $client) {
					if($from!=$client) {
						$client->send(json_encode([
							"type"=>$type,"msg"=>$response_to
						]));
					}
				}
				break;
			/*case 'enter':
				$user_id = $data->user_id;
				$response_from = "<div class='user-join-chat'>You entered the chat.</div>";
				$response_to = "<div class='user-join-chat'>".$user_id." entered the chat.</div>";
				$from->send(json_encode([
					"type"=>$type,"msg"=>$response_from
				]));
				foreach($this->clients as $client) {
					if($from!=$client) {
						$client->send(json_encode([
							"type"=>$type,"msg"=>$response_to
						]));
					}
				}*/
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}
}
$server = new Ratchet\App('198.71.49.185', 8080, '0.0.0.0'); 
$server->route('/', new Chat, ['*']);
$server->run();
?>