<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(20);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'author' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            Article::create($request->only('title', 'content', 'author'));
            return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return redirect()->route('articles.create')->with('error', 'Failed to create article. Please try again.');
        }
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
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'author' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $article = Article::findOrFail($id);
            $article->update($request->only('title', 'content', 'author'));
            return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            return redirect()->route('articles.edit', $id)->with('error', 'Failed to update article. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);
        if($article === null) {
            session()->flash('error', 'Article not found.');
            return response()->json(['status' => false]);
        }

        try {
            $article->delete();
            session()->flash('success', 'Article deleted successfully.');
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            session()->flash('error', 'Something went wrong, please try again.');
            return response()->json(['status' => false]);
        }
    }
}
