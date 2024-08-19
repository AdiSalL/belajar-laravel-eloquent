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
        
        $comment->save();
        $this->assertNotNull($comment->id);
    }
}
