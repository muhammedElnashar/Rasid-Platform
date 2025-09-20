<?php

namespace App\Console\Commands;

use App\Services\CardIssueService;
use Illuminate\Console\Command;

class DeferredDiscounts extends Command
{



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deferred:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CardIssueService $cardIssueService)
    {
        $cardIssueService->processDeferredDiscounts();
        $this->info('Deferred discounts processed successfully.');
    }
}
