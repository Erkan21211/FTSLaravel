<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return view('dashboard', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create a new post
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Save the post with the authenticated user's ID
        Post::create([
            'user_id' => auth()->id(), // Use the currently authenticated user's ID
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Return the view with the post
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Check if the authenticated user owns the post
        if ($post->user_id !== auth()->id()) {
            abort(403); // Return 403 Forbidden if not authorized
        }

        // Return the view with the post
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Update the post
        $post->update(['user_id' => auth()->id(), 'title' => $validated['title'], 'content' => $validated['content']]);

        // Redirect to the index page
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete the post
        $post->delete();
        // Redirect to the index page
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
