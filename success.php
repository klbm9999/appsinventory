<?php require 'header.php'; ?>

<?php 

	if (isset($_POST)) {
		require 'scripts/PHPMailer/PHPMailerAutoload.php';



		$file_name_new = "";
		$file_ext = "";

		$c1 = $_POST["c1"];
		$c2 = $_POST["c2"];
		$desc = $_POST["desc"];
		$name = $_POST["name"];
		$country = $_POST["country"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$company = $_POST["company"];
		$industry = $_POST["industry"];
		$r1 = $_POST["r1"];

		if (isset($_FILES)) {
			$file = $_FILES['attachment'];
			$file_name = $file['name'];
			$file_tmp_name = $file['tmp_name'];
			$file_type = $file['type'];
			$file_error = $file['error'];
			$file_size = $file['size'];

			$file_ext = explode('.',$file_name);
			$file_ext = strtolower(end($file_ext));

			$allowed = array('txt','pdf','docx','doc','zip','ppt','pptx','odt','jpg','jpeg','png');

			if(in_array($file_ext, $allowed)) {
				if ($file_error===0) {
					if ($file_size<=2048000000) {
						$file_name_new = uniqid('',true).'.'.$file_ext;
						$file_dest = 'uploads/'.$file_name_new;
						if (move_uploaded_file($file_tmp_name, $file_dest)) {
							// echo "Successfully Uploaded\n";
						}
					}
				}
			}
			// var_dump($_FILES);
		}
		$c="";
		if ($c1!=null) {
			if ($c2!=null) {
				$c = $c1.",".$c2;
			}
			else {
				$c = $c1;
			}
		}
		else {
			if ($c2!=null) {
				$c = "NA";
			}
			else {
				$c = $c2;
			}	
		}

		$bodytext = "<!DOCTYPE html>
		<html>
		<head>
			<title>New Project</title>
		</head>
		<body>
			Project : $c <br>
			Description : $desc <br>
			Name :  $name <br>
			Country : $country <br>
			Email :  $email <br>
			Phone :  $phone <br>
			Company :  $company <br>
			Industry :  $industry <br>
			Hire Type :  $r1 <br>
		</body>
		</html>";

		$email = new PHPMailer();

		$email->isSMTP();                                      // Set mailer to use SMTP
		$email->Host = '';  					  // Specify main and backup SMTP servers
		$email->SMTPAuth = true;                               // Enable SMTP authentication
		$email->Username = '';                   // SMTP username
		$email->Password = '';                   // SMTP password
		$email->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$email->Port = 2525;

		$email->From      = 'admin@appsinventory.com';
		$email->FromName  = 'Admin Apps Inventory';
		$email->Subject   = 'New Project';
		$email->Body      = $bodytext;
		$email->AddAddress( 'helpappsinventory@gmail.com' );
		$email->isHTML(true);

		$file_to_attach = "uploads/".$file_name_new;
		$att_send_name = "Project File".".".$file_ext;
		$email->AddAttachment( $file_to_attach, $att_send_name);

		// echo "hello";

	?>

<br><br><br><br>
<div class="row">
	<div class="col-mdd-10 text-center mx-auto">
		<h1 class="h1-display">Your response has been recorded</h1>
		<h2 class="h2-display">We will get back to you shortly</h2>
	</div>
</div>

<?php require 'footer.php'; ?>
<?php  
		return $email->Send();
	}

else { ?>

<br><br><br><br>
	<div class="row">
		<div class="col-mdd-10 text-center mx-auto">
			<h1 class="h1-display">Please fill the form with correct details</h1>
		</div>
	</div>

<?php require 'footer.php'; ?>
<?php }
 ?>
