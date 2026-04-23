@can('create', \App\Models\Award::class)
    <a class="pl-4" href="{{ route('awards.create') }}">
        <button
            class="rounded-md border border-violet-300 py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-black hover:bg-violet-200 hover:border-violet-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            type="button">
            Add a Award
        </button>
    </a>
@endcan


<p class="pl-4 p-2">There are {{ $awards->count() }} Awards(s):</p>
<!-- List the books -->
<ul class="pl-4 pb-2">
    @foreach($awards as $award)
        <li>
            <a class="hover:underline hover:text-violet-400" href="{{ route('awards.show', $award) }}">
                {{ $award->name }}
            </a>
        </li>
    @endforeach
</ul>
