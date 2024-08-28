<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CommentTest extends TestCase
{
    public function testCreateComment() {
        $comment = new Comment();
        $comment->email = "adiefsal@gmail.com";
        $comment->title = "aku jg mw";
        $comment->comment = "ahh jgn dong";
        $comment->commentable_id = "1";
        $comment->commentable_type = "product";
        $comment->save();
        $this->assertNotNull($comment->id);
    }

    public function testDefaultValues() {
        $comment = new Comment();
        $comment->email = "adiefsal@gmail.com";
        $comment->commentable_id = "1";
        $comment->commentable_type = "product";
        $comment->save();
        $this->assertNotNull($comment->id);
        $this->assertEquals($comment->title, "Sample Title");
        $this->assertEquals($comment->comment, "Sample Comment");
        
    }

    
}
