<?php

function sendRegistrationEmail($recipientEmail, $recipientName) {
    
    $senderEmail = "admin@iilm.ssapvtltd.in";
    $senderName = "IILM Assignment Portal";
    
    $subject = "Welcome to IILM Assignment Portal!";
    
    $message = "
    <html>
    <head>
        <title>Welcome to IILM Assignment Portal</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .email-container {
                background-color: #ffffff;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                width: 600px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .header-image {
                text-align: center;
            }
            .header-image img {
                width: 100%;
                max-width: 600px;
                height: auto;
            }
            .content {
                padding: 20px;
            }
            .content h2 {
                color: #4A90E2;
            }
            .content p {
                font-size: 16px;
                line-height: 1.5;
                color: #333;
            }
            .content .bold {
                font-weight: bold;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
                color: #777;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header-image'>
                <img src='https://iilm.ssapvtltd.in/assignment/studentregister/emailheader.png' alt='IILM Logo'>
            </div>
            <div class='content'>
                <h2>Welcome, $recipientName!</h2>
                <p>Dear <span class='bold'>$recipientName</span>,</p>
                <p>We are excited to have you onboard at the <span class='bold'>IILM Assignment Portal</span> as a Faculty. You can now log in to create assignments, grade assignments, check reports and manage all academic submissions seamlessly.</p>
                <p>Please ensure you keep your login details secure.</p>
                <p>We wish you all the best for your teaching journey!</p>
                <p>Best regards,</p>
                <p><span class='bold'>IILM Assignment Portal Team</span></p>
            </div>
            <div class='footer'>
                <p>&copy; 2024 IILM Assignment Portal. All Rights Reserved.|| Designed With ❤️ By Team SS Animations</p>
                <p>This is an automated message. Please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    
    $headers .= "From: $senderName <$senderEmail>" . "\r\n";
    $headers .= "Reply-To: $senderEmail" . "\r\n";
    $headers .= "Return-Path: $senderEmail" . "\r\n";
    
    if (mail($recipientEmail, $subject, $message, $headers)) {
        return true;
    } else {
        error_log("Email failed to send to: $recipientEmail");
        return false;
    }
}
?>
