<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\MailingList;
use Illuminate\Http\Request;

use Mail;
use DB;
use Carbon\Carbon;
use App\Mail\DeleteMailFromMailingList;
use App\Mail\MailingListCreate;

class MailingListController extends Controller
{

    public function sendMailStore(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:180|unique:mailing_list'
        ]);
        $token = str_random(64);
        $email = $request->email;
        $data = [
            'url' => url('/mailing_list/subscribe/' . $token)
        ];
        // send token to mail
        Mail::to($email)->send(new MailingListCreate($data));
        // Mail::to($email)->send(new MailingListCreate(['url' => 'http://localhost:8080/mailing_list/subscribe/' . $token]));

        // save token in database
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $message = 'تم إرسال رسالة تأكيد الإشتراك إلى بريدك الإليكترونى.';
        return response(['status' => true, 'message' => $message]);
    }


    public function store(Request $request)
    {
        $token = $request->token;
        if ($token != null) {
            $check_token = DB::table('password_resets')->where('token', $token)->first();
            if ($check_token != null) {
                if ($check_token->created_at > Carbon::now()->subHours(1)) {
                    MailingList::create(['email' => $check_token->email]);
                    DB::table('password_resets')->where('token', $token)->delete();
                    return redirect('/')->with(['type_message' => 'success', 'message_session_mailing_list' => 'أنت الان مشترك فى خدمة القائمة البريدية.']);
                } else {
                    return redirect('/')->with(['type_message' => 'error', 'message_session_mailing_list' => 'من فضلك أرسل طلب تأكيد الإشتراك مرة أخرى.']);
                }
            } else {
                return redirect('/')->with(['type_message' => 'error', 'message_session_mailing_list' => 'رمز تأكيد الإشتراك غير صحيح.']);
            }
        } else {
            return redirect('/');
        }
    }





    public function sendMailDelete(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:mailing_list'
        ]);
        $token = str_random(64);
        $email = $request->email;
        $data = [
            'url' => url('/mailing_list/unsubscribe/' . $token)
        ];
        // send token to mail
        Mail::to($email)->send(new DeleteMailFromMailingList($data));
        // Mail::to($email)->send(new DeleteMailFromMailingList(['url' => 'http://localhost:8080/mailing_list/unsubscribe/' . $token]));

        // save token in database
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $message = 'تم إرسال رسالة إلغاء الإشتراك إلى بريدك الإليكترونى.';
        return response(['status' => true, 'message' => $message]);
    }



    public function destroy(Request $request)
    {
        $token = $request->token;
        if ($token != null) {
            $check_token = DB::table('password_resets')->where('token', $token)->first();
            if ($check_token != null) {
                if ($check_token->created_at > Carbon::now()->subHours(1)) {
                    MailingList::where('email', $check_token->email)->delete();
                    DB::table('password_resets')->where('token', $token)->delete();
                    return redirect('/')->with(['type_message' => 'success', 'message_session_mailing_list' => 'تم إلغاء اشتراكك فى خدمة القائمة البريدية.']);
                } else {
                    return redirect('/')->with(['type_message' => 'error', 'message_session_mailing_list' => 'من فضلك أرسل طلب إلغاء الإشتراك مرة أخرى.']);
                }
            } else {
                return redirect('/')->with(['type_message' => 'error', 'message_session_mailing_list' => 'رمز الإلغاء غير صحيح.']);
            }
        } else {
            return redirect('/');
        }
    }
}
