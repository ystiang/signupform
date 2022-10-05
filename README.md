# signupform
An interactive signup form developed with PHP Laravel

## Features
- Email and password validation
- Lookup and recognise country based on IP address
- Multiple integrations with database, email, HubSpot, REST API, Slack, etc.

## Installation
This project can be installed just by cloning. Modify `signup.blade.php` to your desired view.
Route: ```/{lang}/{id}``` -> Language is a required route paramater ['en', 'cn'] and referral ID is a optional route parameter (default = "").
Run `composer require kamermans/guzzle-oauth2-subscriber` or add the following to your `composer.json` to install Guzzle OAuth 2.0 Subscriber:

```javascript
    {
        "require": {
            "kamermans/guzzle-oauth2-subscriber": "~1.0"
        }
    }
```

## Integration
### Database 
Configure these environment variables in the `.env` file:
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

### Email
Configure these environment variables in the `.env` file:
```
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

### HubSpot
Add these environment variables to the `.env` file:

```
HUBSPOT_CLIENT_ID=XXXXX
HUBSPOT_CLIENT_SECRET=XXXXX
HUBSPOT_REFRESH_TOKEN=XXXXX
```
`XXXXX` indicates credentials you'll need for this integration. The table below summarizes each item and shows where you can find the credentials. Replace `XXXXX` with your own credentials and save the file.

| Credential | Description | Steps to obtain the credential |
|---|---|---|
| HUBSPOT_CLIENT_ID | Client ID. It is unique to HubSpot App. By combining Client ID and Client Secret, it can be initiated OAuth to call APIs. | Create  an app in a developer account and locate them on the Auth page of your app settings. |
| HUBSPOT_CLIENT_SECRET | Client Secret. Used to establish and refresh OAuth authentication. | Same as above. |
| HUBSPOT_REFRESH_TOKEN | Use the refresh token to generate a new access token. | Refer to the [Managing tokens](https://developers.hubspot.com/docs/api/oauth/tokens). |

### Slack 
Add these environment variables to the `.env` file:

```
SLACK_CHANNEL=XXXXX
```
`XXXXX` indicates webhook URL you'll need for this integration to a Slack channel. Create a Slack app (if you don't have one already). Obtain the webhook URL or add one at https://api.slack.com/apps and click inside your app Settings -> Features -> Incoming Webhooks.
Refer to https://api.slack.com/messaging/webhooks for more information.
