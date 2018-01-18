# SlackEngine

Enable public access to your Slack server!

This is a (partial) clone of [slackin](http://rauchg.com/slackin) for [Google App Engine](https://cloud.google.com/appengine/).

It provides

- A landing page you can point users to fill in their emails and receive an invite
- A free SSL-secured endpoint at `https://<your-project>.appspot.com`!

### Why Google App Engine?

Most Slack inviters require you to run a server 24/7 to work. However, most users will visit the app once and never come back to it!

With App Engine, you can run your Slack inviter with the App Engine free tier and never worry about it again! If your community starts to receive a lot of traffic, App Engine will automatically scale to handle the load as well.

[Slackin](http://rauchg.com/slackin) is my favorite Slack inviter, but won't run on App Engine without using [the Flexible environment](https://cloud.google.com/appengine/docs/flexible/). So SlackEngine was born!

## How to use

### Setup

* Install the [App Engine SDK for PHP](https://cloud.google.com/appengine/docs/standard/php/download) if you don't have it.
* Visit the [Google Developers Console](https://console.developers.google.com/project), and create a new project.
* Visit [reCAPTCHA](https://www.google.com/recaptcha/admin), and register your website.
* Install reCAPTCHA library with [Composer](https://getcomposer.org/)
    * run `composer install`
* Rename `constants.php.example` to `constants.php`
  * Run: `mv constants.php.example constants.php`
* Edit [constants.php](constants.php)
    * Replace `<YOUR-SUBDOMAIN>` with your team's Slack subdomain, e.g., if your Slack is `myteam.slack.com`, your subdomain is `myteam`
    * Replace `<YOUR-API-TOKEN>` with your Slack API token
      * You can find your API token at https://api.slack.com/custom-integrations/legacy-tokens
      * Note that the user you use to generate the token must be an admin.
      * You should create a dedicated @slackin-inviter user (or similar), mark that user an admin, and use a token from that dedicated admin user.
      * Replace `<YOUR-reCAPTCHA-SECRET>` with your reCAPTCHA secret
      * Replace `<YOUR-reCAPTCHA-SITEKEY>` with your reCAPTCHA site key
      * Replace `<YOUR-NOTE>` with a small note you want to display
      * _Optional Performance Improvements_
        * By default, `$GETINFO` is set to 'true', so SlackEngine will query the Slack API to get the following values. However, this can impact performance once your community goes above 5000 users, causing App Engine to run out of memory and crash.
        * There are two choices to fix this:
            * Set `$GETINFO` to 'false' and define the following constants:
                * Replace `<<YOUR-COMMUNITY-IMAGE>` with the URL of a square image representing your community.
                * Replace `<<YOUR-COMMUNITY-NAME>` with the name of your community.
                * Replace `<<YOUR-COMMUNITY-USERCOUNT>>` with the approximate number of users in your community.
            * Edit [app.yaml](app.yaml)
                * Upgrade the `instance_class` from `F1` to [`F2`, `F4`, or `F4_1G`](https://cloud.google.com/appengine/docs/standard/#instance_classes).
                * _Note: This will stop App Engine from crashing, but will increase costs (only F1 instances are eligible for the free tier). It also won't fully solve the performance issues. The first method will be much faster and cheaper_.
* Launch your app:
    * Run `gcloud init` to select your project
    * Run `gcloud app deploy` to deploy to App Engine

### Credits

* The look and feel is heavily inspired by [slackin](http://rauchg.com/slackin)
* The decision to use PHP was inspired by [this gist](https://gist.github.com/Topener/8b08955e13e961d14173)

### License

Licensed under Apache 2.0, see [`LICENSE`](LICENSE) for details.

## Disclaimer

This is not an official Google product.
