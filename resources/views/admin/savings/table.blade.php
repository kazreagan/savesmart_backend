<div class="table-responsive">
    <table class="table" id="savings-table">
        <thead>
            <tr>
                <th>@lang('Name')</th>
        <th>@lang('Target_amount')</th>
        <th>@lang('Current_amount')</th>
        <th>@lang('Target_date')</th>
        <th>@lang('Description')</th>
        <th>@lang('User_id')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($savings as $saving)
            <tr>
                       <td>{{ $saving->name }}</td>
            <td>{{ $saving->target_amount }}</td>
            <td>{{ $saving->current_amount }}</td>
            <td>{{ $saving->target_date }}</td>
            <td>{{ $saving->description }}</td>
            <td>{{ $saving->user_id }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.savings.destroy', $saving->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('admin.savings.show', [$saving->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('admin.savings.edit', [$saving->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
