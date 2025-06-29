<?php

namespace App\Repositories;

use App\Models\Saving;
use App\Repositories\BaseRepository;

/**
 * Class SavingRepository
 * @package App\Repositories
 * @version May 2, 2025, 2:38 pm UTC
*/

class SavingRepository extends BaseRepository
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
        return Saving::class;
    }
}
