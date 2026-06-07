<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registration.html');
    exit;
}

function field(string $key): string
{
    return trim($_POST[$key] ?? '');
}

$fullName = field('full_name');
$contactNumber = field('contact_number');
$email = field('email');
$position = field('position');
$positionOther = field('position_other');
$companyName = field('company_name');
$interested = field('interested_in_system');
$comments = field('comments');

if ($fullName === '' || $contactNumber === '' || $email === '' || $position === '' || $companyName === '' || $interested === '') {
    header('Location: registration.html?registration=error&reason=missing');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: registration.html?registration=error&reason=email');
    exit;
}

$positionLabel = $position;
if ($position === 'other' && $positionOther !== '') {
    $positionLabel = 'Other: ' . $positionOther;
} elseif ($position === 'other') {
    $positionLabel = 'Other';
}

$phHandlers = [];
for ($i = 1; $i <= 5; $i++) {
    $value = field('ph_handler_' . $i);
    if ($value !== '') {
        $phHandlers[$i] = [
        'handler' => $value,
        'person' => field('ph_handler_' . $i . '_person'),
        'number' => field('ph_handler_' . $i . '_number') 
        ];
    }
}

$foreignHandlers = [];
for ($i = 1; $i <= 5; $i++) {
    $value = field('foreign_handler_' . $i);
    if ($value !== '') {
        $foreignHandlers[$i] = [
            'agency' => $value,
            'person' => field('foreign_handler_' . $i . '_person'),
            'number' => field('foreign_handler_' . $i . '_number') 
        ];
    }
}

$recipients = 'renier.trenuela@gmail.com, Sab_princes@yahoo.com';
$subject = 'YARAMAY Registration: ' . $fullName;

$body = "New registration from the YARAMAY website\r\n";
$body .= str_repeat('=', 50) . "\r\n\r\n";

$body .= "PERSONAL INFORMATION\r\n";
$body .= str_repeat('-', 50) . "\r\n";
$body .= "Name / Full Name:              {$fullName}\r\n";
$body .= "Contact Number:                {$contactNumber}\r\n";
$body .= "Email Address:                   {$email}\r\n";
$body .= "Position:                        {$positionLabel}\r\n";
$body .= "Company Name or Individual:    {$companyName}\r\n";
$body .= "Interested in System:            {$interested}\r\n\r\n";

$body .= "AGENCY HANDLERS IN PHILIPPINES\r\n";
$body .= str_repeat('-', 50) . "\r\n";
if ($phHandlers) {
    foreach ($phHandlers as $num => $name) {
        $body .= "{$num}. {$name['handler']}\r\n";
        $body .= " Contact Person: {$name['person']}\r\n";
        $body .= " Contac Number: {$name['number']}\r\n";
    }
} else {
    $body .= "(none provided)\r\n";
}
$body .= "\r\n";

$body .= "FOREIGN RECRUITMENT / MANPOWER HANDLERS\r\n";
$body .= str_repeat('-', 50) . "\r\n";
if ($foreignHandlers) {
    foreach ($foreignHandlers as $num => $name) {
        $body .= "{$num}. {$name['agency']}\r\n";
        $body .= " Contact Person: {$name['person']}\r\n";
        $body .= " Contact Number: {$name['number']}\r\n";
    }
} else {
    $body .= "(none provided)\r\n";
}
$body .= "\r\n";

$body .= "COMMENTS\r\n";
$body .= str_repeat('-', 50) . "\r\n";
$body .= $comments !== '' ? wordwrap($comments, 70) . "\r\n" : "(none provided)\r\n";
$body .= "\r\n";

$body .= str_repeat('=', 50) . "\r\n";
$body .= 'Submitted: ' . date('F j, Y \a\t g:i A T') . "\r\n";

$fromAddress = 'yaramayservices@gmail.com';
$headers = [
    'From: YARAMAY Website <' . $fromAddress . '>',
    'Reply-To: ' . $fullName . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8',
];

$sent = mail($recipients, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: registration.html?registration=success');
} else {
    header('Location: registration.html?registration=error&reason=send');
}
exit;
