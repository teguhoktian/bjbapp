<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:Admin Post|Editor Post|Writer');
        $this->middleware('permission:view post')->only('index');
        $this->middleware('permission:create post')->only('create', 'store');
        $this->middleware('permission:update post')->only('edit', 'update');
        $this->middleware('permission:delete post')->only('delete');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('post.index')->with(
            [
                'menu' => 'posts', 
                'submenu' => 'list',
                'page' => __('Posts')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('post.create')->with(
            [
                'menu' => 'posts', 
                'submenu' => 'create',
                'page' => __('Create Post')
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $request->validate([
            'title' => 'required|min:4|max:120',
            'content' => 'required',
        ]);

        $post = new Post;

        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = str_slug($request->title,"-");
        $post->user_id = \Auth::user()->id;
        $post->save();

        return redirect()->route('post.edit',['id' => $post->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        /*
        return view('post.show')->with(
            [
                'menu' => 'posts', 
                'submenu' => 'show',
                'page' => __('Show Role'),
                'post' => $post
            ]);
        */

        return redirect()->route('post.edit', ['id' => $post->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        return view('post.edit')->with(
            [
                'menu' => 'posts', 
                'submenu' => 'post',
                'page' => __('Edit Post'),
                'post' => $post
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request)
    {
        //
        $input = $request->all();

        $request->validate([
            'title' => 'required|min:4|max:120',
            'content' => 'required',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = str_slug($request->title,"-");
        $post->update();

        return redirect()->route('post.edit',['id' => $post->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return redirect()->route('post.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }

    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $post = Post::with('user')->select(['posts.id', 'title', 'posts.created_at', 'posts.updated_at', 'user_id']);

            if(\Auth::user()->hasRole('Writer')){
                $post->where('user_id',\Auth::user()->id);
            }

            return Datatables::of($post)
                    ->addColumn('action','post.action')
                    ->editColumn('created_at', function ($post) {
                        return $post->created_at ? with(new Carbon($post->created_at))->format('Y/m/d') : '';;
                    })
                    ->filterColumn('created_at', function ($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('updated_at', function ($post) {
                        return $post->updated_at ? with(new Carbon($post->updated_at))->format('Y/m/d') : '';;
                    })
                    ->filterColumn('updated_at', function ($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(updated_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
        }
    }
}
