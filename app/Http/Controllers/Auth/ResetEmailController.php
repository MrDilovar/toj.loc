<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Mail\ResetEmail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use Str;
use Mail;

class ResetEmailController extends Controller
{
    private $table = 'email_resets';

    private $token;
    private $email;
    private $new_email;

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|string|email|max:255']);

        $this->email = Auth::user()->email;
        $this->new_email = $request->email;

        if ($this->new_email === $this->email) return redirect()->back();

        $request->validate(['email' => 'unique:users']);

        $this->sendResetEmailLink();

        return redirect()->back()->with('success', "На почту $this->new_email было отправлено письмо для подтверждения нового e-mail.");
    }

    public function reset($token)
    {
        $this->token = $token;

        if ($this->token_is_unique() && !$this->is_expired()
            && !is_null($this->get_user()) && $this->email_is_unique()) {
            $user = User::find($this->get_user()->id);

            $user->update(['email'=> $this->get_record()->new_email]);

            $this->remove_record();

            Auth::login($user);

            return redirect()->route('store.profile.show')->with('success', "Ваш адрес электронной почты был успешно изменен на $user->email");
        }

        return 'Токен не действителен...';
    }

    private function token_is_unique()
    {
        return $this->get_table()->where('token', $this->token)->count() === 1;
    }

    private function email_is_unique()
    {
        return DB::table('users')
                ->where('email', $this->get_record()->new_email)
                ->count() === 0;
    }

    private function is_expired()
    {
        return Carbon::now()->diffInMinutes(Carbon::create($this->get_record()->created_at))
            > config('auth.passwords.users.expire');
    }

    private function get_record()
    {
        return $this->get_table()->where('token', $this->token)->first();
    }

    private function get_user()
    {
        return DB::table('users')->where('email', $this->get_record()->email)->first();
    }

    private function sendResetEmailLink()
    {
        $this->token = $this->get_token();

        if ($this->exist_email()) $this->update_record();
        else $this->create_record();

        Mail::to($this->new_email)->send(new ResetEmail($this->token));
    }

    private function exist_email()
    {
        return $this->get_table()->where('email', $this->email)->exists();
    }

    private function get_table()
    {
        return DB::table($this->table);
    }

    private function get_token($length = 64)
    {
        return Str::random($length);
    }

    private function update_record() {
        $this->get_table()->where('email', $this->email)->update([
            'token'=>$this->token,
            'created_at'=>Carbon::now()
        ]);
    }

    private function create_record() {
        $this->get_table()->insert([
            'email' => $this->email,
            'new_email' => $this->new_email,
            'token' => $this->token,
            'created_at' => Carbon::now()
        ]);
    }

    private function remove_record()
    {
        $this->get_table()->where('email', $this->get_record()->email)->delete();
    }
}
