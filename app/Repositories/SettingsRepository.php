<?php

namespace App\Repositories;

use App\Models\Settings;
use App\Repositories\BaseRepository;

/**
 * Class SettingsRepository
 * @package App\Repositories
 * @version May 2, 2025, 2:47 pm UTC
*/

class SettingsRepository extends BaseRepository
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
        return Settings::class;
    }
}
