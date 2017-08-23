<?php

namespace Abix\Likeable;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	const LIKE = 'like';
    const DISLIKE = 'dislike';
	
    protected $guarded = [];
    
    public function owner()
    {
        return $this->morphTo();
    }

    public function likeable()
    {
    	return $this->morphTo();
    }
}
