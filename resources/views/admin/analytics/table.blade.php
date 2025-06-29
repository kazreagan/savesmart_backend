<div class="table-responsive">
    <table class="table" id="analytics-table">
        <thead>
            <tr>
                <th>@lang('User_id')</th>
        <th>@lang('Total_savings')</th>
        <th>@lang('Last_activity')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($analytics as $analytics)
            <tr>
                       <td>{{ $analytics->User_id }}</td>
            <td>{{ $analytics->Total_savings }}</td>
            <td>{{ $analytics->Last_activity }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.analytics.destroy', $analytics->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('analytics.show', [$analytics->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('analytics.edit', [$analytics->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
                               {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm("'.__('Are_you_sure').'")']) !!}
                           </div>
                           {!! Form::close() !!}
                       </td>
                   </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
