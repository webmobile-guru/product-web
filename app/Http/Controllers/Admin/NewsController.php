<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $news = News::latest()->paginate(20);
        return view('admin.news.index',compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'heading' => 'required',
            'content' => 'required',
        ]);
		try {
        $this->news->create([
            'user_id' => auth()->id(),
            'heading' => $request->input('heading'),
            'content' => $request->input('content'),
        ]);
       flash()->success('Success! News Created');
        
        }catch (\Exception $exception) {
		  Log::error('Error from News controller '.$exception->getMessage());
		  flash()->error('message', 'Error! News creation failed');
		}
		
        return redirect()->route('admin.news.index');
    }

    public function news_delete(Request $request){
        $id = $request->input('id');
        $this->news->where('id',$id)->delete();
        flash()->success('Success! News Deleted Successfully!');
        return redirect()->route('admin.news.index');
    }
}
