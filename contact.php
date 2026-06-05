<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#contact');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    header('Location: index.html?contact=error&reason=missing#contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?contact=error&reason=email#contact');
    exit;
}

$recipients = 'renier.trenuela@gmail.com, Sab_princes@yahoo.com';
$subject = 'YARAMAY Contact Form: ' . $name;

$body = "New contact message from the YARAMAY website\r\n";
$body .= str_repeat('=', 50) . "\r\n\r\n";
$body .= "Name:    {$name}\r\n";
$body .= "Email:   {$email}\r\n\r\n";
$body .= "Message:\r\n";
$body .= str_repeat('-', 50) . "\r\n";
$body .= wordwrap($message, 70) . "\r\n\r\n";
$body .= str_repeat('=', 50) . "\r\n";
$body .= 'Submitted: ' . date('F j, Y \a\t g:i A T') . "\r\n";

$fromAddress = 'yaramayservices@gmail.com';
$headers = [
    'From: YARAMAY Website <' . $fromAddress . '>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8',
];

$sent = mail($recipients, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: index.html?contact=success#contact');
} else {
    header('Location: index.html?contact=error&reason=send#contact');
}
exit;
