<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<h2>Title</h2>

		<ul id="messageList"></ul>

		<form id="chatForm">
			<textarea id="message"></textarea>
			<input type="submit" value="Submit">
		</form>

		<script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
					var conn = new WebSocket('ws://localhost:8080/chat/php');

					var chatform = $("#chatForm");
					var messageInputField = chatform.find("#message");
					var messageList = $("#messageList");

                    chatform.on("submit", function(e) {
						e.preventDefault();
						var message = messageInputField.val();
						conn.send(message);
                        messageList.prepend('<li>' + message + '</li>');
                    });

                    conn.onopen = function(e) {
						console.log("Connection established!");
                    };

                    conn.onmessage = function(e) {
                        messageList.prepend('<li>' + e.data + '</li>');
                    };
                });
            })(jQuery)
		</script>
	</body>
</html>