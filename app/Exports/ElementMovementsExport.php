<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
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
        $actor = Auth::user()->name . ' ' . Auth::user()->last_name;

        return $this->data->map(fn($row) => [
            // 1) Fecha de movimiento
            Carbon::parse($row->date)->format('Y-m-d H:i'),

            // 2) Tipo original
            $row->type,

            // 3) Categoría: Elemento (Prestamo|Compra) o Producto
            in_array($row->type, ['Prestamo','Compra'])
                ? 'Elemento'
                : 'Producto',

            // 4) Nombre del ítem
            $row->element_name,

            // 5) Encargado (quien exporta)
            $actor,

            // 6) Destinatario (instructor/proveedor) o No aplica
            $row->instructor_name
                ? $row->instructor_name
                : 'No aplica',

            // 7) Cantidad (+ “m” si es tela G-01)
            (in_array($row->type, ['Prestamo','Compra'])
             && isset($row->element_type_id)
             && $row->element_type_id >= 1100
             && $row->element_type_id < 2000)
                ? $row->amount . ' metro/s'
                : ((int) $row->amount) . ' unidad/es',

            // 8) Movimiento: ya contiene “Prestado/a”, “Devuelto/a” o “Para consumo”
            $row->movement_type,

            // 9) Devuelto:
            //    → solo para G-03 (element_type_id 3100–3999): Devuelto/a o NO
            //    → resto: No aplica
            (isset($row->element_type_id)
             && $row->type === 'Prestamo'
             && $row->element_type_id >= 3100
             && $row->element_type_id < 4000)
                ? ($row->return_date ? 'Devuelto/a' : 'NO')
                : 'No aplica',
        ]);
    }

    public function headings(): array
    {
        return [
            'Fecha de movimiento',
            'Tipo',
            'Categoría',
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
