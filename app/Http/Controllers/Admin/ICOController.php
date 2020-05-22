<?php

namespace App\Http\Controllers\Admin;

use App\Ico;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repository\ICO\ICORepository;
use App\Http\Requests\IcoFormRequest;

class ICOController extends Controller
{
    protected $repo;
    
    protected $category = [
        'Art', 'Artificial intelligence', 'Banking', 'Big Data',
        'Business Service', 'Casino and Gambling', 'Charity',
        'Communications', 'Cryptocurrency', 'Education', 'Energy',
        'Entertainment', 'Featured', 'Health', 'Infrastructure',
        'Internet', 'Investment', 'Manufacturing', 'Media', 'Payments',
        'Platform', 'Real Estate', 'Retail', 'Smart Contract', 'Software',
        'Sports', 'Telecommunication', 'Tourism', 'Virtual Reality', 'Other',
    ];

    public function __construct(ICORepository $repository)
    {
        $this->repo = $repository;
    }

    public function index()
    {
        $icos = $this->repo->latest()->paginate(10);
        
        return view('admin.ico.index', compact('icos'));
    }

    public function edit($slug)
    {
        $ico = $this->repo->where('slug', $slug)->firstOrFail();
        $categories = $this->category;

        return view('admin.ico.edit', compact('ico', 'categories'));
    }

    public function update(IcoFormRequest $request, $slug)
    {
        if($request->ajax()) {
            return json_encode(['status' => true]);
        }

        try {

            $ico = Ico::where('slug', $slug)->first();

            $teams = []; $path = 'ico'.DIRECTORY_SEPARATOR.$ico->slug;

            $ico->title = $request->input('title');

            if($request->hasFile('logo')) {
                $file = $request->logo->store($path);

                $ico->logo = $file;
            }

            $ico->short_description = $request->input('short_description');
            $ico->ico_start_at = Carbon::parse($request->input('start_date'));
            $ico->ico_end_at = Carbon::parse($request->input('end_date'));
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

            $ico->link->website = $request->input('link.website');
            $ico->link->whitepaper = $request->input('link.whitepaper');
            $ico->link->twitter = $request->input('link.twitter');
            $ico->link->slack = $request->input('link.slack');
            $ico->link->telegram = $request->input('link.telegram');
            $ico->link->facebook = $request->input('link.facebook');
            $ico->link->reddit = $request->input('link.reddit');
            $ico->link->bitcointalk = $request->input('link.bitcointalk');
            $ico->link->medium = $request->input('link.medium');
            $ico->link->github = $request->input('link.github');
            $ico->link->discord = $request->input('link.discord');
            $ico->link->video = $request->input('link.video');
            $ico->link->airdrop = $request->input('link.airdrop');

            $teamCore = $request->input('core');
            $teamAdvisory = $request->input('advisory');

            $i = 0;
            foreach ((array) $teamCore as $team) {

                $obj = null;

                if(isset($team['team'])){
                    $obj = $ico->team()->core()->find($team['team']);
                } else {
                    $obj = new Team([
                        'type' => 'core',
                        'job_title' => $team['job_title'],
                        'full_name' => $team['full_name'],
                        'link' => $team['link']
                    ]);
                }

                if($request->hasFile('core.'.$i.'.photo')) {
                    $file = $request->file('core.'.$i.'.photo')->store($path);

                    $obj->photo = $file;
                }

                array_push($teams, $obj);
            }

            $i = 0;
            foreach ((array) $teamAdvisory as $team) {

                $obj = null;

                if(isset($team['team'])){
                    $obj = $ico->team()->advisory()->find($team['team']);
                } else {
                    $obj = new Team([
                        'type' => 'advisory',
                        'job_title' => $team['job_title'],
                        'full_name' => $team['full_name'],
                        'link' => $team['link']
                    ]);
                }
                if($request->hasFile('advisory.'.$i.'.photo')) {
                    $file = $request->file('advisory.'.$i.'.photo')->store($path);

                    $obj->photo = $file;
                }

                array_push($teams, $obj);
            }

            DB::transaction(function() use ($ico, $teams){
                $ico->save();
                $ico->link->save();

                foreach ($teams as $team) {
                    $ico->team()->save($team);
                }

            });

            flash()->success('Success! Modification of ico data done.')->important();

        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! Failed ico submission due to '.$exception->getMessage())->important();
        }
        return redirect()->back();
    }

    public function display($slug)
    {
        $ico = $this->repo->where('slug', $slug)->firstOrFail();

        return view('admin.ico.display', compact('ico'));
    }

    public function approve(Request $request, $slug)
    {
        $this->validate($request, [
            'publish_on' => 'required|date'
        ]);

        try {
            $ico = $this->repo->where('slug', $slug)->first();
            $ico->publish_status = 1;
            $ico->publish_at = Carbon::parse($request->publish_on);
            $ico->remarks = $request->remarks;
            $ico->save();

            flash()->success('Success! ICO has been publishing');

        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! ICO publish failed due to '. $exception->getMessage());
        }

        return redirect()->back();
    }

    public function reject(Request $request, $slug)
    {
        try {
            $ico = $this->repo->where('slug', $slug)->first();
            $ico->publish_status = 2;

            $ico->remarks = $request->remarks;
            $ico->save();

            flash()->success('Success! ICO has been rejected for publishing');

        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! ICO publish rejection failed due to '. $exception->getMessage());
        }

        return redirect()->back();
    }

    public function processMark($slug, $tag)
    {
        try {
            $ico = $this->repo->where('slug', $slug)->first();
            $markText = '';
            if($ico->hasTag($tag)) {
                $tags = explode(',', $ico->tag);
                $key = array_search($tag, $tags);
                unset($tags[$key]);
                $ico->tag = join(',', $tags);
                $markText = 'marked as '.$tag;
            } else {
                $tags = explode(',', $ico->tag);
                array_push($tags, $tag);
                $ico->tag = join(',', $tags);

                $markText = 'unmarked from '.$tag;
            }

            $ico->save();

            flash()->success('Success! ICO has been '.$markText);

        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! ICO marking failed due to '. $exception->getMessage());
        }

        return redirect()->back();
    }
}