<?php

namespace App;

class FaceBook
{
    protected $url;
    protected $client;
    protected $data = [];
    protected $list;

    /**
     * Get local settings from configs
     */
    public function __construct()
    {
        $this->url = config('services.facebook.domain');
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->url]);
        $this->data['auth'] = [config('services.mailchimp.user'), config('services.mailchimp.secret')];
        $this->data['http_errors'] = false;
        $this->list = config('services.mailchimp.listId');
    }

    /**
     * Get the current list details.
     * List is selected in config.
     * 
     * @return  Json    Response with list details
     */
    public function getList()
    {
        return $this->client->request('GET', "lists/{$this->list}", $this->data)->getBody()->getContents();
    }

    /**
     * Get the current list subscribers.
     * List is selected in config.
     * 
     * @return Json     Response with list subscribers
     */
    public function getListSubscribers()
    {
        return $this->client->request('GET', "lists/{$this->list}/members", $this->data)->getBody()->getContents();
    }

    /**
     * Subscribe a new email address to the list.
     * 
     * @param   String $emailaddress     The email address to add to the list
     * @return  Boolean  Processed response. True if adding was succesfull, false if not.
     */
    public function subscribe($emailaddress = false)
    {
        if (!$emailaddress) {
            return false;
        }

        $body = [
            "email_address" => $emailaddress,
            "status" => "pending",
            "merge_fields" => [
                "FNAME" => "",
                "LNAME" => "",
            ]
        ];

        $this->data['body'] = json_encode($body);

        $response = $this->client->request('POST', "lists/{$this->list}/members", $this->data);

        return $this->processResponse($response);
    }

    /**
     * Edit an existing email address on list.
     * 
     * @param   String $emailaddress     The email address to edit to the list
     * @param   String $newemailaddress  The email address to change it to
     * @return  Boolean  Processed response. True if adding was succesfull, false if not.
     */
    public function edit($emailaddress = false, $newemailaddress = false)
    {
        if (!$emailaddress || !$newemailaddress) {
            return false;
        }

        $body = [
            "email_address" => $newemailaddress,
            // "status" => "subscribed",
            "merge_fields" => [
            ]
        ];

        $this->data['body'] = json_encode($body);

        // MailChimp expects a subscriber hash, not a 'plain text' email address
        $subscriber_hash = md5(strtolower($emailaddress));

        $response = $this->client->request('PATCH', "lists/{$this->list}/members/{$subscriber_hash}", $this->data);

        return $this->processResponse($response);
    }

    /**
     * Unsubscribe an email address from the list.
     * 
     * @param   String $emailaddress     The email address to unsubscribe from the list
     * @return  Boolean  Processed response. True if adding was succesfull, false if not.
     */
    public function unsubscribe($emailaddress = false)
    {
        if (!$emailaddress) {
            return false;
        }

        $body = [
            "status" => "unsubscribed"
        ];

        $this->data['body'] = json_encode($body);

        // MailChimp expects a subscriber hash, not a 'plain text' email address
        $subscriber_hash = md5(strtolower($emailaddress));

        $response = $this->client->request('PATCH', "lists/{$this->list}/members/{$subscriber_hash}", $this->data);

        return $this->processResponse($response);
    }

    /**
     * Process the response.
     * 
     * Check if the status code is 200 or 204 (success). If so, return true. 
     * If not, extract the reason (start logging dipshit!) and return false.
     * 
     * @param   Response $response     The email address to add to the list
     * @return  Boolean  Processed response. True if adding was succesfull, false if not.
     * @todo	Logging the responses so you don't actually have to locally debug
     */
    public function processResponse($response)
    {
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 204) {
            $reason = json_decode($response->getBody()->getContents());
            // return $reason->detail;
            return false;
        }

        return true;
    }
}
