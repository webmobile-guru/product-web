<?php

namespace App\Http\Controllers;

use App\CoinForList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Gregwar\Captcha\CaptchaBuilder;

class ListingController extends Controller
{
    const LIVE_MODE = 'live';

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
	
    public function showCoinListingForm()
    {
		$string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 42);
		
        session()->put('phrase', $string);
        
        return view('coin.request', compact('builder'));
    }

    public function saveCoinListingForm(Request $request)
    {//return $request->all();
        $this->validate($request, [
            'email_address' => 'required|email',
            'full_name' => 'required|string',
            'name_of_company' => 'required|string',
            'position_in_company.*' => 'required',
            'one_sentence_pitch' => 'required',
            'previously_send' => 'required|in:yes,no',
            'project_name' => 'required|string|max:255',
            'token_coin_name' => 'required|string|max:255',
            'token_coin_symbol' => 'required|string|max:10',
            'official_website' => 'required|url',
            'whitepaper_link' => 'required|url',
            'project_nature.*' => 'required',
            'main_application' => 'required',
            'target_industry' => 'required',
            'competetor' => 'required',
            'other_info' => 'required',
            'captcha' => 'required|passed',
        ], [
            '*.required' => 'This is a required field',
            'captcha.passed' => 'Captcha is invalid'
        ]);
        try {
            $position  = $request->input('position_in_company');
            if(end($position)=='Other'){
                array_pop($position);
            }

            $project_nature  = $request->input('project_nature');
            if(end($project_nature)=='Other'){
                array_pop($project_nature);
            }

            // $list = CoinForList::create([
            //     'user_id' => auth()->id(),
            //     'contact_email' => $request->input('email_address'),
            //     'full_name' => $request->input('full_name'),
            //     'company_name' => $request->input('name_of_company'),
            //     'position_in_company' => serialize($position),
            //     'one_sentence_pitch' => $request->input('one_sentence_pitch'),
            //     'previously_submited' => $request->input('previously_send'),
            //     // overview
            //     'project_name' => $request->input('project_name'),
            //     'coin_name' => $request->input('token_coin_name'),
            //     'coin_symbol' => $request->input('token_coin_symbol'),
            //     'website_link' => $request->input('official_website'),
            //     'whitepaper_link' => $request->input('whitepaper_link'),
            //     'project_nature' => serialize($project_nature),
            //     'project_application' => $request->input('main_application'),
            //     'target_industry' => $request->input('target_industry'),
            //     'project_competetor' => $request->input('competetor'),
            //     'remarks' => $request->input('other_info')
            // ]);

            $coinforlist = new CoinForList();
            $coinforlist->setConnection(self::LIVE_MODE);

            $coinforlist->user_id = auth()->id();
            $coinforlist->contact_email = $request->input('email_address');
            $coinforlist->full_name = $request->input('full_name');
            $coinforlist->company_name = $request->input('name_of_company');
            $coinforlist->position_in_company = serialize($position);
            $coinforlist->one_sentence_pitch = $request->input('one_sentence_pitch');
            $coinforlist->previously_submited = $request->input('previously_send');
                // overview
            $coinforlist->project_name = $request->input('project_name');
            $coinforlist->coin_name = $request->input('token_coin_name');
            $coinforlist->coin_symbol = $request->input('token_coin_symbol');
            $coinforlist->website_link = $request->input('official_website');
            $coinforlist->whitepaper_link = $request->input('whitepaper_link');
            $coinforlist->project_nature = serialize($project_nature);
            $coinforlist->project_application = $request->input('main_application');
            $coinforlist->target_industry = $request->input('target_industry');
            $coinforlist->project_competetor = $request->input('competetor');
            $coinforlist->remarks = $request->input('other_info');

            $coinforlist->save();

            flash()->success('Success! Your file has been updated');

            return redirect()->route('request.coin.success');
            
        } catch (\Exception $exception) {
            Log::error($exception);

            flash()->error('Error! List request has been failed');

            return redirect()->back()->withInput($request->except('_token'));
        }

    }

    public function successCoinListing()
    {
        try {
            

            return view('coin.confirm');
        } catch (\DecryptException $exception) {
            abort(404, 'Request doesn\'t exists');
        } catch (\Exception $exception) {
            abort(404, $exception->getMessage());
        }
    }
}
