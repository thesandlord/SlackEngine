# SlackEngine

Enable public access to your Slack server!

This is a (partial) clone of [slackin](http://rauchg.com/slackin) for [Google App Engine](https://cloud.google.com/appengine/).

It provides

- A landing page you can point users to fill in their emails and receive an invite
- A free https://<your-project>.appspot.com domain name!

### Why App Engine?

Most slack inviters require you to run a server 24/7 to work. However, most users will visit the app once and never come back to it!

With App Engine, you can run your slack inviter with the App Engine free tier and never worry about it again! If your community starts to recieve a lot of traffic, App Engine will automatically scale to handle the load as well.

[Slackin](http://rauchg.com/slackin) is my favorite slack inviter, but won't run on App Engine without using [custom runtimes](https://cloud.google.com/appengine/docs/managed-vms/custom-runtimes). So SlackEngine was born!

## How to use

### Setup

* Install the [App Engine SDK for PHP](https://cloud.google.com/appengine/downloads) if you don't have it.
* Visit the [Google Developers Console](https://console.developers.google.com/project), and create a new project.
* Visit [reCAPTCHA](https://www.google.com/recaptcha/admin), and register your website.
* Install reCAPTCHA library with [Composer](https://getcomposer.org/)
    * run ```composer install```
* Edit [app.yaml](app.yaml)
    * Replace ```<PROJECT-ID>``` with the project ID you just created
* Edit [constants.php](constants.php)
    * Replace ```<YOUR-SUBDOMAIN>``` with your team's slack subdomain (i.e If your slack is myteam.slack.com, your subdomain is 'myteam').
    * Replace ```<YOUR-API-TOKEN>``` with your slack API token
      * You can find your API token at api.slack.com/web
      * Note that the user you use to generate the token must be an admin.
      * You should create a dedicated @slackin-inviter user (or similar), mark that user an admin, and use a token from that dedicated admin user.
      * Replace ```<YOUR-reCAPTCHA-SECRET>``` with your reCAPTCHA secret
      * Replace ```<YOUR-reCAPTCHA-SITEKEY>``` with your reCAPTCHA site key
      * Replace ```<YOUR-NOTE>``` with a small note you want to display
* Launch your app:
    * Run ```appcfg.py update app.yaml .```

### Credits

* The look and feel is heavily inspired by [slackin](http://rauchg.com/slackin)
* The decision to use PHP was inspired by [this gist](https://gist.github.com/Topener/8b08955e13e961d14173)

### License

All code is licenced under Apache v2

Note: This is not an official Google product.