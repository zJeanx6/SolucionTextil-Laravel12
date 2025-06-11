<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ElementMovementsExport implements FromCollection, WithHeadings, Responsable
{
    public string $fileName = 'movimientos.xlsx';
    protected Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(fn($row) => [
            // Fecha
            Carbon::parse($row->date)->format('Y-m-d H:i'),
            // Tipo
            $row->type,
            // Elemento
            $row->element_name,
            // Encargado
            $row->user_name ?? 'No aplica',
            // Destinatario
            $row->instructor_name ?? 'No aplica',
            // Cantidad
            (in_array($row->type, ['Prestamo','Compra'])
                && isset($row->element_type_id)
                && $row->element_type_id >= 1100
                && $row->element_type_id < 2000)
                ? $row->amount.' metro/s'
                : intval($row->amount).' unidad/es',
            // Movimiento
            $row->movement_type,
            // Devuelto: solo G-03 herramientas
            (
                $row->type === 'Prestamo'
                && isset($row->element_type_id)
                && $row->element_type_id >= 3100
                && $row->element_type_id < 4000
            )
                ? (
                    $row->return_date
                    ? Carbon::parse($row->return_date)->format('Y-m-d H:i')
                    : 'No'
                  )
                : 'No aplica',
        ]);
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Tipo',
            'Elemento',
            'Encargado',
            'Destinatario',
            'Cantidad',
            'Movimiento',
            'Devuelto',
        ];
    }

    public function toResponse($request)
    {
        return Excel::download($this, $this->fileName);
    }
}
