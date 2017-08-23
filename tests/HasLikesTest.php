<?php

class HasLikesTest extends TestCase
{
	// =============================================
	// Likes
	// =============================================

    /** @test */
    public function it_can_be_liked_by_user()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->like($user);

        $this->assertCount(1, $entity->likes);
        $this->assertEquals($user->id, $entity->likes->first()->owner->id);
    }

    /** @test */
    public function it_can_be_unliked_by_user()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->like($user);
        $entity->unlike($user);

        $this->assertCount(0, $entity->likes);
    }

    /** @test */
    public function it_cannot_duplicate_likes()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->like($user);
        $entity->like($user);

        $this->assertCount(1, $entity->likes);
        $this->assertEquals($user->id, $entity->likes->first()->owner->id);
    }

    /** @test */
    public function it_can_has_multiple_likes()
    {
        $entity = $this->makeEntity();

        $entity->like($this->makeUser());
        $entity->like($this->makeUser());
        $entity->like($this->makeUser());

        $this->assertCount(3, $entity->likes);
    }

    /** @test */
    public function it_can_check_if_is_liked()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $this->assertFalse($entity->isLiked($user));

        $entity->like($user);
        
        $this->assertTrue($entity->isLiked($user));
    }

    /** @test */
    public function it_can_get_likes_count()
    {
        $entity = $this->makeEntity();

        $entity->like($this->makeUser());
        $entity->like($this->makeUser());
        $entity->like($this->makeUser());
        $entity->like($this->makeUser());

        $this->assertEquals(4, $entity->likesCount);
    }

    // =============================================
	// Dislikes
	// =============================================

    /** @test */
    public function it_can_be_disliked_by_user() 
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->dislike($user);

        $this->assertCount(1, $entity->dislikes);
        $this->assertEquals($user->id, $entity->dislikes->first()->owner->id);
    }

    /** @test */
    public function it_can_be_undisliked_by_user()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->dislike($user);
        $entity->undislike($user);

        $this->assertCount(0, $entity->dislikes);
    }
    
	/** @test */
    public function it_cannot_duplicate_dislikes()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->dislike($user);
        $entity->dislike($user);

        $this->assertCount(1, $entity->dislikes);
        $this->assertEquals($user->id, $entity->dislikes->first()->owner->id);
    }

    /** @test */
    public function it_can_has_multiple_dislikes()
    {
        $entity = $this->makeEntity();

        $entity->dislike($this->makeUser());
        $entity->dislike($this->makeUser());
        $entity->dislike($this->makeUser());

        $this->assertCount(3, $entity->dislikes);
    }

    /** @test */
    public function it_can_check_if_is_disliked()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $this->assertFalse($entity->isDisliked($user));

        $entity->dislike($user);
        
        $this->assertTrue($entity->isDisliked($user));
    }
    
    /** @test */
    public function it_cannot_be_liked_by_user_if_is_disliked()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->dislike($user);
        $entity->like($user);

        $this->assertCount(0, $entity->likes);
    }

    /** @test */
    public function it_cannot_be_disliked_by_user_if_is_liked()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $entity->like($user);
        $entity->dislike($user);

        $this->assertCount(0, $entity->dislikes);
    }

    /** @test */
    public function it_can_get_dislikes_count()
    {
        $entity = $this->makeEntity();

        $entity->dislike($this->makeUser());
        $entity->dislike($this->makeUser());
        $entity->dislike($this->makeUser());
        $entity->dislike($this->makeUser());

        $this->assertEquals(4, $entity->dislikesCount);
    }
}
