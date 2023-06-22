<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Post;
use App\Models\PostDiscussions;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get all Posts.
     */
    public function getPosts()
    {
        $post = callStatic(Post::class, 'latest')
            ->paginate(20);

        // If post is empty return error.
        if (! $post) {
            return new ApiResource(['data' => null, 'error' => 'Posts not found.', 'status' => 404]);
        }

        return new ApiResource($post);
    }

    /**
     * Create Post slug.
     *
     * @param mixed $urlString
     */
    public function createUrlSlug($urlString)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);

        $slugExist = callStatic(Post::class, 'where', 'slug', $slug)->first();
        if ($slugExist) {
            $numbers = rand(1, 100);
            $slug = $slug.'-'.$numbers;

            return $this->createUrlSlug($slug);
        }

        return $slug;
    }

    /**
     * Update a Post.
     *
     * @param mixed $request
     */
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'slug' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If body is empty and attachment is empty return error.
        if (! $request->body && ! $request->title && ! $request->attachment) {
            return new ApiResource(['data' => null, 'message' => 'body or title or attachment is required.', 'status' => 422]);
        }

        $attachment = null;
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = slugify($request->title);
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $post->user_id = $request->user()->id;
        $post->save();

        $attachment = isset($request->attachment);

        if ($attachment) {
            $post->storeAttachment($request->attachment, 'image', $post->uuid);
        }

        return new ApiResource(['data' => $post, 'message' => 'Post created successfully.', 'status' => 201]);
    }

    /**
     * Update a Post.
     *
     * @param mixed $request
     * @param mixed $post_id
     */
    public function updatePost(Request $request, $post_id)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'slug' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If body is empty and attachment is empty return error.
        if (! $request->body && ! $request->title && ! $request->attachment) {
            return new ApiResource(['data' => null, 'message' => 'body or title or attachment is required.', 'status' => 422]);
        }

        $post = callStatic(Post::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('uuid', $post_id)->first();

        if (! $post) {
            return new ApiResource(['data' => null, 'message' => 'Post not found.', 'status' => 404]);
        }

        $post->title = $request->title;
        $post->body = $request->body;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $post->user_id = $request->user()->id;
        $post->save();

        if ($request->attachment) {
            $post->storeAttachment($request->attachment, 'image', $post->uuid);
        }

        return new ApiResource(['data' => $post, 'message' => 'Post update successfully.', 'status' => 201]);
    }

    /**
     * Delete all Posts.
     */
    public function deleteAllPosts(Request $request)
    {
        $posts = callStatic(Post::class, 'where', 'user_id', $request->user()->id)->get();

        foreach ($posts as $post) {
            $post->delete();
        }

        return new ApiResource(['data' => $posts, 'message' => 'All Post deleted']);
    }

    /**
     * Get specific Post.
     *
     * @param mixed $post_id
     */
    public function getSpecificPost($post_id)
    {
        $post = callStatic(Post::class, 'where', 'uuid', $post_id)->first();

        return new ApiResource(['data' => $post]);
    }

    /**
     * Delete post.
     *
     * @param mixed $post_id
     */
    public function deletePost($post_id)
    {
        $post = callStatic(Post::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('uuid', $post_id)->first();

        if (! $post) {
            return new ApiResource(['data' => null, 'message' => 'Post not found.', 'status' => 404]);
        }

        $post->delete();

        return new ApiResource(['data' => $post, 'message' => 'Post deleted']);
    }

    /**
     * Create a post comment.
     *
     * @param mixed $request
     * @param mixed $post_id
     */
    public function createPostComment(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If comment is empty and attachment is empty return error.
        if (! $request->comment && ! $request->attachment) {
            return new ApiResource(['data' => null, 'message' => 'body or title or attachment is required.', 'status' => 422]);
        }

        $owner = callStatic(Post::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('uuid', $post_id)->first();

        $comment = new PostDiscussions();
        $comment->comment = $request->comment;
        $comment->post_uuid = $post_id;
        $comment->is_owner = $owner->user_id == auth()->user()->id;
        $comment->user_id = $request->user()->id;
        $comment->save();

        if ($request->attachment) {
            $comment->storeAttachment($request->attachment, 'image', $comment->uuid);
        }

        return new ApiResource(['data' => $comment, 'message' => 'Comment created successfully.', 'status' => 201]);
    }

    /**
     * Create a post comment.
     *
     * @param mixed $request
     * @param mixed $post_id
     * @param mixed $comment_id
     */
    public function updatePostComment(Request $request, $post_id, $comment_id)
    {
        $request->validate([
            'comment' => 'required|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If comment is empty and attachment is empty return error.
        if (! $request->comment && ! $request->attachment) {
            return new ApiResource(['data' => null, 'error' => 'Comment or attachment is required.', 'status' => 422]);
        }

        $comment = callStatic(PostDiscussions::class, 'where', 'post_uuid', $post_id)
            ->where('uuid', $comment_id)
            ->first();

        // If comment is empty return error.
        if (! $comment) {
            return new ApiResource(['data' => null, 'error' => 'Comment not found.', 'status' => 404]);
        }
        $comment->comment = $request->comment;
        $comment->save();

        if ($request->attachment) {
            $comment->storeAttachment($request->attachment, 'image', $comment->uuid);
        }

        return new ApiResource(['data' => $comment, 'message' => 'Comment created successfully.', 'status' => 201]);
    }

    /**
     * get all post comments.
     *
     * @param mixed $post_id
     */
    public function getPostComments($post_id)
    {
        $post = callStatic(PostDiscussions::class, 'where', 'post_uuid', $post_id)->get();

        return new ApiResource(['data' => $post]);
    }

    /**
     * Delete comment.
     *
     * @param mixed $post_id
     * @param mixed $comment_id
     */
    public function deletePostComment($post_id, $comment_id)
    {
        $comment = callStatic(PostDiscussions::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('post_uuid', $post_id)
            ->where('uuid', $comment_id)->first();

        if (! $comment) {
            return new ApiResource(['data' => null, 'message' => 'Post not found.', 'status' => 404]);
        }

        $comment->delete();

        return new ApiResource(['data' => $comment, 'message' => 'comment deleted']);
    }

    /**
     * Delete all Post Comments.
     *
     * @param mixed $post_id
     */
    public function deleteAllPostComments(Request $request, $post_id)
    {
        $posts = callStatic(Post::class, 'where', 'user_id', $request->user()->id)->first();

        if ($posts) {
            $comments = callStatic(PostDiscussions::class, 'where', 'post_uuid', $post_id)->first();

            foreach ($comments as $comment) {
                $comment->delete();
            }

            return new ApiResource(['data' => $comments, 'message' => 'All comments deleted']);
        }
    }

    /**
     * get post specific comment.
     *
     * @param mixed $post_id
     * @param mixed $comment_id
     */
    public function getSpecificPostComment($post_id, $comment_id)
    {
        $comment = callStatic(PostDiscussions::class, 'where', 'post_uuid', $post_id)
            ->where('uuid', $comment_id)->first();

        // If comment is empty return error.
        if (! $comment) {
            return new ApiResource(['data' => null, 'error' => 'Comment not found.', 'status' => 404]);
        }

        return new ApiResource(['data' => $comment]);
    }
}
