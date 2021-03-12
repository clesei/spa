<?php

$from = 'Kontaktanfrage Soziale Phobie Aachen <info@clesei.de>';

$sendTo = 'Kontaktanfrage Soziale Phobie Aachen <clesei@web.de>';

$subject = 'Neue Nachricht von Soziale Phobie Aachen';

$fields = array('name' => 'Name', 'surname' => 'Surname', 'need' => 'Need', 'email' => 'Email', 'message' => 'Message'); 

$okMessage = 'Nachricht abgesendet! Wir melden uns baldmöglich bei dir. PS: Prüf auch deinen SPAM-Eingang';

$errorMessage = 'Ups da ist etwas schief gelaufen. Versuche es später erneut.';

/
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "Folgende Nachricht ist über die Homepage soziale Phobie eingelaufen:";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
