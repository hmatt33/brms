<!doctype html>
<html land="en">
<head>
	<title>Email Multiple Residents</title>
	<meta charset="utf-8">
</head>
<body>
	<div id="container" class="col-sm-12">
		<?php include('header.php'); ?>
		<div id="content">
			<h2>Email Multiple Residents</h2>

			<?php
			//checks if form in residents page submitted
			//gets list of emails selected
			if(isset($_POST['emailSubmit'])) {
				$emails = $_POST['Emails'];
				//if empty no one was selected
				if(empty($emails) or count($emails) == 1) {
					echo '<h2>';
					echo("You didn't select any residents or you only selected one");
					echo '</h2>';
					echo '<br> <h2>';
					echo("If you only selected one, please use the individual email links on the residents page instead");
					echo '</h2>';
				} else {
					//count number of emails selected
					$num = count($emails);
					echo("You selected $num residents: ");
					for($i = 0; $i < $num - 1; $i++) {
						//only loops to n-1 to ensure that a comma is not added to end of last entry
						//turn array of emails into form the mail function takes
						$to = $to . $emails[$i] . ", ";
					}
					//ensures that there are only commas between every email but no comma at the end of the last entry
					$to = $to . $emails[$num - 1];
					//encode the list to be used to pass to url in case of form error
					$eList = urlencode($to);
				}
			}

			//only gets executed if user submits email but there is an error like not filling out a part of the form
			if(isset($_GET['eList'])) {
				//gets the url if the page has to be redisplayed due to error
				$eList =$_GET['eList'];
				//makes sure whats in the url is always encoded
				$eList = urlencode($eList);
			}

			//start session
			session_start();
			//look for users id
			$e = $_SESSION['Email'];

			if(isset($_POST['sendMail'])) {
				//make errors array
				$errors = array();
				//make headers array
				$headers = array();

				//check for to: emails
				if(empty($_POST['To'])) {
					$errors[] = 'You forgot to enter the email you are sending to';
				}

				//check for your email
				//from will by default have value of $e but can be changed by user
				//whatever is in the text field by the time submit is pressed is what is saved here
				if(empty($_POST['From'])) {
					$errors[] = 'You forgot to enter who the email is from';
				} else {
					$from = $_POST['From'];
					$headers['From'] = $from;
				}

				//check for a subject
				if(empty($_POST['Subject'])) {
					$errors[] = 'You forgot to enter a subject';
				} else {
					$subject = $_POST['Subject'];
				}

				//cc is optional, only checks if its not empty
				//doesnt add to errors if blank
				if(!empty($_POST['Cc'])) {
					$cc = $_POST['Cc'];
					$headers['Cc'] = $cc;
				}

				//Bcc is optional
				if(!empty($_POST['Bcc'])) {
					$bcc = $_POST['Bcc'];
					$headers['Bcc'] = $bcc;
				}

				//check for message
				if(empty($_POST['Message'])) {
					$errors[] = 'You forgot to enter a message';
				} else {
					$msg = str_replace("\n.", "\n..", $_POST['Message']);
					$msg = wordwrap($msg, 70, "\r\n");
				}

				//if there are no erros and there is something in the headers array
				//send the email
				if(empty($errors)) {
					mail($to, $subject, $msg, $headers);
				} else { //there is an error
					echo '<p class="error">The following error(s) occurred:<br />';
					//echo each error in the error array
					foreach ($errors as $er) {
						echo " - $er<br />\n";
					}
					echo '</p><p>Please try again.</p>';
				}

			}

			//create the email form
			echo '<form action="email_multiple.php?eList=' . $eList . '" method="post">
			<p><label class="label" for="To">To:</label><input type="text" name="To" size="100" readonly="readonly" value="' . urldecode($eList) . '"></p>
			<br>
			<p><label class="label" for="From">From:</label><input type="email" name="From" size="30" maxlength="60" readonly="readonly" value="' . $e . '"></p>
			<br>
			<p><label class="label" for="Subject">Subject:</label><input type="text" name="Subject" size="30" maxlength="100" value="' . $subject . '"></p>
			<br>
			<p><label class="label" for="Cc">Cc:</label><input type="text" name="Cc" size="30" value="' . $cc . '"></p>
			<br>
			<p><label class="label" for="Bcc">Bcc:</label><input type="text" name="Bcc" size="30" value="' . $bcc . '"></p>
			<br>
			<p><label class="label" for="Message">Message:</label><input type="text" name="Message" size="70" value="' . $msg . '"></p>
			<br><br>
			<p><input id="submit" type="submit" name="sendMail" value="Send Email"></p>
			</form>';

			?>

		</div>
	</div>
</body>
</html>
