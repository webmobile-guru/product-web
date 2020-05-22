<?php

namespace App\Http\Controllers\Admin;
use App\Coin;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
	protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function getCommissionSetting()
    {
		$settings = $this->setting->all();
    	return view('admin.setting.commission',compact('settings'));
    }

	public function setCommissionSetting(Request $request)
	{
		$this->validate($request, [
			'taker_fee' => 'required|numeric|min:0',
			'maker_fee' => 'required|numeric|min:0'
		]);

		try {

			$this->setting->createOrUpdate($request->except('_token'));

		} catch (\Exception $exception) {
			Log::error($exception);
			flash()->error('Error! There is an error saving settings');
		}

		return redirect()->back();
	}

    public function commission(Request $request)
    {
		  $this->validate($request, [
            /*'withdrawal_commission' => 'numeric|min:0|nullable',
            'deposit_fee' => 'numeric|min:0|nullable',
            'transfer_fee' => 'numeric|min:0|nullable',*/
            'maker_fee' => 'numeric|min:0|nullable',
            'taker_fee' => 'numeric|min:0|nullable',
        ]);

		try {

			$data = $request->except('_token');
			$this->setting->createOrUpdate($data);
			flash()->success('Success! Setting saved!')->important();
		}catch (\Exception $exception) {
			Log::error($exception->getMessage());
			flash()->error('Error! There is an error saving settings');
		}
		return redirect()->back();
	}

	public function getCoinSetting()
	{
		$coins = Coin::active()->get();
		$coin = $coins->first();
		
		$data = [
			'withdraw_enabled' => $coin->withdraw_enabled,
			'withdraw_fees' => $coin->withdraw_fees,
			'withdraw_min_amount' => $coin->withdraw_min_amount,
			'withdraw_max_amount' => $coin->withdraw_max_amount,
			'deposit_enabled' => $coin->deposit_enabled,
			'deposit_fees' => $coin->deposit_fees,
			'deposit_min_amount' => $coin->deposit_min_amount,
			'deposit_max_amount' => $coin->deposit_max_amount,
			'auto_withdraw_address' => $coin->auto_withdraw_address,
			'auto_withdraw_after' => $coin->auto_withdraw_after
		];

		return view('admin.setting.coin', compact('coins'), $data);
	}

	public function setCoinSetting(Request $request)
	{
		$this->validate($request, [
			'coin' => 'required|exists:coins,id',
			'deposit_status' => 'nullable|in:disable,enable',
  			'deposit_fee' => 'nullable|numeric|min:0',
		  	'min_deposit_amount' => 'nullable|numeric|min:0',
			'max_deposit_amount' => 'nullable|numeric|min:0',
			'withdraw_status' => 'nullable|in:disable,enable',
			'withdraw_fee' => 'nullable|numeric|min:0',
			'min_withdraw_amount' => 'nullable|numeric|min:0',
			'max_withdraw_amount' => 'nullable|numeric|min:0',
			'auto_withdraw_after' => 'nullable|numeric|min:0',
			'auto_withdraw_address' => 'nullable'
		]);

		try {

			$status = ['disable' => 0, 'enable' => 1];
			$coin = Coin::find($request->input('coin'));
			$coin->deposit_enabled = $status[$request->deposit_status];
			$coin->deposit_fees = $request->deposit_fee;
			$coin->deposit_min_amount = $request->min_deposit_amount;
			$coin->deposit_max_amount = $request->max_deposit_amount;

			$coin->withdraw_enabled = $status[$request->withdraw_status];
			$coin->withdraw_fees = $request->withdraw_fee;
			$coin->withdraw_min_amount = $request->min_withdraw_amount;
			$coin->withdraw_max_amount = $request->max_withdraw_amount;
			$coin->auto_withdraw_after = $request->auto_withdraw_after;
			$coin->auto_withdraw_address = $request->auto_withdraw_address;

			$coin->save();
		} catch (\Exception $exception){
			flash()->error('Error! There is an error related to this subject');
			Log::error($exception);
		}
		return redirect()->back();
	}

	public function setReferralSetting(Request $request)
	{
		$this->validate($request, [
			'max_referral_level' => 'required|numeric|max:10',
		]);

		$data = $request->except('_token');

		try {
			$this->setting->createOrUpdate($data);
			flash()->success('Success! Setting saved!')->important();

		}catch (\Exception $exception) {
			Log::error($exception->getMessage());
			flash()->error('Error! There is an error saving settings');
		}

		return redirect()->back();
	}

	public function displayCoinSetting(Coin $coin)
	{
		return json_encode([
			'withdraw_enabled' => $coin->withdraw_enabled,
			'withdraw_fees' => $coin->withdraw_fees,
			'withdraw_min_amount' => $coin->withdraw_min_amount,
			'withdraw_max_amount' => $coin->withdraw_max_amount,
			'deposit_enabled' => $coin->deposit_enabled,
			'deposit_fees' => $coin->deposit_fees,
			'deposit_min_amount' => $coin->deposit_min_amount,
			'deposit_max_amount' => $coin->deposit_max_amount,
			'auto_withdraw_after' => $coin->auto_withdraw_after,
			'auto_withdraw_address' => $coin->auto_withdraw_address
		]);
	}
}
