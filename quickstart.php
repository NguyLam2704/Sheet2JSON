<?php
require_once 'vendor/autoload.php';
function getClient(){
$client = new \Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes(Google\Service\Sheets::SPREADSHEETS);
$client->setAccessType('offline');
// credentials.json is the key file we downloaded while setting up our Google Sheets API
$path = 'credentials.json';
$client->setAuthConfig($path);
$client->setPrompt('select account consent');
$token = 'token.json';
if(file_exists($token))
{
    $accessToken = json_decode(file_get_contents($token), true);
    $client->setAccessToken($accessToken);
}

// configure the Sheets Service
$service = new Google\Service\Sheets($client);

$spreadsheetId = '1K098feJe1CPI5XwXV1iOvw4PG66pXUZs3Pwtckwh0Rc';
$spreadsheet = $service->spreadsheets->get($spreadsheetId);
// var_dump($spreadsheet);
$range = 'Sheet1'; // here we use the name of the Sheet to get all the rows
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$rows = $response->getValues();
// var_dump($values);
$headers = array_shift($rows);
// // Combine the headers with each following row
$array = [];
foreach ($rows as $row) {
    $array[] = array_combine($headers, $row);
}
$jsonString = json_encode($array, JSON_PRETTY_PRINT);
return $jsonString;
}
print(getClient());

?>