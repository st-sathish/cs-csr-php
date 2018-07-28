<?php
require '../../vendors/sendgrid-php/sendgrid-php.php';
require_once '../../env.php';

class EmailUtils {

	public static function send_email($from, $to, $subject, $body) {
		$email = new \SendGrid\Mail\Mail();
		$email->addTo($to);
		$email->setFrom($from);
		$email->setSubject($subject);
		$email->addContent("text/html", $body);
		try {
			$sendgrid = new SendGrid(SENDGRID_API_KEY);
    		$response = $sendgrid->send($email);
    		print "Hello" . $response->statusCode();
    		die();
    		//print $response->statusCode() . "\n";
    		//print_r($response->headers());
    		//print $response->body() . "\n";
		} catch (Exception $e) {
    		throw $e;
		}
	}

	public static function send_debt_email($from, $debtors) {
		$response = array();
		if(sizeof($debtors) == 0) {
			$response["error"] = 0;
			$response["message"] = "No Email found";
			return $response;
		}
		$subject = "CSR Debt";
		foreach($debtors as $debtor) {
			$body = "Hello ". $debtor['first_name'] ." ".$debtor['last_name'];
			try {
				EmailUtils::send_email($from, $debtor['email'], $subject, $body);
			} catch(Exception $e) {
				$response["error"][] = $e->getMessage();
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
		//$response["error"] = 0;
		$response["message"] = "Successfully Email Sent";
		return $response;
	}
}