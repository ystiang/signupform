# signupform
An interactive signup form developed with PHP Laravel

## Features
- Email and password validation
- Lookup and recognise country based on IP address
- Multiple integration with database, email, HubSpot, REST API, Slack, etc.

## Installation
This project can be installed just by cloning. Modify `signup.blade.php` to your desired view.

## Integration
# HubSpot
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
