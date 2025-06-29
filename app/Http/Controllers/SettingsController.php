<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Repositories\SettingsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SettingsController extends AppBaseController
{
    /** @var  SettingsRepository */
    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->settingsRepository = $settingsRepo;
    }

    /**
     * Display a listing of the Settings.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $settings = $this->settingsRepository->all();

        return view('admin.settings.index')
            ->with('settings', $settings);
    }

    /**
     * Show the form for creating a new Settings.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created Settings in storage.
     *
     * @param CreateSettingsRequest $request
     *
     * @return Response
     */
    public function store(CreateSettingsRequest $request)
    {
        $input = $request->all();

        $settings = $this->settingsRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/settings.singular')]));

        return redirect(route('admin.settings.index'));
    }

    /**
     * Display the specified Settings.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $settings = $this->settingsRepository->find($id);

        if (empty($settings)) {
            Flash::error(__('messages.not_found', ['model' => __('models/settings.singular')]));

            return redirect(route('admin.settings.index'));
        }

        return view('admin.settings.show')->with('settings', $settings);
    }

    /**
     * Show the form for editing the specified Settings.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $settings = $this->settingsRepository->find($id);

        if (empty($settings)) {
            Flash::error(__('messages.not_found', ['model' => __('models/settings.singular')]));

            return redirect(route('admin.settings.index'));
        }

        return view('admin.settings.edit')->with('settings', $settings);
    }

    /**
     * Update the specified Settings in storage.
     *
     * @param int $id
     * @param UpdateSettingsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingsRequest $request)
    {
        $settings = $this->settingsRepository->find($id);

        if (empty($settings)) {
            Flash::error(__('messages.not_found', ['model' => __('models/settings.singular')]));

            return redirect(route('admin.settings.index'));
        }

        $settings = $this->settingsRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/settings.singular')]));

        return redirect(route('admin.settings.index'));
    }

    /**
     * Remove the specified Settings from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $settings = $this->settingsRepository->find($id);

        if (empty($settings)) {
            Flash::error(__('messages.not_found', ['model' => __('models/settings.singular')]));

            return redirect(route('admin.settings.index'));
        }

        $this->settingsRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/settings.singular')]));

        return redirect(route('admin.settings.index'));
    }
}
