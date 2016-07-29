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

$slackUrl = 'https://'.SUBDOMAIN.'.slack.com/api/rtm.start?simple_latest=true&no_unreads=true&token='.TOKEN;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $slackUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$reply = json_decode(curl_exec($ch), true);
curl_close($ch);

// Set defaults
$active = 0;
$total = 0;
$name = SUBDOMAIN;
$img = "";

// Get team data from slack
if($reply['ok']){

  $img = $reply['team']['icon']['image_68'];
  $name = $reply['team']['name'];

  foreach($reply['users'] as $val) {

    $total = $total + 1;
    if('active' == $val['presence']) {
      $active = $active + 1;
    }  
  }
}
?>
<html>
  <head>
    <title>Join <?php echo $name; ?> on Slack!</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <link rel="shortcut icon" href="https://slack.global.ssl.fastly.net/272a/img/icons/favicon-32.png">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
    <div style="text-align: center; margin-top: 75px">

      <div style="margin-bottom: 40px;">
        <img src="<?php echo $img; ?>" class="logo" />
        <span class="plus">+</span>
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/76/Slack_Icon.png" class="logo" />
      </div>

      <div style="margin:5px;">Join <b><?php echo $name; ?></b> on Slack.</div>

      <div style="margin:5px;"> <b style="color: #E01563;"><?php echo $active;?></b> users online now of <b><?php echo $total; ?></b> registered.</div>

      <form class="form" id="user_info" action="signup.php" method="POST">
        <input type="email" class="form-item" placeholder="you@yourdomain.com" autofocus="true" name="email">
        <button class="button form-item" id='button' type="submit"> Get my Invite </button>
        <p class="muted"> <a href="https://<?php echo $name; ?>.slack.com">Already have an account? Click here to go to Slack.<a> </p>
        <div class="g-recaptcha" data-sitekey="<?php echo SITEKEY; ?>"></div>
        <p class="muted note"> <b>Note:</b> <?php echo NOTE; ?></p>
      </form>
    </div>

    <script>
      $('#user_info').submit(function(e) {
        e.preventDefault();
        var button = document.getElementById('button');
        button.style.background = "#D6D6D6";
        button.innerHTML = "Please Wait...";
        $this = $(this);
        $.ajax({
          type: "POST",
          url: "signup.php",
          data: $this.serialize()
        }).done(function(response) {
          response = JSON.parse(response);
          if(response.ok)
            button.style.background = "#68C200";
          else
            button.style.background = "#F4001E";
          button.innerHTML = response.message;
        }).fail(function( jqXHR, textStatus ) {
          button.style.background = "#F4001E";
          button.innerHTML = "Backend Failure"
        });
      });    
    </script>

  </body>
  <footer><a href="https://github.com/thesandlord/SlackEngine">SlackEngine</a>, powered by <a href="https://cloud.google.com/appengine/" target="_blank">App Engine</a></footer>
</html>
