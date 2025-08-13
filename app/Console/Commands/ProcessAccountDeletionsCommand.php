<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAccountDeletionJob;
use App\Models\AccountDeletionRequest;
use Illuminate\Console\Command;

class ProcessAccountDeletionsCommand extends Command
{
    protected $signature = 'accounts:process-deletions';
    protected $description = 'Process scheduled account deletion requests';

    public function handle(): int
    {
        $pendingDeletions = AccountDeletionRequest::scheduledForDeletion()->get();

        if ($pendingDeletions->isEmpty()) {
            $this->info('No pending account deletions to process.');
            return 0;
        }

        $this->info("Processing {$pendingDeletions->count()} account deletion(s)...");

        foreach ($pendingDeletions as $deletionRequest) {
            ProcessAccountDeletionJob::dispatch($deletionRequest);
            $this->line("Queued deletion for user ID: {$deletionRequest->user_id}");
        }

        $this->info('All deletion jobs have been queued successfully.');
        return 0;
    }
}
