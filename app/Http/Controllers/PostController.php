<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['tags', 'comments', 'images'])->get();
        // eager loading for all related models in one query
        
        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {      
       /*  
       if (Auth::guest()) {
           return redirect('/login');
       }*/
       
        return view('posts.create'); 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([ 
            'caption' => 'nullable|string|max:255',
            'images' => 'required|array',
            'images.*' => 'image|max:3096',
            'tag_text' => 'nullable|array',
            'tag_text.*' => 'string|distinct'
        ]);  
    
        $imgPaths = [];
        
        // Store each image and collect its path
        foreach ($request->file('images') as $image) {
            $imgPaths[] = $image->store('public/posts');
        }
    
        // Create new post
        $post = Post::create([
            'caption' => $data['caption']
        ]);
    
        // Associate each image with the post
        foreach ($imgPaths as $imgPath) {
            $postImage = new Post_image();
            $postImage->post_id= $post->id; 
            $postImage->img_path = $imgPath;
            $post->images()->save($postImage);
        }
    
        // Attach tags to the post
        if ($data['tag_text'] !== null) {
            foreach ($data['tag_text'] as $hashtag) {
                $tag = Tag::firstOrCreate(['tag_text' => $hashtag]);
                $post->tags()->attach($tag->id);     
            }
        }
    
        return redirect()->route('posts.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id)->with(['tags', 'comments', 'images'])->get();
        // dd($post[0]);
        return view("posts.edit" , ["post" => $post[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
