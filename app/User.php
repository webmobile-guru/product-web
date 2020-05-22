<?php

namespace App;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'email', 'password', 'referred_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relation Section
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function verification()
    {
        return $this->hasMany(Verification::class, 'user_id');
    }

    public function trade()
    {
        return $this->hasMany(Trade::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function coinTransaction()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    public function withdraw()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function depositAddress()
    {
        return $this->hasMany(DepositAddress::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
	
	
    public function referralCount()
    {
        return User::where('referred_by',$this->id)->count();
    }

    public function kyc()
    {
        return $this->hasMany(KycDocument::class, 'user_id');
    }

    /**
     * Scope Section
     */
    public function ScopeExceptMe($query)
    {
        return $query->where('id', '!=', auth()->id());
    }

    /**
     * Mutator Section
     */
    public function getFullNameAttribute()
    {
        return implode(
            ' ',
            array_filter(
                [
                    $this->first_name,
                    $this->middle_name,
                    $this->last_name,
                ],
                function($item) {

                    return ! empty($item);

                }
            )
        );
    }

    /**
     * This method will calculate the profile completion percentage
     * and return it to calee
     */
    public function getProfileCompletionPercentage()
    {
        $emailVerified = $this->verification()->type('email')->approved()->exists();
        $mobileVerified = $this->verification()->type('mobile')->approved()->exists();
        $kycVerified = $this->verification()->type('kyc')->approved()->exists();
        $tradeOnce = $this->trade()->closed()->exists();

        $percentageTotal = 0;

        $percentageTotal += $emailVerified?30:0;
        $percentageTotal += $mobileVerified?30:0;
        $percentageTotal += $kycVerified?30:0;
        $percentageTotal += $tradeOnce?10:0;

        return $percentageTotal;
    }

    /**
     * Support method section
     */

    public function isAdmin()
    {
        return ($this->profile->role == 'admin');
    }

    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }

    public function getDepositAmountOfTheDay($coin)
    {
        return $this->transaction()->whereHas('coin', function($query) use ($coin){
            $query->where('coins.coin', $coin);
        })->where('transactions.created_at', '>=', Carbon::now()->subDays(1))
            ->where('transactions.type', 'Credit')
            ->sum('amount');
    }

    public function getBalance($coin)
    {
        $result = 0;

        $coin_id = Coin::where('coin', $coin)->pluck('id')->first();

        if($coin) {
            $result = DB::select('CALL sp_get_balance(?, ?)', [$this->id, $coin_id]);

            return ($result[0]->balance)?$result[0]->balance:0;
        }

        return $result;
    }

    public function balanceOnOrder($coin)
    {
        $credit = $this->transaction()->whereHas('coin', function($query) use ($coin){
            $query->where('coins.coin', $coin);
        })->whereHas('trade', function($query){
            $query->ongoing();
        })->whereIn('source', ['buy', 'sell'])
            ->sum('amount');

        return doubleval($credit);
    }

    public function totalBalance($coin)
    {
        return ($this->getBalance($coin) + $this->balanceOnOrder($coin));
    }
	
	public function totalBalanceInUsd($coin)
    {
		$price = PriceQuote::where('symbol',$coin)->where('status',1)->pluck('price')->first();
		if($price){
			return ($price*$this->totalBalance($coin));
		}
		return 0;
    }

    public function getOpenOrders($pair)
    {
        return $this->trade()->whereHas('coinPair', function($q) use ($pair){
           $q->where('pair_name', $pair);
        })->ongoing()->latest()->take(200)->get();
    }

    /**
     * Get the level of given user in my referral list
     * It takes 2 parameters first is object of User class
     * and second is to check within specified level or all levels
     * @param User $user
     * @param $strict = true/false
     *
     * @return level of member or null
     */
    public function getLevelOf($sponsor, $search, $strict = false, $level = 0)
    {
        $refLimit = Setting::where('key', 'max_referral_level')
            ->pluck('value')
            ->first();

        if(!$sponsor || ($strict &&  ($level > $refLimit))) {
            return null;
        }

        if($search == $sponsor) {
            return $level;
        }

        return $this->getLevelOf($sponsor->sponsor, $search, $strict, ++$level);
    }

    public function payback()
    {
        return $this->hasMany(Payback::class, 'user_id');
    }

    public function randomfloat($st_num=0,$end_num=1,$mul=1000000){
        if ($st_num>$end_num) return false;
        return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
    }

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user) {
            $user->profile()->delete();
            $user->trade()->delete();
            $user->transaction()->delete();
            $user->coinTransaction()->delete();
            $user->withdraw()->delete();
            $user->depositAddress()->delete();
            $user->payment()->delete();
            $user->news()->delete();
        });
    }
    
    /** * Send the password reset notification. * 
     * * @param string $token 
     * * @return void */ 
    public function sendPasswordResetNotification($token) { 
		Mail::to($this->email)->queue(new ResetPassword($token));
    }
    
    public function dochTransactions()
    {
        return $this->hasMany(DochTransaction::class,'user_id');
    }
}
