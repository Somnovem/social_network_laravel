<?php

namespace App\Jobs\Profiles;

use App\Services\Profiles\AvatarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OptimizeAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
            private int $user_id,
            private AvatarService $avatarService)
    {
        //$this->onConnection("avatars.jobs");
        $this->onQueue(env("REDIS_AVATARS_QUEUE", "avatars.jobs"));
    }

    public function handle(): void
    {
        $this->avatarService->optimizeAvatar($this->user_id);
    }
}
