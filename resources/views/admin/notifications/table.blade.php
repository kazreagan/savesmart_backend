<div class="table-responsive">
    <table class="table" id="notifications-table">
        <thead>
            <tr>
                <th>@lang('user_id')</th>
        <th>@lang('message')</th>
                <th colspan="3">@lang('action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notifications as $notification)
            <tr>
                       <td>{{ $notification->user_id }}</td>
            <td>{{ $notification->message }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.notifications.destroy', $notification->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('admin.notifications.show', [$notification->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('admin.notifications.edit', [$notification->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
                               {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm("'.__('are_you_sure').'")']) !!}
                           </div>
                           {!! Form::close() !!}
                       </td>
                   </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
