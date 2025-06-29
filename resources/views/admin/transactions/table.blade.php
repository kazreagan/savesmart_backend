<div class="table-responsive">
    <table class="table" id="transactions-table">
        <thead>
            <tr>
                <th>@lang('user_id')</th>
        <th>@lang('amount')</th>
        <th>@lang('description')</th>
                <th colspan="3">@lang('action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                       <td>{{ $transaction->user_id }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->description }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('admin.transactions.show', [$transaction->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('admin.transactions.edit', [$transaction->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
