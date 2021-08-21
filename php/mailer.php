<?php
//To limit the maximum execution time use. If set $seconds to zero, no time limit is imposed
set_time_limit(0);
//But if user's browser disconnects due to browser timeout your script could be halted, so you need to add
ignore_user_abort(true);
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error). info@doctorcare247.com
 */
//$mailTo     = 'info@doctorcare247.com', info@wellspringtechnologiesng.com, ibrahimadedayo@outlook.com; doctorcare247@outlook.com, tulbadex@gmail.com
$mailTo     = 'info@wellspringtechnologiesng.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfuly!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm.. seems there is a problem, sorry!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */



if (isset($_POST['to']) || !empty($_POST['to'])) {
  //Load Composer's autoloader
  require '../vendor/autoload.php';
  $output = '';

  //To address and name
  $address = explode(',', $_POST['to']);
  $count = 1;

  foreach ($address as $key) {
    $mail = new PHPMailer; 
    //Server settings
    //$mail->SMTPDebug = 2;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();                  // Set mailer to use SMTP
    $mail->CharSet = 'UTF-8';
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers, smtp-mail.outlook.com, smtpout.secureserver.net, smtp.gmail.com, smtp.live.com, smtp.sendgrid.net
    $mail->SMTPAuth = true;       // Enable SMTP authentication
    $mail->Username = 'tulbadex@gmail.com';  // SMTP username, info@wellspringtechnologiesng.com, ibrahimadedayo@outlook.com, tulbadex@gmail.com, ibrahim.bsmc671@iiu.edu.pk, Sanzyen82, gregg@bileasterly.net
    $mail->Password = 'babatunde12345';  // SMTP password,Melville004, babatunde12345,Babatunde@123@@, Sandyzee832, makemoney101
    $mail->SMTPSecure = 'tls';      // Enable TLS encryption, `ssl`,tls also accepted
    $mail->Port = 587;    //80, 587

    $mail->setFrom($mailTo, $_POST['companyName']);
    $replyName = ($_POST['replyName']) ? $_POST['replyName'] : $_POST['companyName'];
    $mail->addReplyTo($_POST['reply'], $replyName);
    $mail->addAddress($key, $key); //Adds a "To" address

    //To address and name
    $addBcc  = explode(',', $_POST['bcc']);
    $addCcc  = explode(',', $_POST['cc']);

    $imageUploaded = [];
    $logoUploaded  = '';
    if (count($_FILES['upload']['name']) > 0) {
      for ($i=0; $i < count($_FILES['upload']['name']); $i++) { 
        $file_name   = $_FILES['upload']['name'][$i];
        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
        $file_size   = $_FILES['upload']['size'][$i];
        if ($file_name != "") {
          if ($file_size > 5000000) {
            $json_arr = array( "type" => "error", "msg" => "File size can not be more than 5MB!" );
            echo json_encode( $json_arr );
            exit(); 
          }else{
            $ext    = explode('.', basename($_FILES['upload']['name'][$i]));
            $file_ext = end($ext);
            $save_name= md5(uniqid()).".".$ext[count($ext) - 1];

            $shortname = $_FILES['upload']['name'][$i];
            $filepath  = "../uploads/".$save_name;

            if (move_uploaded_file($tmpFilePath, $filepath)) {
              $imageUploaded[] = $save_name;
            }
          }
        }else{
          $imageUploaded[] = '';
        }
      }
    }

    if ($_POST['bcc'] != "") {
      foreach ($addBcc as $key) {
        $mail->addBCC($key);
      }
    }

    if ($_POST['cc'] != "") {
      foreach ($addCcc as $key) {
        $mail->addCC($key);
      }
    }

    //Send HTML or Plain Text email
    $mail->isHTML(true);


    $mail->Subject  = $_POST['subject'];
    $msg  = $_POST['message'];
    $mail->Body   = $msg;
    //$mail->Body   = "Message";

    if($imageUploaded !== ''){
      foreach ($imageUploaded as $images) {
        $mail->addAttachment("../uploads/".$images);
      }
    }

    $mail->AltBody = '';

    $result = $mail->Send();      //Send an Email. Return true on success or false on error

    if($result["code"] == '400')
    {
     $output .= html_entity_decode($result['full_error']);
     $json_arr = array( "type" => "success", "msg" => "Email sent success!" );
     echo json_encode( $json_arr );
    }

    $count++;
    /*if ($count >= 2) {
      sleep(180);
    }*/
    sleep(1);

  }//end of foreach

  if($output == ''){
    echo 'ok';
    foreach ($imageUploaded as $images) {
      if($images !== ""){
        unlink("../uploads/".$images);
        unlink("../uploads/thumbs/".$images);
      }
    }
    $mail->clearAddresses();
    $mail->clearAttachments();
    exit();
  }else{
    foreach ($imageUploaded as $images) {
      if($images !== ""){
        unlink("../uploads/".$images);
        unlink("../uploads/thumbs/".$images);
      }
    }
    exit();
  }
}

?>