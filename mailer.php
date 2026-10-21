<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim(isset($_POST["phone_number"]) ? $_POST["phone_number"] : "");
        $topic = trim(isset($_POST["topics"]) ? $_POST["topics"] : "");
        $message = trim(isset($_POST["message"]) ? $_POST["message"] : "");

        if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Please complete the form with a valid name, email and message.";
            exit;
        }

        $recipient = "adv.sanyamrastogi@gmail.com";
        $subject = "SanNyay Legal enquiry from $name";

        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Matter: $topic\n\n";
        $email_content .= "Message:\n$message\n";

        $email_headers = "From: SanNyay Legal Website <noreply@localhost>\r\n";
        $email_headers .= "Reply-To: $name <$email>";

        if (mail($recipient, $subject, $email_content, $email_headers)) {
            http_response_code(200);
            echo "Thank you. Your enquiry has been sent. We will respond shortly.";
        } else {
            http_response_code(500);
            echo "The message could not be sent from this server. Please email adv.sanyamrastogi@gmail.com or call +91-8881113636.";
        }
    } else {
        http_response_code(403);
        echo "There was a problem with your submission. Please try again.";
    }
?>
