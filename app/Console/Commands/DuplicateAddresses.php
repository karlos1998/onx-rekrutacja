<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Address;
use App\Models\Users;

use Illuminate\Support\Facades\DB;

class DuplicateAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:duplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicate Addresses';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sprwadzam duplikaty adresów...');


        $addresses = Address::all();

        $tmp = [];

        $count = 0;

        foreach($addresses as $address)
        {

            $user_array = $tmp[$address->user_id] ?? [];

            if(array_filter($user_array, function($row) use ($address) {
                return $row->name == $address->name &&
                $row->street == $address->street &&
                $row->zip == $address->zip;
            }))
            {
                echo "[{$address->user->email}] {$address->name} ({$address->zip})";
                echo PHP_EOL;

                $address->delete();
                
                $count++;

            }
            else
            {
                $user_array[] = $address;
                $tmp[$address->user_id] = $user_array;
            }
        }

        $this->info("Usuniętych duplikatów: $count");
        $this->info("Wazne! Dupliakty zostały usunięte jedynie u tych samych uzytkownikow :) Oznacza to, ze jesli ten adres miało dodanych kilku uzytkownikow nie będą onli mieli maksymalnie po jednym takim adresie.");

        return Command::SUCCESS;
    }
}
