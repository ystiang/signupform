<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Services\AccountService;
use App\Models\Services\HubSpotService;
use App\Models\Services\NotificationService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;


class FormController extends Controller
{
    protected $hubspot_service;
    protected $account_service;
    protected $notification_service;

    public function __construct()
    {
        $this->hubspot_service = new HubSpotService();
        $this->account_service = new AccountService();
        $this->notification_service = new NotificationService();
    }

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
        
        try 
        {
            $crm_message = "";
            $db_message = "";
            $mail_message = "";
            $slack_message = "";
            if ($request->has('crm')) {
                                    
                $this->hubspot_service->createContact($firstName, $lastName, $email, $phone, $country);
                $crm_message = " + HubSpot contact created";
                
            }
            if ($request->has('db')) {
                $this->account_service->createAccount($firstName, $lastName, $email, $password, $country, $phone, $referralID);
                $db_message = " + Database record inserted";                       
            }
            if ($request->has('mail')) {
                $this->notification_service->sendEmail($firstName, $lastName, $email);
                $mail_message = " + Email sent";            
            }
            if ($request->has('slack')) {
                $this->notification_service->sendSlackNotification($firstName, $lastName, $country, $phone, $email, $referralID);
                $slack_message = " + Slack notified";        
            }
            $form_message = "Account created";
            return redirect()->back()->with('alert', $form_message.$crm_message.$db_message.$mail_message.$slack_message); 
        } catch(RequestException $e) {
            // dd($e);
            if ($e->hasResponse()) {
                $response = $e->getResponse();    
                if ($response->getStatusCode() == 409) {
                    return redirect()->back()->with('alert', "HubSpot contact existed!");
                }
                if ($response->getStatusCode() == 400) {
                    return redirect()->back()->with('alert', "Bad request! Invalid credentials!");
                }     
            }    
        } catch(\Exception $e) {
            dd($e);
        }      
    }
}