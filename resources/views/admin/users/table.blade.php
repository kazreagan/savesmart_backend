<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>@lang('name')</th>
        <th>@lang('password')</th>
        <th>@lang('phone_number')</th>
        <th>@lang('role')</th>
                <th colspan="3">@lang('action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                       <td>{{ $user->name }}</td>
            <td>{{ $user->password }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ $user->role }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.users.destroy', $user->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('admin.users.show', [$user->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('admin.users.edit', [$user->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
