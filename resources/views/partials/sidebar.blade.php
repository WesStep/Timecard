<div class="col-md-2 bg-secondary">
    <h3 class="mt-4 text-white">Archives</h3>
    <hr style="border-top: 1px solid #17a2b8">
    @foreach($archives as $date)
        <a href="{{ route('dashboard/archive', ['month' => $date['month'], 'year' => $date['year']]) }}" class="text-white">{{ $date['month'] . " " . $date['year'] }}</a><br>
    @endforeach
</div>