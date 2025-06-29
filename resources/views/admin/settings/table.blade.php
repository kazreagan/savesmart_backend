<div class="table-responsive">
    <table class="table" id="settings-table">
        <thead>
            <tr>
                <th>@lang('Key')</th>
        <th>@lang('Value')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($settings as $settings)
            <tr>
                       <td>{{ $settings->key }}</td>
            <td>{{ $settings->value }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.settings.destroy', $settings->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('settings.show', [$settings->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('settings.edit', [$settings->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
