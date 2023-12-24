<?php

namespace App\Enums;

enum PostStatus : string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
}

?>
