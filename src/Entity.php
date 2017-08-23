<?php

namespace Abix\Likeable;

use Abix\Likeable\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasLikes;
}
