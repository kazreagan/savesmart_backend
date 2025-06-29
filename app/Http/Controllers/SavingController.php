<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSavingRequest;
use App\Http\Requests\UpdateSavingRequest;
use App\Repositories\SavingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SavingController extends AppBaseController
{
    /** @var  SavingRepository */
    private $savingRepository;

    public function __construct(SavingRepository $savingRepo)
    {
        $this->savingRepository = $savingRepo;
    }

    /**
     * Display a listing of the Saving.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $savings = $this->savingRepository->all();

        return view('admin.savings.index')
            ->with('savings', $savings);
    }

    /**
     * Show the form for creating a new Saving.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.savings.create');
    }

    /**
     * Store a newly created Saving in storage.
     *
     * @param CreateSavingRequest $request
     *
     * @return Response
     */
    public function store(CreateSavingRequest $request)
    {
        $input = $request->all();

        $saving = $this->savingRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/savings.singular')]));

        return redirect(route('admin.savings.index'));
    }

    /**
     * Display the specified Saving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $saving = $this->savingRepository->find($id);

        if (empty($saving)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savings.singular')]));

            return redirect(route('admin.savings.index'));
        }

        return view('admin.savings.show')->with('saving', $saving);
    }

    /**
     * Show the form for editing the specified Saving.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $saving = $this->savingRepository->find($id);

        if (empty($saving)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savings.singular')]));

            return redirect(route('admin.savings.index'));
        }

        return view('admin.savings.edit')->with('saving', $saving);
    }

    /**
     * Update the specified Saving in storage.
     *
     * @param int $id
     * @param UpdateSavingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSavingRequest $request)
    {
        $saving = $this->savingRepository->find($id);

        if (empty($saving)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savings.singular')]));

            return redirect(route('admin.savings.index'));
        }

        $saving = $this->savingRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/savings.singular')]));

        return redirect(route('admin.savings.index'));
    }

    /**
     * Remove the specified Saving from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $saving = $this->savingRepository->find($id);

        if (empty($saving)) {
            Flash::error(__('messages.not_found', ['model' => __('models/savings.singular')]));

            return redirect(route('admin.savings.index'));
        }

        $this->savingRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/savings.singular')]));

        return redirect(route('admin.savings.index'));
    }
}
