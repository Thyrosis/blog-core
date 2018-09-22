<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule
{
    protected $url;
    protected $client;
    protected $data = [];

    /**
     * Get local settings from configs
     */
    public function __construct()
    {
        $this->url = config('services.recaptcha.url');
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->url]);
        // $this->data['auth'] = [config('services.mailchimp.user'), config('services.mailchimp.secret')];
        $this->data['http_errors'] = false;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return json_decode($this->client->post('siteverify', [
            'query' => [
                'secret' => config('services.recaptcha.secretkey'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]
        ])->getBody())->success;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Voel je je wel oké? Je lijkt wel een beetje op een robot...';
    }
}
