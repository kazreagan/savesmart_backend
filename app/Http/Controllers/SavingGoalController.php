<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSavingGoalRequest;
use App\Http\Requests\UpdateSavingGoalRequest;
use App\Repositories\SavingGoalRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Response;

class SavingGoalController extends AppBaseController
{
    /** @var  SavingGoalRepository */
    private $savingGoalRepository;

    public function __construct(SavingGoalRepository $savingGoalRepo)
    {
        $this->savingGoalRepository = $savingGoalRepo;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the SavingGoal.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = $this->savingGoalRepository->query();
        
        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'active') {
                $query->where('is_completed', false);
            }
        }
        
        // Sort by deadline by default
        $savingGoals = $query->orderBy('deadline', 'asc')->paginate(10);
        
        return view('admin.saving_goals.index')
            ->with('savingGoals', $savingGoals);
    }

    /**
     * Show the form for creating a new SavingGoal.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin.saving_goals.create')->with('users', $users);
    }

    /**
     * Store a newly created SavingGoal in storage.
     *
     * @param CreateSavingGoalRequest $request
     *
     * @return Response
     */
    public function store(CreateSavingGoalRequest $request)
    {
        $input = $request->all();
        
        // Set current_amount to 0 if not provided
        if (!isset($input['current_amount'])) {
            $input['current_amount'] = 0;
        }
        
        // Set is_completed based on amounts
        if ($input['current_amount'] >= $input['target_amount']) {
            $input['is_completed'] = true;
        } else {
            $input['is_completed'] = false;
        }

        $savingGoal = $this->savingGoalRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/savingGoals.singular')]));

        return redirect(route('admin.savingGoals.index'));
    }

    /**
     * Display the specified SavingGoal.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $savingGoal = $this->savingGoalRepository->find($id);

        if (empty($savingGoal)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savingGoals.singular')]));

            return redirect(route('admin.savingGoals.index'));
        }

        return view('admin.saving_goals.show')->with('savingGoal', $savingGoal);
    }

    /**
     * Show the form for editing the specified SavingGoal.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $savingGoal = $this->savingGoalRepository->find($id);

        if (empty($savingGoal)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savingGoals.singular')]));

            return redirect(route('admin.savingGoals.index'));
        }

        $users = User::pluck('name', 'id');
        return view('admin.saving_goals.edit')
            ->with('savingGoal', $savingGoal)
            ->with('users', $users);
    }

    /**
     * Update the specified SavingGoal in storage.
     *
     * @param int $id
     * @param UpdateSavingGoalRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSavingGoalRequest $request)
    {
        $savingGoal = $this->savingGoalRepository->find($id);

        if (empty($savingGoal)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savingGoals.singular')]));

            return redirect(route('admin.savingGoals.index'));
        }

        $input = $request->all();
        
        // Set is_completed based on amounts
        if ($input['current_amount'] >= $input['target_amount']) {
            $input['is_completed'] = true;
        } else {
            $input['is_completed'] = isset($input['is_completed']) ? (bool)$input['is_completed'] : false;
        }

        $savingGoal = $this->savingGoalRepository->update($input, $id);

        Flash::success(__('messages.updated', ['model' => __('models/savingGoals.singular')]));

        return redirect(route('admin.savingGoals.index'));
    }

    /**
     * Remove the specified SavingGoal from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $savingGoal = $this->savingGoalRepository->find($id);

        if (empty($savingGoal)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savingGoals.singular')]));

            return redirect(route('admin.savingGoals.index'));
        }

        $this->savingGoalRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/savingGoals.singular')]));

        return redirect(route('admin.savingGoals.index'));
    }
    
    /**
     * Mark a saving goal as completed
     *
     * @param int $id
     *
     * @return Response
     */
    public function markCompleted($id)
    {
        $savingGoal = $this->savingGoalRepository->find($id);

        if (empty($savingGoal)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savingGoals.singular')]));
            return redirect(route('admin.savingGoals.index'));
        }

        $savingGoal = $this->savingGoalRepository->update(['is_completed' => true], $id);

        Flash::success(__('Goal marked as completed'));

        return redirect(route('admin.savingGoals.index'));
    }
}