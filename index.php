<?php
    $firstname = $name = $email = $phone = $message ="";
    $firstnameError = $nameError = $emailError = $phoneError = $messageError ="";
    $isSuccess = false;
    $emailTo = "ss.guiheux@orange.fr";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $firstname = verifyInput($_POST["firstname"]);
        $name = verifyInput($_POST["name"]);
        $email = verifyInput($_POST["email"]);
        $phone = verifyInput($_POST["phone"]);
        $message = verifyInput($_POST["message"]);
        $isSuccess = true;
        $emailText = "";

        if(empty($firstname))
        {
            $firstnameError = "Je veux connaitre votre prénom!";
            $isSuccess = false;
        }
        else{
            $emailText .= "Firstname: $firstname\n";}

        if(empty($name))
        {
            $nameError = "Je veux aussi connaitre votre nom!";
            $isSuccess = false;
        }
        else{
            $emailText .= "Name: $name\n";}

        if(empty($message))
        {
            $messageError = "Dans l'attente de vous lire...";
            $isSuccess = false;
        } 
        else{
            $emailText .= "Message: $message\n";}

        if(!isEmail($email))
        {
            $emailError = "Cet email n'est pas valide";
            $isSuccess = false;
        }
        else{
            $emailText .= "Email: $email\n";}

        if(!isPhone($phone))
        {
            $phoneError = "Chiffres et espaces uniquement svp";
            $isSuccess = false;
        }
        else{
            $emailText .= "Phone: $phone\n";}

        if($isSuccess)
        {
            $headers = "From: $firstname $name <$email>\r\nReply-To: $email";
            mail($emailTo, "Message siteweb" , $emailText , $headers);
            $firstname = $name = $email = $phone = $message ="";
        }
    }


    function isPhone($var)
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }


    function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script   src="https://code.jquery.com/jquery-3.6.0.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
<link  href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="divider"></div>
        <div class="heading">
            <h2>Contactez-moi</h2>
        </div>
        <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
            <div class="row">
                <div class="col-lg-6">
                    <label for="firstname" class="form-label">Prénom <span class="blue">*</span></label>
                    <input id="firstname" type="text" name="firstname" class="form-control" placeholder="Votre Prénom" value="<?php echo $firstname; ?>">
                    <p class="comments"><?php echo $firstnameError; ?></p>
                </div>
                <div class="col-lg-6">
                    <label for="name" class="form-label">Nom <span class="blue">*</span></label>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Votre Nom" value="<?php echo $name; ?>">
                    <p class="comments"><?php echo $nameError; ?></p>
                </div>
                <div class="col-lg-6">
                    <label for="email" class="form-label">Email <span class="blue">*</span></label>
                    <input id="email" type="email" name="email" class="form-control" placeholder="Votre Email"value="<?php echo $email; ?>">
                    <p class="comments"><?php echo $emailError; ?></p>
                </div>
                <div class="col-lg-6">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input id="phone" type="phone" name="phone" class="form-control" placeholder="Votre Téléphone" value="<?php echo $phone; ?>">
                    <p class="comments"><?php echo $phoneError; ?></p>
                </div>
                <div>
                    <label for="message" class="form-label">Message <span class="blue">*</span></label>
                    <textarea id="message" name="message" class="form-control" placeholder="Votre Message" rows="4"><?php echo $message; ?></textarea>
                    <p class="comments"><?php echo $messageError; ?></p>
                </div>
                <div>
                    <p class="blue"><strong>* Ces informations sont requises.</strong></p>
                </div>
                <div>
                    <input type="submit" class="button1" value="Envoyer">
                </div>
            </div>
            <p class="thank-you" style="display:<?php if($isSuccess) echo 'block'; else echo'none';?>">Votre message a bien été envoyé. Merci de m'avoir contacté.</p>
        </form>
    </div>
</body>

</html>
