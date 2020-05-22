<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class AnnouncementsController extends Controller
{
    protected $news;

    public function index()
    {
        $news = News::latest()->paginate(20);
        return view('front.announcement.index',compact('news'));
    }
    
    public function display($news_id)
    {
		$news = News::findOrFail($news_id);
        return response()->json(['news' => $news]);
    }

    
}
