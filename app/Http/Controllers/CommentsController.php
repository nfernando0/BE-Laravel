<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'news_id' => 'required|exists:news,id',
            'comments' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $comment = Comments::create($validatedData);

        return new CommentsResource($comment);
    }

    public function destroy($id)
    {
        $comment = Comments::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }
}
