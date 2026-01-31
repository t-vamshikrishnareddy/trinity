<?php
// Include the PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // If using Composer

// Initialize PHPMailer object
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = nl2br(htmlspecialchars($_POST['message'])); // nl2br to convert new lines to <br> tags

    try {
        // Server settings
        $mail->isSMTP();                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';    // Set the SMTP server
        $mail->SMTPAuth = true;              // Enable SMTP authentication
        $mail->Username = 'gdrbtechnologiesdevelopment@gmail.com'; // SMTP username
        $mail->Password = 'oytriiyhofhpkjqo';   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587;                  // TCP port to connect to

        // Sender and recipient (admin email)
        $mail->setFrom('gdrbtechnologiesdevelopment@gmail.com', 'GDRB Technologies Pvt Ltd.');
        $mail->addAddress('gdrbtechnologiesdevelopment@gmail.com', ''); // Admin email

        // Content (admin email)
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Contact Form Submission';

        // HTML email body with enhanced styles
        $mail->Body = "
        <html>
        <head>
            <style>
                /* Base styles */
                body { font-family: 'Arial', sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
                h2, h4 { font-family: 'Arial', sans-serif; margin: 0; padding: 10px; color: #4e4e4e; }
                p { font-family: 'Arial', sans-serif; font-size: 14px; color: #555; margin: 5px 0; line-height: 1.5; }
                
                /* Container styling */
                .container { 
                    max-width: 650px; 
                    margin: 20px auto; 
                    padding: 20px; 
                    border-radius: 10px; 
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                }

                .container h1{
                text-align: center;
                }

                .form-section {
                 display: flex;
                 align-items: center;
                 justify-content: center;
                }   

                 /* Button Style (if added) */
                .button {
                    text-align: center;
                    margin-top: 20px;
                }

                .button a {
                    display: inline-block;
                    padding: 12px 24px;
                    background-color: #ff6f61;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: bold;
                    transition: background-color 0.3s ease;
                }

                .button a:hover {
                    background-color: #d05c52;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>New Contact Form Submission</h2>
                <div class='form-section' >
                    <h4 class='label'>Name:</h4>
                    <p>$name</p>
                </div>
                <div class='form-section'>
                    <h4 class='label'>Email:</h4>
                    <p>$email</p>
                </div>
                <div class='form-section'>
                    <h4 class='label'>Message:</h4>
                    <p>$message</p>
                </div>
                <div class='button'>
                    <a href='mailto:$email'>Reply to Sender</a>
                </div>
            </div>
        </body>
        </html>";

        // Send the admin email
        $mail->send();

        // Send the confirmation email to the customer
        $mail->clearAddresses(); // Clear the recipient (admin)
        $mail->addAddress($email, $name); // Add the customer's email as recipient
        $mail->Subject = 'Thanks for Contacting Us!';

        // Confirmation email body
        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: 'Arial', sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
                h2 { font-family: 'Arial', sans-serif; color: #4e4e4e; }
                p { font-family: 'Arial', sans-serif; font-size: 14px; color: #555; margin: 5px 0; line-height: 1.5; }
                .form-section {
                 display: flex;
                 align-items: center;
                 justify-content: center;
                }   
            </style>
        </head>
        <body>
            <div style='max-width: 650px; margin: 20px auto; padding: 20px; border-radius: 10px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);'>
                <h2>Thank you for contacting us!</h2>
                <p>Our team will get in touch with you soon.</p>
                                <div class='form-section' >
                <p><strong>Your message:</strong></p>
                <p>$message</p>
                </div>
            </div>
        </body>
        </html>";

        // Send the confirmation email to the customer
        $mail->send();

        // Redirect to contact page with success message
        echo "<script>
        alert('Your message has been sent successfully! You will receive a confirmation email shortly.');
        window.location.href = 'contact.html';
        </script>";

    } catch (Exception $e) {
        // Handle error if email fails to send
        echo "<script>
        alert('Email failed to send. Please try again later.');
        window.location.href = 'contact.html';
        </script>";
    }
}
?>