<div class="table-responsive">
    <table class="table" id="savingGoals-table">
        <thead>
            <tr>
                <th>@lang('user_id')</th>
        <th>@lang('target_amount')</th>
        <th>@lang('deadline')</th>
        <th>@lang('is_completed')</th>
                <th colspan="3">@lang('action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($savingGoals as $savingGoal)
            <tr>
                       <td>{{ $savingGoal->user_id }}</td>
            <td>{{ $savingGoal->target_amount }}</td>
            <td>{{ $savingGoal->deadline }}</td>
            <td>{{ $savingGoal->is_completed }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['savingGoals.destroy', $savingGoal->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('savingGoals.show', [$savingGoal->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('savingGoals.edit', [$savingGoal->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
