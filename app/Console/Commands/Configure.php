<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Configure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify the installation process. Step 1 from the 2-step proces.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->alert('Welcome to step 1 of 2 of the installer!');

        $this->createEnvFile();

        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');
        }

        $this->requestApplicationInformation();
        $this->setupDatabase();
        $this->requestMailInformation();
        
        $this->call('cache:clear');
        $this->call('config:clear');

        $this->alert('This is the end of step one. Run php artisan blog:install to continue the installation.');
    }

    //CUSTOM FUNCTIONS

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile()
    {
        if (! file_exists('.env')) {
            copy('.env.example', '.env');
            $this->line('.env file successfully created');
        }
    }

    /**
     * Request the local application details from the user.
     * Edit the .ENV file based on user input.
     *
     * @return array
     */
    protected function requestApplicationInformation()
    {
        $this->question('Please enter your application information');

        $data = [
            'APP_NAME' => "{$this->ask('Application name')}",
            'APP_URL' => ($this->ask('Is this site protected by SSL? (y/n)', 'y') == "y" ? "https://" : "http://") . $this->ask('URL'),
            'APP_LOCALE' => $this->ask('Language (nl or en)', 'en'),
            'APP_ENV' => 'local',
        ];

        $this->updateEnvironmentFile($data);

        $this->updateConfig('app', $data, 'APP');

        $this->info('Application information saved.');
    }

    /**
     * Request the local database details from the user.
     * Edit the .ENV file based on user input.
     *
     * @return array
     */
    protected function setupDatabase()
    {
        $this->question('Please enter your database information');

        $data = [
            'DB_DATABASE' => $this->ask('Database name'),
            'DB_PORT' => $this->ask('Database port', 3306),
            'DB_USERNAME' => $this->ask('Database user', 'root'),
            'DB_PASSWORD' => $this->ask('Database password (leave blank for no password)', ''),
        ];

        $this->updateEnvironmentFile($data);

        $this->info("Database details saved.");
    }

    /**
     * Request the local mail details from the user.
     * Edit the .ENV file based on user input.
     *
     * @return array
     */
    protected function requestMailInformation()
    {
        $this->question('Please enter your mailserver information');

        $data = [
            'MAIL_HOST' => $this->ask('Hostname mailserver', 'smtp.mailtrap.io'),
            'MAIL_PORT' => $this->ask('Mailserver port', 2525),
            'MAIL_USERNAME' => $this->ask('Username for mailserver', ''),
            'MAIL_PASSWORD' => $this->ask('Password for mailserver (leave blank for no password)', ''),
            'MAIL_FROM_ADDRESS' => $this->ask('Mailserver From-address', 'noreply@'.str_replace(['http://', 'https://'], '', config('app.url'))),
            'MAIL_FROM_NAME' => "{$this->ask('Mailserver From name', "Local Blog")}",
            'MAIL_ADMIN_ADDRESS' => $this->ask('Mailserver Admin-address', 'admin@'.str_replace(['http://', 'https://'], '', config('app.url'))),
        ];

        $this->updateEnvironmentFile($data);

        $this->info('Mailserver details saved.');
    }

    /**
     * Update the running config from an array of $key => $value pairs.
     *
     * @param   array $configarray      configuration array to edit
     * @param   array $data             Values to update
     * @param   array $prefix           Prefix to strip from data key to match config key
     * @return void
     */
    protected function updateConfig($configarray, $data, $prefix)
    {
        foreach ($data as $key => $value) {
            $configKey = strtolower(str_replace($prefix . '_', '', $key));
            if ($configKey === 'password' && $value == 'null') {
                config(["{$configarray}.{$configKey}" => '']);
                continue;
            }
            config(["{$configarray}.{$configKey}" => $value]);
        }
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param  array $updatedValues
     * @return void
     */
    protected function updateEnvironmentFile($updatedValues)
    {
        $envFile = $this->laravel->environmentFilePath();

        foreach ($updatedValues as $key => $value) {
            if (strpos($value, " ") || strpos($value, "@")) {
                file_put_contents($envFile, preg_replace(
                    "/{$key}=(.*)/",
                    "{$key}=\"{$value}\"",
                    file_get_contents($envFile)
                ));
            } else {
                file_put_contents($envFile, preg_replace(
                    "/{$key}=(.*)/",
                    "{$key}={$value}",
                    file_get_contents($envFile)
                ));
            }
        }
    }
}
