<?php

namespace App\Services\Profiles;

use App\Repositories\UserRepository;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class AvatarService
{
    public function __construct(
        private UserRepository $userRepository,
        private AvatarStorageService $storageService)
    {
    }

    public function uploadAvatar(int $user_id, UploadedFile $file)
    {
        $this->storageService->putFromContent($user_id,'original',$file->getContent());
    }

    public function optimizeAvatar(int $user_id) {
        $manager = new ImageManager(new Driver());
        $imageContent = Storage::disk('avatars')->get($user_id . '/original.webp');
        $image = $manager->read($imageContent);
        $image->scale(128, 128);
        $this->storageService->putFromContent($user_id,'medium',$image->encode());
        $image->scale(64, 64);
        $this->storageService->putFromContent($user_id,'small',$image->encode());
    }

    public function createAvatar(int $user_id): array
    {
        $user = $this->userRepository->findOrFail($user_id);
        $email = strtolower(trim($user->email));
        if (!Gravatar::exists($email)) $email = Str::random(10) . '@example.com';
        $url_original = Gravatar::get($email,'original');
        $this->storageService->storeAvatarFromUrl($user_id,'original',$url_original);
        $url_medium = Gravatar::get($email,'medium');
        $this->storageService->storeAvatarFromUrl($user_id,'medium',$url_medium);
        $url_small = Gravatar::get($email,'small');
        $this->storageService->storeAvatarFromUrl($user_id,'small',$url_small);
        return [
            $url_original,$url_medium,$url_small
        ];
    }
}
