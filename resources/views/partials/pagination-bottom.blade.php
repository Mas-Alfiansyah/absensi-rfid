<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="d-flex align-items-center gap-2">
        <span class="text-muted">Tampilkan:</span>
        <form method="GET" class="d-inline-block">
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto; min-width: 80px;">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>
        <span class="text-muted">data per halaman</span>
    </div>

    <div>
        {{ $data->appends(request()->query())->links() }}
    </div>
</div>
