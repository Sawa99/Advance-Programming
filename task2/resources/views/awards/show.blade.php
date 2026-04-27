<h2>{{ $award->name }}</h2>

<!-- Edit and delete links -->
<ul>
    @can('update', $award)
        <li><a href="{{ route('awards.edit', $award) }}">Edit</a></li>
    @endcan
    @can('delete', $award)
        <li>
            <form method="POST" action="{{ route('awards.destroy', $award) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete">
            </form>
        </li>
    @endcan
</ul>

<h3>Modules:</h3>
<ul>
    @foreach($award->modules as $module)
        <li>{{ $module->name }}</li>
    @endforeach
</ul>
