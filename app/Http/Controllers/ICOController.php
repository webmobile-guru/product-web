<?php

namespace App\Http\Controllers;

use App\Http\Requests\IcoFormRequest;
use App\Ico;
use App\Link;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Gregwar\Captcha\CaptchaBuilder;

class ICOController extends Controller
{
    protected $category = [
        'Art', 'Artificial intelligence', 'Banking', 'Big Data',
        'Business Service', 'Casino and Gambling', 'Charity',
        'Communications', 'Cryptocurrency', 'Education', 'Energy',
        'Entertainment', 'Featured', 'Health', 'Infrastructure',
        'Internet', 'Investment', 'Manufacturing', 'Media', 'Payments',
        'Platform', 'Real Estate', 'Retail', 'Smart Contract', 'Software',
        'Sports', 'Telecommunication', 'Tourism', 'Virtual Reality', 'Other',
    ];
    
    protected function randomString($length = 4) {
		$str = "";
		$characters = array_merge(range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
    
    public function showListedIco()
    {

        $query = Ico::containTag('top')->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showPreIco()
    {
        $query = Ico::pre()->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showOngoingIco()
    {
        $query = Ico::active()->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showUpcomingIco()
    {
        $query = Ico::upcoming()->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showPastIco()
    {
        $query = Ico::past()->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showAirdropIco()
    {
        $query = Ico::airdrop()->publishable();

        if ($category = request()->category) {
            $query = $query->where('category', 'like', '%'.$category.'%');
        }

        if ($keyword = request()->keyword){

            $query = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('short_description','like', '%'.$keyword.'%')
                ->orWhere('feature_description','like', '%'.$keyword.'%')
                ->orWhere('participation_restriction','like', '%'.$keyword.'%')
                ->orWhere('listing_exchange','like', '%'.$keyword.'%');
        }

        $icos = $query->orderBy('tag','desc')->get();

        $hotIcos = Ico::ContainTag('hot')->get();

        return view('ico.list',compact('icos', 'hotIcos'));
    }

    public function showSpecificIco($slug)
    {
        $ico = Ico::where('slug', $slug)->firstOrFail();
        return view('ico.display',compact('ico'));
    }

    public function showSubmitIcoForm()
    {
        $categories = $this->category;
        $string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 42);
		
        session()->put('phrase', $string);  

        return view('ico.submit', compact('categories','builder'));
    }

    public function processIcoForm(IcoFormRequest $request)
    {
        if($request->ajax()) {
            return json_encode(['status' => true]);
        }

        try {
			
            $slugCode = str_random(30);

            $ico = new Ico(); $link = new Link(); $teams = []; $path = 'ico'.DIRECTORY_SEPARATOR.$slugCode;
			
			if($user = Auth::user())
			{
				$ico->user_id = $user->id;
			}
			
            $ico->slug = $slugCode;

            $ico->title = $request->input('title');
            if($request->has('category')){
                $ico->category = join(',', $request->input('category'));
            }

            if($request->hasFile('logo')) {
                $file = $request->logo->store($path);

                $ico->logo = $file;
            }

            $ico->short_description = $request->input('short_description');

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $ico->ico_start_at = empty($startDate)?null:Carbon::parse($startDate);
            $ico->ico_end_at = empty($endDate)?null:Carbon::parse($endDate);

            $ico->additional_notes = $request->input('ad_notes');

            $ico->feature_description = $request->input('features');

            $ico->whitelist = $request->input('whitelist', 'no');
            $ico->token_sale_hard_cap = $request->input('hard_cap');
            $ico->token_sale_hard_cap_currency = $request->input('hard_cap_cur');
            $ico->token_sale_soft_cap = $request->input('soft_cap');
            $ico->token_sale_soft_cap_currency = $request->input('soft_cap_cur');

            $ico->airdrop = $request->input('airdrop','no');

            $ico->presale = $request->input('presale');
            if($request->has('presale_start_date')) {
                $ico->presale_start_at = Carbon::parse($request->input('presale_start_date'));
            }

            if($request->has('presale_end_date')) {
                $ico->presale_end_at = Carbon::parse($request->input('presale_end_date'));
            }

            
            $ico->token_symbol = $request->input('token_symbol');
            $ico->token_type_and_platform = $request->input('token_type_platform');
            $ico->token_distribution = $request->input('token_distribution');
            $ico->price_per_token = $request->input('price_per_token');
            $ico->kyc = $request->input('kyc', 'no');
            $ico->participation_restriction = $request->input('participation_restriction');
            $ico->selling_to_us_canada = $request->input('selling_to_us_canada', 0);
            $ico->accept_coin = $request->input('accept_currency');
            $ico->listing_exchange = $request->input('exchange_listing');

            $ico->company_name = $request->input('company_name');
            $ico->company_info = $request->input('company_info');
            $ico->contact_person_name = $request->input('contact_person_name');
            $ico->permissions = json_encode($request->input('permission'));
            $ico->involvement = json_encode($request->input('involvement'));
            $ico->contact_person_email = $request->input('contact_person_email');
            $ico->contact_person_telegram = $request->input('contact_person_telegram');
            $ico->marketing_services = json_encode($request->input('marketing'));
            $ico->listing_fee = $request->input('listing_fee');
            $ico->how_you_hear_about_us = $request->input('hear_about_us');
            
            $link->website = $request->input('link.website');
            $link->whitepaper = $request->input('link.whitepaper');
            $link->twitter = $request->input('link.twitter');
            $link->slack = $request->input('link.slack');
            $link->telegram = $request->input('link.telegram');
            $link->facebook = $request->input('link.facebook');
            $link->reddit = $request->input('link.reddit');
            $link->bitcointalk = $request->input('link.bitcointalk');
            $link->medium = $request->input('link.medium');
            $link->github = $request->input('link.github');
            $link->discord = $request->input('link.discord');
            $link->video = $request->input('link.video');
            $link->airdrop = $request->input('link.airdrop');

            $teamCore = $request->input('core');
            $teamAdvisory = $request->input('advisory');
            $i = 0;

            foreach ((array) $teamCore as $team) {
                $obj = new Team([
                    'type' => 'core',
                    'job_title' => $team['job_title'],
                    'full_name' => $team['full_name'],
                    'link' => $team['link']
                ]);

                if($request->hasFile('core.'.$i.'.photo')) {
                    $file = $request->file('core.'.$i.'.photo')->store($path);

                    $obj->photo = $file;
                }

                array_push($teams, $obj);
            }

            $i = 0;
            foreach ((array) $teamAdvisory as $team) {
                $obj = new Team([
                    'type' => 'advisory',
                    'job_title' => $team['job_title'],
                    'full_name' => $team['full_name'],
                    'link' => $team['link']
                ]);

                if($request->hasFile('advisory.'.$i.'.photo')) {
                    $file = $request->file('advisory.'.$i.'.photo')->store($path);

                    $obj->photo = $file;
                }

                array_push($teams, $obj);
            }

            DB::transaction(function() use ($ico, $teams, $link){
                $ico->save();
                $ico->link()->save($link);
                $ico->team()->saveMany($teams);
            });
            
            return redirect()->route('ico.submit.success', [$slugCode]);
            
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! Failed ico submission due to '.$exception->getMessage());
        }
        return redirect()->back()->withInput($request->all());
    }

    public function success($slug)
    {
        $ico = Ico::where('slug', $slug)->first();

        return view('ico.success', compact('ico'));
    }
}

