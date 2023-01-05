<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;

class AdminPermissionManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $role = 'administrator';

        $email = $this->argument('email');

        $user = User::where('email', $email)->first();
        if(!$user) return $this->error("User with email test '$email' not exist");

        $fullname = $user->firstname . " " . $user->lastname;
        //$this->line("Admin permission edit for user '$fullname'");


        if( !$user->hasRole($role) )
        {
            if ($this->confirm("This user '$fullname' will now become an administrator. Do you want to continue?", true) )
            {
                $user->attachRole($role);
                $this->info("Success");
            }
        }
        else
        {
            if ($this->confirm("The user '$fullname' is already an administrator. Do you want the rank removed from him?")) 
            {
                $user->detachRole($role);
                $this->info("Success");
            }
        }

        return Command::SUCCESS;
    }
}
