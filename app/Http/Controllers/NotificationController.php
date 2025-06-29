<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the Notifications.
     *
     * @return Response
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);

        return view('admin.notifications.index')
            ->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        
        return view('admin.notifications.create')->with('users', $users);
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        // Check if this is a broadcast notification (send to all users)
        if (isset($input['send_to_all']) && $input['send_to_all']) {
            // For broadcast notifications, user_id should be null
            $input['user_id'] = null;
            $input['is_broadcast'] = true;
        } else {
            // Validate that user_id is provided for non-broadcast notifications
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);
            $input['is_broadcast'] = false;
        }
        
        // Now validate the rest of the fields
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
        ]);
        
        // Set default values
        $input['is_read'] = false;
        
        $notification = Notification::create($input);
        
        Flash::success('Notification created successfully.');
        
        return redirect(route('admin.notifications.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = Notification::find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('admin.notifications.index'));
        }

        return view('admin.notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = Notification::find($id);
        $users = User::pluck('name', 'id');

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('admin.notifications.index'));
        }

        return view('notifications.edit')
            ->with('notification', $notification)
            ->with('users', $users);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $notification = Notification::find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('admin.notifications.index'));
        }

        $input = $request->all();
        
        // Check if this is a broadcast notification (send to all users)
        if (isset($input['send_to_all']) && $input['send_to_all']) {
            // For broadcast notifications, user_id should be null
            $input['user_id'] = null;
            $input['is_broadcast'] = true;
        } else {
            // Validate that user_id is provided for non-broadcast notifications
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);
            $input['is_broadcast'] = false;
        }
        
        // Now validate the rest of the fields
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
        ]);

        $notification->update($input);

        Flash::success('Notification updated successfully.');

        return redirect(route('admin.notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('admin.notifications.index'));
        }

        $notification->delete();

        Flash::success('Notification deleted successfully.');

        return redirect(route('admin.notifications.index'));
    }
}