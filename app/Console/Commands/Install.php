<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify the installation process. Step 2 from the 2-step proces.';

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
        $this->alert('Welcome to step 2 of 2 of the installer!');

        $this->setupDatabase();
        $this->createUser();

        $this->call('cache:clear');
        $this->call('config:clear');

        $this->error('To use the media options, run the following command:');
        $this->line('ln -s ../storage/app storage');

        $this->alert('End of step 2. That is it, have fun!');
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
     * Create a user and assign admin-level. 
     */
    protected function createUser()
    {
        $this->question('Enter your details for the admin user.');

        $user = \App\User::create([
            'name' => $this->ask('Name', 'Admin'),
            'email' => $this->ask('Email address', 'noreply@'.str_replace(['http://', 'https://'], '', config('app.url'))),
            'password' => Hash::make($this->ask('Password')),
        ]);
        
        $this->info("Admin user created successfully. You can log in with username {$user->email}");
    }


    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function setupDatabase()
    {
        $this->call('migrate');
        $this->call('db:seed');

        $this->info('Database migrated and seeded.');
    }
}
