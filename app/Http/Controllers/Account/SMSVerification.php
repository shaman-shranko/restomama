<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;
use Nexmo\Verify\Verification;
use Carbon\Carbon;

class SMSVerification extends Controller
{
    public function verifiedNotice(){
        return view ('account.verified_phone');
    }

    public static function sendVerificationCode(int $id = null){

        if(isset(auth()->user()->last_verification_attempt_at)){

        }

        $basic  = new Basic('67526b2d', 'kIOfDexWNIfKh7YC');
        $client = new Client($basic);

        $verification = $client->verify()->start([
            'number' => auth()->user()->phone,
            'brand'  => 'Рестомама',
            'code_length'  => '4',
            'lg' => 'ru-ru',
            ]);

        auth()->user()->verification_id = $verification->getRequestId();
        auth()->user()->last_verification_attempt_at = Carbon::now()->toDateTimeString();
        auth()->user()->save();
    }

    public function checkVerification(Request $request){
        $request->validate([
            'code' => 'string|min:4|max:4',
        ]);

        $basic  = new Basic('67526b2d', 'kIOfDexWNIfKh7YC');
        $client = new Client($basic);

        $data = array();

        try{
            $request_id = auth()->user()->verification_id;
            $verification = new Verification($request_id);
            $result = $client->verify()->check($verification, $request->code);

            if($result->reasonPhrase == "OK"){
                auth()->user()->phone_verification_at = Carbon::now()->toDateTimeString();
                auth()->user()->save();
            }
        }catch(\Exception $exception){
            $code = $exception->getCode();
            switch($code){
                case 6:
                    $data['error'] = 'Действие кода закончилось';
                    break;
                case 16:
                    $data['error'] = 'Неверный код';
                    break;
                case 17:
                    $data['error'] = 'Слишком много попыток ввода неправильного кода';
                    break;
                default:
                    $data['error'] = 'Возникла ошибка, попробуйте позже либо обратитесь в поддержку сервиса';
                    break;
            }
        }
        if(isset($data['error'])){
            return view('account.verified_phone', $data);
        }else{
            return redirect()->route('account');
        }
    }
}
