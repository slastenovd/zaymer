<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\user;
use App\transactions;
use DB;
use Carbon\Carbon;

class Task2Controller extends Controller
{
    
    public function index(){
        $users = DB::select('SELECT users.id, name, balance, text FROM users LEFT JOIN (SELECT * FROM comments ORDER BY id DESC) comments ON users.id = comments.user_id GROUP BY users.id');
        $transactions = DB::select('select transact_date, sender.name sender, recipient.name recipient, amount from transactions left join users sender on transactions.sender_id = sender.id left join users recipient on transactions.recipient_id = recipient.id order by transact_date desc');
        return view('Task2.index',['users' => $users, 'transactions' => $transactions]); 
    }
    
    public function transfer(Request $request){
        // 
        $sender    =  user::where('id',$request->input('sender_id'))->first();
        $recipient =  user::where('id',$request->input('recipient_id'))->first();
        
        $error_msg = "";
        if ( ! count($sender)) {
            $error_msg .= "Некорректно указан отправитель. ";
        }

        if ( ! count($recipient)) {
            $error_msg .= "Некорректно указан получатель. ";
        }

        if ( $request->input('sender_id') > 0 and $request->input('recipient_id') > 0 and $request->input('recipient_id') == $request->input('sender_id') ) {
            $error_msg .= "Поучатель и отправитель совпадают. ";
        }

        if ( (float)$request->input('amount') <= 0 ) {
            $error_msg .= "Введена некорректная сумма. ";
        }

        if( strlen($error_msg) == 0 and $sender->balance < $request->input('amount') ) {
            $error_msg .= "Недостаточно средств у отправителя. ";
        }
        
        $success_msg = "";
        
        if( strlen($error_msg) == 0 ) {
            user::where('id', $sender->id)->update(['balance' => $sender->balance - $request->input('amount')]);
            user::where('id', $recipient->id)->update(['balance' => $recipient->balance + $request->input('amount')]);
            DB::insert('insert into transactions (sender_id, recipient_id, amount, transact_date) values (?, ?, ?, ?)', [$sender->id, $recipient->id, $request->input('amount'), Carbon::now()]);
            $success_msg = "Перевод выполнен успешно";
        }

        $users = DB::select('SELECT users.id, name, balance, text FROM users LEFT JOIN (SELECT * FROM comments ORDER BY id DESC) comments ON users.id = comments.user_id GROUP BY users.id');
        $transactions = DB::select('select transact_date, sender.name sender, recipient.name recipient, amount from transactions left join users sender on transactions.sender_id = sender.id left join users recipient on transactions.recipient_id = recipient.id order by transact_date desc');
        return view('Task2.index',['users' => $users, 'transactions' => $transactions, 'error_msg' => $error_msg, 'success_msg' => $success_msg]); 
    }
    
}
