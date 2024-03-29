<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\UploadUserAvatarRequest;
use App\Jobs\Profiles\CreateAvatarJob;
use App\Jobs\Profiles\OptimizeAvatarJob;
use App\Services\Profiles\AvatarService;
use App\Services\Socket\SocketService;

class UploadUserAvatarController extends Controller
{
    public function __construct()
    {
    }
    public function __invoke(
        SocketService $socketService,
        AvatarService $avatarService,
        UploadUserAvatarRequest $request)
    {
        $user_id = $request->user()->id;
        $avatarService->uploadAvatar($user_id,$request->file('avatar'));
        OptimizeAvatarJob::dispatch($user_id,$avatarService);
        //$socketService->emit('socket.php',date('Y-m-d H:i:s'));
        // CreateAvatarJob::dispatch($request->user()->id);
        // return response()->json($this->avatarService->getAvatarFromGravatar($request->user()->id));
    }
}
