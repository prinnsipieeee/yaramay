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
if(isset($_POST['ph_handler_name']) && is_array($_POST['ph_handler_name'])){
    $phName = $_POST['ph_handler_name'];
    $phPerson = $_POST['ph_handler_person'] ?? [];
    $phNumber = $_POST['ph_handler_number'] ?? [];

    $count = 1;
    foreach ($phName as $index => $nameValue) {
        if(trim($nameValue) !== '') {
            $phHandlers[$count] = [
                'agency' => trim($nameValue),
                'person' => trim($phPerson[$index] ?? ''),
                'number' => trim($phNumber[$index] ?? '')
            ];
            $count++;
        }
    }
}

$foreignHandlers = [];
if(isset($_POST['fr_handler_name']) && is_array($_POST['fr_handler_name'])){
    $frNames = $_POST['fr_handler_name'];
    $frPerson = $_POST['fr_handler_name'] ?? [];
    $frNumber = $_POST['fr_handler_number'] ?? [];

    $count = 1; 
    foreach($frNames as $index => $nameValue){
        if(trim($nameValue) !== ''){
            $foreignHandlers[$count] = [
                'agency' => trim($nameValue),
                'person' => trim($phPerson[$index] ?? ''),
                'number' => trim($phNumber[$index] ?? '')
            ];
            $count++;
        }
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

$body .= "AGENCY HANDLERS IN THE PHILIPPINES\r\n";
$body .= str_repeat('-', 50) . "\r\n";

if (!empty($phHandlers)) {
    foreach ($phHandlers as $num => $data) {
        $agencyText = $data['agency'] !== '' ? $data['agency'] : '(none)';
        $personText = $data['person'] !== '' ? $data['person'] : '(none)';
        $numberText = $data['number'] !== '' ? $data['number'] : '(none)';

        $body .= "{$num}.\r\n";
        $body .= "   Agency Name:    {$agencyText}\r\n";
        $body .= "   Contact Person: {$personText}\r\n";
        $body .= "   Contact Number: {$numberText}\r\n";
    }
} else {
    $body .= "(none provided)\r\n";
}
$body .= "\r\n";

$body .= "FOREIGN RECRUITMENT / MANPOWER HANDLERS\r\n";
$body .= str_repeat('-', 50) . "\r\n";

if (!empty($foreignHandlers)) {
    foreach ($foreignHandlers as $num => $data) {
        $agencyText = $data['agency'] !== '' ? $data['agency'] : '(none)';
        $personText = $data['person'] !== '' ? $data['person'] : '(none)';
        $numberText = $data['number'] !== '' ? $data['number'] : '(none)';

        $body .= "{$num}.\r\n";
        $body .= "   Agency Name:    {$agencyText}\r\n";
        $body .= "   Contact Person: {$personText}\r\n";
        $body .= "   Contact Number: {$numberText}\r\n";
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

//TESTING OF CODE
echo "<pre>";
echo "To: " . $recipients . "\n";
echo "Subject: " . $subject . "\n";
echo str_repeat('=', 50) . "\n";
echo $body;
echo "</pre>";
exit;


$sent = mail($recipients, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: registration.html?registration=success');
} else {
    header('Location: registration.html?registration=error&reason=send');
}
exit;
