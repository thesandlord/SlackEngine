<?php
/**
* Copyright 2015, Google, Inc.
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*    http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
**/

include "constants.php";

$email = $_GET['mail'];

$out = Array();
$out["ok"] = false;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

	$out["message"] = "Invalid Email";
} else {

	$slackInviteUrl = 'https://'.SUBDOMAIN.'.slack.com/api/users.admin.invite?t='.time();

	// add fileds
	$fields .= "email=".urlencode($email)."&";
	$fields .= "token=".TOKEN."&";
	$fields .= "set_active=true&";
	$fields .= "_attempts=1";

	// open connection
	$ch = curl_init();

	// set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $slackInviteUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 4);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

	// send the request to Slack
	$reply = json_decode(curl_exec($ch), true);
	curl_close($ch);

	// output
	if ($reply['ok'] == false) {
		// error sending invite
		if($reply['error'] == "already_in_team") {
			$out["message"] = "You have already joined this Slack!";
		}
		elseif($reply['error'] == "already_invited") {
			$out["message"] = "Your invite has already been sent!";
		}
		else {
			$out["message"] = "Error Code: ".$reply['error'];
		}
	} else {
		// invitation was sent sucessfully
		$out["message"] = "Invitation sent!";
		$out["ok"] = true;
	}
}

//send JSON response back
echo (json_encode($out, JSON_PRETTY_PRINT));