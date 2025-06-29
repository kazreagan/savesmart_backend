<?php

namespace App\Repositories;

use App\Models\SavingGoal;
use Illuminate\Database\Eloquent\Builder;

class SavingGoalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'is_completed'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SavingGoal::class;
    }
    
    /**
     * Get query for the model
     */
    public function query(): Builder
    {
        return $this->model->newQuery()->with('user');
    }
    
    /**
     * Get saving goals by user ID
     * 
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->orderBy('deadline', 'asc')
            ->get();
    }
    
    /**
     * Get active saving goals (not completed)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive()
    {
        return $this->model->where('is_completed', false)
            ->orderBy('deadline', 'asc')
            ->get();
    }
    
    /**
     * Get completed saving goals
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCompleted()
    {
        return $this->model->where('is_completed', true)
            ->orderBy('deadline', 'desc')
            ->get();
    }
    
    /**
     * Get expired saving goals (deadline passed but not completed)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getExpired()
    {
        return $this->model->where('is_completed', false)
            ->where('deadline', '<', now())
            ->orderBy('deadline', 'desc')
            ->get();
    }
    
    /**
     * Get saving goals that are close to deadline (within next 7 days)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getClosingDeadlines()
    {
        $sevenDaysLater = now()->addDays(7);
        
        return $this->model->where('is_completed', false)
            ->where('deadline', '>=', now())
            ->where('deadline', '<=', $sevenDaysLater)
            ->orderBy('deadline', 'asc')
            ->get();
    }
    
    /**
     * Get saving goals close to completion (90% or more)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNearlyComplete()
    {
        return $this->model->whereRaw('current_amount >= (target_amount * 0.9)')
            ->where('current_amount', '<', \DB::raw('target_amount'))
            ->where('is_completed', false)
            ->orderBy('deadline', 'asc')
            ->get();
    }
}