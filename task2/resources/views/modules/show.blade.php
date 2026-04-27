<h2>{{ $module->name }}</h2>

<!-- Edit and delete links -->
<ul>
    @can('update', $module)
        <li><a href="{{ route('modules.edit', $module) }}">Edit</a></li>
    @endcan
    @can('delete', $module)
        <li>
            <form method="POST" action="{{ route('modules.destroy', $module) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete">
            </form>
        </li>
    @endcan
</ul>

<h3>Assignments:</h3>
<ul>
    @foreach($module->assignments as $assignment)
        @php $mark = $assignment->marks->firstWhere('user_id', auth()->id()); @endphp
        <li>{{ $assignment->name }} grade: {{ $mark ? $mark->mark : 'Ungraded' }}</li>
    @endforeach
</ul>
