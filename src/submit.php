<?php

require_once('./vendor/autoload.php');
require('./app/config/config.php');

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

if ($argc < 3) {
	echo "Not enough arguments\n";
	die();
}

$evaluationId = $argv[1];
$submissionDir = $argv[2];
$submissionMode = 'TEST';

if (!is_numeric($evaluationId)) {
	echo "You must provide an evaluation ID to submit to\n";
	die();
}
if (!is_dir($submissionDir)) {
	echo "Invalid submission dir\n";
	die();
}

$client = new Client();

$logInUrl = 'https://www.udacity.com/api/session';
$submissionUrl = 'https://www.udacity.com/api/nodes/' . $evaluationId . '/evaluation?_method=GET';

// Log in
$client->request('POST', $logInUrl, array('udacity' => json_encode($udacityUser)));

// Build a submission object
$submissionParts = array();

$dirHandle = opendir($submissionDir);
while (($filename = readdir($dirHandle)) !== false) {
	$submissionParts[] = array(
		'model' => 'SubmissionPart',
		'marker' => $filename,
		'content' => file_get_contents($submissionDir . '/' . $filename),
	);
}

closedir($dirHandle);

$submission = array(
	'model' => 'Submission',
	'operation' => $submissionMode,
	'parts' => $submissionParts
);


// Send the submission
$client->request('POST', $submissionUrl, array('submission' => json_encode($submission)));


// Display results
$uncleanResponseJson = $client->getResponse()->getContent();

// The following fixes the weirdness where udacity throws in a few characters before the JSON
$responseJson = substr($uncleanResponseJson, strpos($uncleanResponseJson, '{'));

$responseContent = json_decode($responseJson, true);

echo $responseContent['execution']['_output_attachments']['stderr']['text'];
echo "\n";

echo $responseContent['execution']['_output_attachments']['stdout']['text'];