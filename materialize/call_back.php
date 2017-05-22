<?php
	if (count($_POST) > 0) {
		$name = trim($_POST['name']);
		$tel = trim($_POST['telephone']);
		$name = htmlspecialchars($name);
		$tel = htmlspecialchars($tel);
		if ($name != '' && $tel != '') {
			$to = $_POST['admin_email'];
			$subject = 'Обратный звонок';
			$message = '
				<html>
					<head>
						<title>'.$subject.'</title>
					</head>
					<body>
						<p>Поступила заявка на обратный звонок с сайта.</p>
						<table style="border:1px solid #ececec;">
							<tr style="background-color:#f8f8f8;">
								<td style="padding:10px;background:#ececec;border:1px solid #ececec;"><b>Имя:</b></td>
								<td style="padding:10px;">'.$name.'</td>
							</tr>
							<tr style="background-color:#f8f8f8;">
								<td style="padding:10px;background:#ececec;border:1px solid #ececec;"><b>Телефон:</b></td>
								<td style="padding:10px;">'.$tel.'</td>
							</tr>
						</table>
					</body>
				</html>';
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: Обратный звонок <from@{$_SERVER['SERVER_NAME']}>\r\n";
			mail($to, $subject, $message, $headers);
		}
	}