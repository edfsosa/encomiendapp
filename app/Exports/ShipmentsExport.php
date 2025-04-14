<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShipmentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Shipment::with('customer', 'driver');

        if (!empty($this->filters['customer_id'])) {
            $query->where('customer_id', $this->filters['customer_id']);
        }

        if (!empty($this->filters['from'])) {
            $query->whereDate('shipment_date', '>=', $this->filters['from']);
        }

        if (!empty($this->filters['until'])) {
            $query->whereDate('shipment_date', '<=', $this->filters['until']);
        }

        return $query->get();
    }

    public function map($s): array
    {
        return [
            $s->shipment_date,
            $s->tracking_number,
            $s->customer->name,
            $s->driver->name ?? '-',
            $s->totalItems(),
            number_format($s->totalCost(), 0, ',', '.') . ' Gs',
        ];
    }

    public function headings(): array
    {
        return ['Fecha', 'Tracking', 'Cliente', 'Transportista', 'Total Ítems', 'Total Costo'];
    }
}
