<?php

namespace App\Jobs\Profiles;

use App\Services\Profiles\AvatarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $user_id)
    {
        //$this->onConnection("avatars.jobs");
        $this->onQueue(env("REDIS_AVATARS_QUEUE", "avatars.jobs"));
    }

    /**
     * Execute the job.
     */
    public function handle(AvatarService $avatarService): void
    {
        $avatarService->createAvatar($this->user_id);
    }
}
