<?php

namespace App\Console\Commands;

use App\Models\Hospital;
use Illuminate\Console\Command;

class BotConRec extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'botconrec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aqui uma breve descrição do comando';

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
        // Aqui o que vai ser executado
        echo "Teste".PHP_EOL;

        Hospital::create([
            'nm_hospital' => 'Hospital Santa Clara'
        ]);

        return 0;
    }
}
