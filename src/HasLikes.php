<?php

namespace Abix\Likeable;

use Abix\Likeable\Like;
use Illuminate\Database\Eloquent\Model;

trait HasLikes
{
	/**
     * Collection of likes and dislikes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likesRelation()
    {
    	return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Has the user already liked or disliked likeable model.
     * 
     * @param  Model   $owner
     * @return boolean
     */
    public function isLikedOrDisliked(Model $owner)
    {
        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
        ];

        return $this->likesRelation()->where($attributes)->exists();
    }

    /**
     * Collection of likes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->likesRelation()->where('type', Like::LIKE);
    }

    /**
     * Collection of dislikes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function dislikes()
    {
        return $this->likesRelation()->where('type', Like::DISLIKE);
    }

    /**
     * Add a like.
     * 
     * @param  Model  $owner
     * @return self
     */
    public function like(Model $owner)
    {
        if ($this->isLikedOrDisliked($owner)) {
            return;
        }

        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::LIKE,
        ];

        $this->likes()->create($attributes);

        return $this;
    }

    /**
     * Remove a like.
     * 
     * @param  Model  $owner
     * @return self
     */
    public function unlike(Model $owner)
    {
        if (! $this->isLiked($owner)) {
            return;
        }

        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::LIKE,
        ];

        $this->likes()->where($attributes)->first()->delete();

        return $this;
    }

    /**
     * Add a dislike.
     * 
     * @param  Model  $owner
     * @return self
     */
    public function dislike(Model $owner)
    {
        if ($this->isLikedOrDisliked($owner)) {
            return;
        }

        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::DISLIKE,
        ];

        $this->dislikes()->create($attributes);

        return $this;
    }

    /**
     * Remove a dislike.
     * 
     * @param  Model  $owner
     * @return self
     */
    public function undislike(Model $owner)
    {
        if (! $this->isDisliked($owner)) {
            return;
        }

        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::DISLIKE,
        ];

        $this->dislikes()->where($attributes)->first()->delete();

        return $this;
    }

    /**
     * Has the user already liked likeable model.
     * 
     * @param  Model   $owner
     * @return boolean
     */
    public function isLiked(Model $owner)
    {
        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::LIKE,
        ];

        return $this->likes()->where($attributes)->exists();
    }

    /**
     * Has the user already disliked likeable model.
     * 
     * @param  Model   $owner
     * @return boolean
     */
    public function isDisliked(Model $owner)
    {
        $attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'type' => Like::DISLIKE,
        ];

        return $this->dislikes()->where($attributes)->exists();
    }

    // =============================================
    // Accessors
    // =============================================
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->dislikes()->count();
    }
}
