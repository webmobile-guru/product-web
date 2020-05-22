<?php

namespace App\Http\Controllers;

use App\Coin;
use App\CoinPair;
use App\Mail\ContactUsEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('twofa');
    }

    public function home()
    {
        $coins = Coin::whereIn('coin', ['BCH','ETH','XRP','LTC'])->get();

        $coinPrice = [];

        foreach($coins as $coin) {
            $coinPrice[$coin->coin] = number_format($coin->getPrice(), 8);
        }

        return view('page.home', compact('coinPrice'));
    }
    
    public function faq()
    {
        return view('page.faq');
    }
    
    public function gainers()
    {
        $pairsBtc = CoinPair::whereHas('baseCoin',function ($q){
            $q->where('coin', 'BTC');
        })->active()->get();

        return view('page.gainers', compact('pairsBtc'));
    }
    
    public function about()
    {
        return view('page.about');
    }
    public function testimonials()
    {
        return view('page.testimonials');
    }

    public function privacyPolicy()
    {
        return view('page.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('page.terms-conditions');
    }


    public function contact()
    {
        return view('page.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'comment' => 'required|min:10'
        ]);

        try {

            $to = config('mail.from.address');
            $email = $request->input('email');
            $enquirar = $request->input('enquirar');
            $comment = $request->input('comment');

            Mail::to($to)
                ->bcc($email)
                ->queue(new ContactUsEmail([
                    $enquirar,
                    $email,
                    $comment,
                ]));

            flash()->success('Success! Request for enquiry has been sent');

        } catch(\Exception $exception) {
            Log::error($exception);

            flash()->error($exception->getMessage());
        }

        return redirect()->back();
    }
	
	public function setLocale($locale)
    {
        $locale = strtolower($locale);

        if (! array_key_exists($locale, config('app.locales'))) {
            return json_encode(['status' => false, 'locale' => null]);
        }

        $request = request();

        if($request->user()){
            $request->user()->language = $locale;
        }

        app()->setLocale($locale);

        $url = explode('/', parse_url(url()->previous())['path']);
        $url[1] = $locale;
        $url = implode('/', $url);

        if($request->ajax()) {
            return json_encode(['status' => true, 'locale' => $url]);
        }
        return redirect()->to($url);
    }
}
