<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{

    public function index(Request $request)
    {

        $currentPage = $request->get('current_page');
        $news = News::paginate($currentPage);


        return response()->json([
            'success' => true,
            'current_page' => $news->currentPage(),
            'data' => NewsResource::collection($news->loadMissing(['user', 'comments'])),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|file|max:2048',
        ]);

        if($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images');
        }

        $validatedData['user_id'] = auth()->user()->id;

        $news = DB::table('news')->insert($validatedData);

        if($news){
            return response()->json([
                'success' => true,
                'message' => 'News created successfully',
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);



        $news = News::findOrFail($id);

        $news->update($validatedData);


        return new NewsResource($news);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return new NewsResource($news);
    }

    public function show($id)
    {
        $news = News::findOrFail($id);

        return new NewsResource($news->loadMissing(['user', 'comments']));
    }
}
