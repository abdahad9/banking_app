<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function showDepositForm()
    {
        return view('deposit');
    }


    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $amount = $request->input('amount');
        $user = Auth::user();

        $user->balance += $amount;
        $user->save();

        Transaction::recordTransaction( $user, 'credit', 'Deposit', $amount, $user->balance);

        return redirect()->route('deposit')->with('success', 'Deposit successful!');
    }

    public function showWithdrawForm()
    {
        return view('withdraw');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', Rule::notIn([0])],
        ]);

        $amount = $request->input('amount');
        $user = Auth::user();

        if ($user->balance < $amount) {
            return redirect()->route('withdraw')->with('error', 'Insufficient funds.');
        }

        $user->balance -= $amount;
        $user->save();


        Transaction::recordTransaction( $user, 'debit', 'Withdraw', $amount, $user->balance);

        return redirect()->route('withdraw')->with('success', 'Withdrawal successful!');
    }

    public function showTransferForm()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('transfer', ['users' => $users]);
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'recipient' => ['required', 'exists:users,id', Rule::notIn([Auth::id()])],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $recipientId = $request->input('recipient');
        $amount = $request->input('amount');
        $sender = Auth::user();
        $recipient = User::findOrFail($recipientId);

        if ($sender->balance < $amount) {
            return redirect()->route('transfer')->with('error', 'Insufficient funds.');
        }

        $sender->balance -= $amount;
        $recipient->balance += $amount;

        $sender->save();
        $recipient->save();

        Transaction::recordTransaction($sender, 'debit', 'Transfer to ' . $recipient->name, $amount, $sender->balance);
        Transaction::recordTransaction($recipient, 'credit', 'Transfer from ' . $sender->name, $amount, $recipient->balance);

        return redirect()->route('transfer')->with('success', 'Transfer successful!');
    }

    public function showStatement()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->orderBy('datetime', 'desc')->get();

        return view('statement', ['transactions' => $transactions]);
    }
}
