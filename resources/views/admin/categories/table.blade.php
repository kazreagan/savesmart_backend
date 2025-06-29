<div class="table-responsive">
    <table class="table" id="categories-table">
        <thead>
            <tr>
                <th>@lang('Name')</th>
        <th>@lang('Description')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                       <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
                       <td class=" text-center">
                           {!! Form::open(['route' => ['admin.categories.destroy', $category->id], 'method' => 'delete']) !!}
                           <div class='btn-group'>
                               <a href="{!! route('admin.categories.show', [$category->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>
                               <a href="{!! route('admin.categories.edit', [$category->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>
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
