<?php

namespace App\Services\Profiles;

use Illuminate\Support\Facades\Storage;

class AvatarStorageService
{
    public function storeAvatarFromUrl(int $user_id, string $avatar_type, string $avatar_url)
    {
        $imageContent = file_get_contents($avatar_url);

        $path = $user_id . '/' . $avatar_type . '.webp';

        Storage::disk('avatars')->put($path, $imageContent);
    }

    public function putFromContent(int $user_id,  string $avatar_type, string $avatar_content)
    {
        $path = $user_id . '/' . $avatar_type . '.webp';

        Storage::disk('avatars')->put($path, $avatar_content);
    }
}
