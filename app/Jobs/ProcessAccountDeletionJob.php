<?php

namespace App\Jobs;

use App\Models\AccountDeletionRequest;
use App\Services\Admin\Account\A_ManageAccountDeletionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAccountDeletionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private AccountDeletionRequest $deletionRequest
    ) {}

    public function handle(A_ManageAccountDeletionService $deletionService): void
    {
        if ($this->deletionRequest->status === 'pending' && 
            $this->deletionRequest->scheduled_deletion_at <= now()) {
            
            $deletionService->approve($this->deletionRequest->id);
        }
    }
}
