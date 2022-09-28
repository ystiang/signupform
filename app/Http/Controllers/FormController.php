<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\SlackNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\Signer\ClientCredentials\PostFormData;
use Notification;



class FormController extends Controller
{
    public function store(Request $request)
    {
        /* Grab all variables */
        $requestData = $request->except('_token');
        $firstName = $requestData['firstName'];
        $lastName = $requestData['lastName'];
        $country = strtoupper($requestData['country']);
        $phone = $requestData['full_phone'];
        $email = $requestData['email'];
        $password = $requestData['password'];
        $referralID = $requestData['id'];
        $language = $requestData['lang'];

        if ($request->has('Check1'))    {
            /* Global variables for HubSpot integration */
            $client_id = config('integration.hubspot_client_id');
            $client_secret = config('integration.hubspot_client_secret');
            $refresh_token = config('integration.hubspot_refresh_token');
            $slack_channel = config('integration.slack_channel_antt');        
        
            // Authorisation client - to request OAuth access token
            $reauth_client = new Client([
                // URL for access_token request
                'base_uri' => 'https://api.hubapi.com/oauth/v1/token',            
            ]);
            $reauth_config = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'refresh_token' => $refresh_token,
            ];

                
            // This grant type is used to get a new Access Token and Refresh Token when
            //  no valid Access Token or Refresh Token is available
            // $grant_type = new ClientCredentials($reauth_client, $reauth_config);

            // This grant type is used to get a new Access Token and Refresh Token when
            //  only a valid Refresh Token is available
            $refresh_grant_type = new RefreshToken($reauth_client, $reauth_config);

            // Tell the middleware to use the two grant types
            $oauth = new OAuth2Middleware($refresh_grant_type);
            $oauth->setClientCredentialsSigner(new PostFormData());

            $stack = HandlerStack::create();
            $stack->push($oauth);

            /**
             * HubSpot's Integration
             * Post to external API via OAuth 2.0
             * Create a contact on HubSpot with properties
            **/

                // This is the normal Guzzle client that you use in your application
            $client = new Client([
                'handler' => $stack,
                'auth'    => 'oauth',
            ]);

            $body = [
                'properties' => [
                    'email' => $email,
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'phone' => $phone,
                    'country' => $country,                        
                ],
            ];            
                
            $contact = $client->post('https://api.hubapi.com/crm/v3/objects/contacts', [
                'json' => $body,
            ]);
            $contactBody = json_decode($contact->getBody(), true);          
            
            return redirect();
        }
        try
        {
        // 
        //  Show/Write your API or DB codes here
        //
        //dd($requestData);            
        dd($request->all());
            
        // Notification::route('slack', $slack_channel)
        // ->notify(new SlackNotification($firstName, $lastName, $country, $phone, $email, $referralID));          

        }
        catch(RequestException $e) {
            // dd($e);
            if ($e->hasResponse())
                $response = $e->getResponse();                
        }         
        catch(\Exception $e) {
            dd($e);
        }    
    }
}
