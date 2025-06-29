<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Models\SavingGoal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the Transaction.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();

        return view('admin.transactions.index')
            ->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new Transaction.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $goals = SavingGoal::where('user_id', $user->id)->pluck('name', 'id');
        $transactionTypes = [
            'income' => 'Income',
            'expense' => 'Expense',
            'withdrawal' => 'Withdrawal',
            'deposit' => 'Deposit',
            'transfer' => 'Transfer',
            'savings' => 'Savings'
        ];

        return view('admin.transactions.create')
            ->with('goals', $goals)
            ->with('transactionTypes', $transactionTypes);
    }

    /**
     * Store a newly created Transaction in storage.
     *
     * @param CreateTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        $transaction = Transaction::create($input);

        Flash::success(__('messages.saved', ['model' => __('transactions')]));

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Display the specified Transaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (empty($transaction) || $transaction->user_id != Auth::id()) {
            Flash::error(__('messages.not_found', ['model' => __('transactions')]));

            return redirect(route('admin.transactions.index'));
        }

        return view('admin.transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified Transaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);

        if (empty($transaction) || $transaction->user_id != Auth::id()) {
            Flash::error(__('messages.not_found', ['model' => __('transactions')]));

            return redirect(route('admin.transactions.index'));
        }

        $user = Auth::user();
        $goals = SavingGoal::where('user_id', $user->id)->pluck('name', 'id');
        $transactionTypes = [
            'income' => 'Income',
            'expense' => 'Expense',
            'withdrawal' => 'Withdrawal',
            'deposit' => 'Deposit',
            'transfer' => 'Transfer',
            'savings' => 'Savings'
        ];

        return view('transactions.edit')
            ->with('transaction', $transaction)
            ->with('goals', $goals)
            ->with('transactionTypes', $transactionTypes);
    }

    /**
     * Update the specified Transaction in storage.
     *
     * @param int $id
     * @param UpdateTransactionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionRequest $request)
    {
        $transaction = Transaction::find($id);

        if (empty($transaction) || $transaction->user_id != Auth::id()) {
            Flash::error(__('messages.not_found', ['model' => __('transactions')]));

            return redirect(route('admin.transactions.index'));
        }

        $transaction->update($request->all());

        Flash::success(__('messages.updated', ['model' => __('transactions')]));

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (empty($transaction) || $transaction->user_id != Auth::id()) {
            Flash::error(__('messages.not_found', ['model' => __('transactions')]));

            return redirect(route('admin.transactions.index'));
        }

        $transaction->delete();

        Flash::success(__('messages.deleted', ['model' => __('transactions')]));

        return redirect(route('admin.transactions.index'));
    }

    /**
     * API methods for the Flutter frontend
     */

    /**
     * Create a new saving transaction from API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSave(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|integer|exists:saving_goals,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->goal_id = $request->goal_id;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->transaction_type = 'savings';
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Savings transaction created successfully',
            'transaction' => $transaction
        ]);
    }

    /**
     * Create a new withdrawal transaction from API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiWithdraw(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|integer|exists:saving_goals,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->goal_id = $request->goal_id;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->transaction_type = 'withdrawal';
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal transaction created successfully',
            'transaction' => $transaction
        ]);
    }

    /**
     * Create a new transfer transaction from API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiTransfer(Request $request)
    {
        $request->validate([
            'from_goal_id' => 'required|integer|exists:saving_goals,id',
            'to_goal_id' => 'required|integer|exists:saving_goals,id|different:from_goal_id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        // Create withdrawal transaction from source goal
        $withdrawalTransaction = new Transaction();
        $withdrawalTransaction->user_id = Auth::id();
        $withdrawalTransaction->goal_id = $request->from_goal_id;
        $withdrawalTransaction->amount = $request->amount;
        $withdrawalTransaction->description = $request->description ?? 'Transfer to another goal';
        $withdrawalTransaction->transaction_type = 'withdrawal';
        $withdrawalTransaction->save();

        // Create deposit transaction to target goal
        $depositTransaction = new Transaction();
        $depositTransaction->user_id = Auth::id();
        $depositTransaction->goal_id = $request->to_goal_id;
        $depositTransaction->amount = $request->amount;
        $depositTransaction->description = $request->description ?? 'Transfer from another goal';
        $depositTransaction->transaction_type = 'deposit';
        $depositTransaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Transfer completed successfully',
            'withdrawal' => $withdrawalTransaction,
            'deposit' => $depositTransaction
        ]);
    }

    /**
     * Get user transactions by type
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiGetTransactions(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());
        
        if ($request->has('type') && !empty($request->type)) {
            $query->where('transaction_type', $request->type);
        }
        
        if ($request->has('goal_id') && !empty($request->goal_id)) {
            $query->where('goal_id', $request->goal_id);
        }
        
        $transactions = $query->with('savingGoal')->latest()->get();
        
        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }
}