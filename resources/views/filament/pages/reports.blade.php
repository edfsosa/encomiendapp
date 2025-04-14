<x-filament-panels::page>
    <div class="flex justify-end mb-4">
        <form action="{{ route('export.shipments') }}" method="GET">
            <input type="hidden" name="customer_id" value="{{ request('tableFilters')['customer_id'] ?? '' }}">
            <input type="hidden" name="from" value="{{ request('tableFilters')['Fecha']['from'] ?? '' }}">
            <input type="hidden" name="until" value="{{ request('tableFilters')['Fecha']['until'] ?? '' }}">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded hover:bg-primary-500">
                Exportar a Excel
            </button>
        </form>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
