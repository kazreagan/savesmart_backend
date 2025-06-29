<?php

namespace App\Repositories;

use App\Models\Analytics;
use App\Repositories\BaseRepository;

/**
 * Class AnalyticsRepository
 * @package App\Repositories
 * @version May 2, 2025, 2:46 pm UTC
*/

class AnalyticsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return Analytics::class;
    }
}
