<?php

namespace App\Console\Commands;

use Auth;
use Illuminate\Console\Command;

class UserLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login the user';

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
     * @return int
     */
    public function handle()
    {
        $this->info("Welcome please login to your game?");
        $email = $this->ask("Please enter your email");
        $password = $this->secret("Please enter your password");

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            return $user->id;
        }else{
            $this->info("<fg=red>Incorrect credentials, please try again</>");
            return $this->call("game:login");
        }
        return false;
    }
}
