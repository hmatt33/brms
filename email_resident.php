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

        if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from buildings.php
          $id = $_GET['id'];
        } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
          $id = $_POST['id'];
        } else { // If no valid ID, stop the script
          echo '<p class="error">This page has been accessed in error.</p>';
          include ('footer.php');
          exit();
        }
        require ('mysqli_connect.php');

			//start session
			session_start();
			$e = $_SESSION['Email'];
			$to = "SELECT Email FROM Residents WHERE ResidentID='$id'";
      $result = mysqli_query($dbcon, $to);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);

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
					mail($row[0], $subject, $msg, $headers);
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
			echo '<form action="email_resident.php" method="post">
			<p><label class="label" for="To">To:</label><input type="text" name="To" size="30" readonly="readonly" value="' . $row[0] . '"></p>
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
      <input type="hidden" name="id" value="' . $id . '" />
			<p><input id="submit" type="submit" name="sendMail" value="Send Email"></p>
			</form>';
      mysqli_close($dbcon);
			?>
      <footer>
        <?php include('footer.html'); ?>
      </footer>
		</div>
	</div>
</body>
</html>
