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
        $this->url = 'https://www.google.com/recaptcha/api/siteverify';
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->url]);
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
        $return = json_decode($this->client->post('siteverify', [
            'query' => [
                'secret' => \Setting::get('recaptcha.server'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]
        ])->getBody());
        
        if ($return->success === true && $return->score > 0.7) {
            return true;
        }

        return false;
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
