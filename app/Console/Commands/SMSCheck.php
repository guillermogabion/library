<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
// use App\Borrow ;
use App\Models\Borrow;


class CheckItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SMSCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
   return Borrow::where('created_at', '>=', Carbon::today()->subDays(3))->update([
        'status' => 'Over Due'
    ]);
}
}