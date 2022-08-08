<?php

namespace App\Controller;

use App\Entity\Post;

class PostPublishController
{
    public function __invoke(Post $data)
    {
        $data->setOnline(true);
        return $data;
    }
}
