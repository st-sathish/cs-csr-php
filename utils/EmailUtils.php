<?php
require '../../vendor/autoload.php';
require_once '../../env.php';

class EmailUtils {

	private static function send_email($from, $to, $subject, $body) {
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
			$name = $debtor['first_name'] ." ".$debtor['last_name'];
			$debt_amount = $debtor["debtor_balance"];
			$body = "";
			try {
				// EmailUtils::send_email($from, $debtor['email'], $subject, $body);
				EmailUtils::curl_send_email($from, $debtor['email'], $subject, $body, $name, $debt_amount);
			} catch(Exception $e) {
				$response["error"][] = $e->getMessage();
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
		//$response["error"] = 0;
		$response["message"] = "Successfully Email Sent";
		return $response;
	}

	private static function curl_send_email($from, $to, $subject, $body, $name, $debt) {
		$data = array();
		$personalizations = array();
		$personalizations["to"][]["email"] = $to;
		if($subject == '') {
			$subject = "CSR Debt";
		}
		$personalizations["subject"] = $subject;
		$data["personalizations"][] = $personalizations;
		$data['from']["email"] = $from;

		$content = array();
		$c["type"] = "text/html";
		$value = "<p>Hi " .$name. "</br></br></p><p>Thanks for supporting CSR!</p></br></br><p>This is an computer generated email to intimate you that you have an pending payment balance of <strong>Rs." .$debt. " </strong>to be paid to CSR. We will really appreciate you if you could close that at the earliest.</p></br></br><p>If you do not have any debts and still you are receiving this email, then please contact Abey George.</p></br></br></br></br>Thanks!";
		$c["value"] = $value;

		array_push($content, $c);
		$data["content"] = $content;

		// convert into json
		$data = json_encode($data, JSON_UNESCAPED_SLASHES);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.sendgrid.com/v3/mail/send");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','authorization: Bearer '. SENDGRID_API_KEY));
		try {
			$server_output = curl_exec ($ch);
		} catch(Exception $e) {
			// throw $e;
		} finally {
			curl_close ($ch);
		}
	}
}