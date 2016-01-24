
<?php

// grab recaptcha library
require_once "recaptchalib.php";


?>
<?php
if(isset($_POST['submit'])):
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = 'Sectret key';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        $name = !empty($_POST['name'])?$_POST['name']:'';
        $email = !empty($_POST['email'])?$_POST['email']:'';
        $phone = !empty($_POST['phone'])?$_POST['phone']:'';
        $message = !empty($_POST['message'])?$_POST['message']:'';
        if($responseData->success):
            //contact form submission code
            $to = 'Email Address goes here';
            $subject = 'New contact form have been submitted';
            $htmlContent = "
                <h1>Contact request details</h1>
                <p><b>Name: </b>".$name."</p>
                <p><b>Email: </b>".$email."</p>
                <p><b>Phone: </b>".$phone."</p>
                <p><b>Message: </b>".$message."</p>
            ";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // More headers
            $headers .= 'From:'.$name.' <'.$email.'>' . "\r\n";
            //send email
            @mail($to,$subject,$htmlContent,$headers);

            $succMsg = 'Your contact request have submitted successfully.';
            $name = '';
            $email = '';
            $phone = '';
            $message = '';
        else:
            $errMsg = 'Robot verification failed, please try again.';
        endif;
    else:
        $errMsg = 'Please click on the reCAPTCHA box.';
    endif;
else:
    $errMsg = '';
    $succMsg = '';
    $name = '';
    $email = '';
    $phone = '';
    $message = '';
endif;
?>
    <!-- Form -->
    <div class="col-md-12" id="contacts">

      <h2 class="wow fadeInUp" data-wow-delay="1.5s"><span>~  Contact Us  ~</span></h2>

      <h3 class="wow fadeInUp" data-wow-delay="1s">Enter your details and we will get back to you:</h2>

      <?php if(!empty($errMsg)): ?><div class="errMsg"><?php echo $errMsg; ?></div><?php endif; ?>
        <?php if(!empty($succMsg)): ?><div class="succMsg"><?php echo $succMsg; ?></div><?php endif; ?>




      <form method="POST" id="websiteform">



        <label for="field_name"></label>

        <input class="wow fadeInUp" data-wow-delay="1s" type="text" id="field_name" name="name" value="<?php echo !empty($name)?$name:''; ?>" placeholder="Your full name" required>

        <label for="field_email"></label>
        <input class="wow fadeInUp" data-wow-delay="1s" type="email" id="field_email" name="email" value="<?php echo !empty($email)?$email:''; ?>" placeholder="Your full email" required>
        <label for="field_phone"></label>
        <input class="wow fadeInUp" data-wow-delay="1s" type="text" id="field_phone" name="phone" value="<?php echo !empty($phone)?$phone:''; ?>" placeholder="Your full phone number" required>
        <label for="field_message"></label>
        <textarea class="wow fadeInUp" data-wow-delay="1s" id="field_message" name="message" required placeholder="Brief details of your enquiry"><?php echo !empty($message)?$message:''; ?></textarea>

        <div class="g-recaptcha wow fadeInUp" data-wow-delay="1s" data-sitekey="Keep key hidden"></div>


        <div id="submitForm">
          <input class="wow fadeInUp" data-wow-delay="1s" type="submit" name="submit" value="SUBMIT" id="button">
        </div>
      </form>

    </div>
