<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoundCollection;
use Carbon\Carbon;
class DeactiveRoundCoundlection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactive:round-colection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto deactive round collection if over date';

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
        $now = Carbon::now()->toDateTimeString();

        $roundCollections = RoundCollection::where('status', 1)->where('expiration_time', '<' , $now)->get();

        if (!empty($roundCollections)) {
            foreach ($roundCollections as $key => $roundCollection) {
                $roundCollection->status = 0;
                $roundCollection->save();
            }
        }
        return "done";
    }
}
