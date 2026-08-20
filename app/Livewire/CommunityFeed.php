<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CommunityFeed extends Component
{
    use WithPagination;

    public string $newPostBody = '';
    public int $commentingOn = 0;
    public string $commentBody = '';

    protected $rules = [
        'newPostBody' => 'required|string|max:2000',
        'commentBody' => 'required|string|max:1000',
    ];

    public function createPost()
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->validate(['newPostBody' => 'required|string|max:2000']);

        Post::create([
            'user_id' => Auth::id(),
            'body' => $this->newPostBody,
        ]);

        $this->newPostBody = '';
        $this->dispatch('post-created');
    }

    public function toggleLike(int $postId)
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        // likes are polymorphic; unique index (user_id, likeable_id, likeable_type)
        // guards against duplicate rows under concurrency (C5).
        DB::transaction(function () use ($postId) {
            $existing = Like::where('user_id', Auth::id())
                ->where('likeable_type', Post::class)
                ->where('likeable_id', $postId)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                $existing->delete();
                Post::where('id', $postId)->decrement('likes_count');
            } else {
                Like::create([
                    'user_id' => Auth::id(),
                    'likeable_id' => $postId,
                    'likeable_type' => Post::class,
                ]);
                Post::where('id', $postId)->increment('likes_count');
            }
        });
    }

    public function toggleCommentForm(int $postId)
    {
        $this->commentingOn = $this->commentingOn === $postId ? 0 : $postId;
        $this->commentBody = '';
    }

    public function addComment(int $postId)
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->validate(['commentBody' => 'required|string|max:1000']);

        Comment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $postId,
            'commentable_type' => Post::class,
            'body' => $this->commentBody,
        ]);

        Post::where('id', $postId)->increment('comments_count');

        $this->commentBody = '';
        $this->commentingOn = 0;
    }

    public function render()
    {
        $posts = Post::with('user', 'comments.user')
            ->latest()
            ->paginate(10);

        return view('livewire.community-feed', compact('posts'));
    }
}
