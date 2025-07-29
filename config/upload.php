<?php

return [
    'avatar' => [
        'disk' => 'public',
        'directory' => 'avatars',
        'max_size' => 2048, // 2MB
        'allowed_mimes' => ['jpeg', 'png', 'jpg', 'gif'],
        'default_image' => 'images/default-avatar.png',
    ],
];
