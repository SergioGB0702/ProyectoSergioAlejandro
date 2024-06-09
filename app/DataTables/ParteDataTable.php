<?php

namespace App\DataTables;

use App\Models\Alumno;
use App\Models\Parte;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class ParteDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->rawColumns(['descripcion_conducta_negativa', 'action'])
//            ->editColumn('created_at', function ($user) {
//                return $user->created_at->format('d/m/Y H:i:s');
//            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->filterColumn('nombre', function ($query, $keyword) {
                $query->whereRaw("alumnos.nombre like ?", ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($row) {
                return view('action_menu', ['id' => $row->id])->render();
            });


//          ->editColumn('created_at', function ($user) {
//          return $user->updated_at->format('d/m/Y H:i:s');
//          });
//            ->addColumn('profesors.dni', function ($user) {
//                return $user->partes->implode('dni',', ');
//            })
//            ->addColumn('parte.colectivo', function ($user) {
//                return $user->partes->pluck('colectivo')->implode(', ');
//            })


    }

    public function query(Parte $model): QueryBuilder
    {
        $unidad = $this->request()->get('unidad');
        $searchTerm = $this->request()->get('search')['value'] ?? null;

        if (empty($unidad)) {
            return $model->query()->whereRaw('1 = 0');
        }
        if (!empty($searchTerm)) {
            // Aquí puedes ajustar tu consulta para la búsqueda global
        }


        $query = $model->newQuery()
            ->leftJoin('alumno_partes', 'partes.id', '=', 'alumno_partes.parte_id')
            ->leftJoin('alumnos', 'alumno_partes.alumno_dni', '=', 'alumnos.dni')
            ->leftJoin('parte_incidencias', 'partes.id', '=', 'parte_incidencias.parte_id')
            ->leftJoin('incidencias', 'parte_incidencias.incidencia_id', '=', 'incidencias.id')
            ->leftJoin('parte_conductanegativas', 'partes.id', '=', 'parte_conductanegativas.parte_id')
            ->leftJoin('conductanegativas', 'parte_conductanegativas.conductanegativas_id', '=', 'conductanegativas.id')
            ->select(

                'partes.*',
                'alumnos.*',
                'incidencias.descripcion',
                DB::raw(' CONCAT("<ul><li>", GROUP_CONCAT(DISTINCT conductanegativas.descripcion SEPARATOR "</li><li>"), "</li></ul>") as descripcion_conducta_negativa')
            )
            ->groupBy('partes.id');


        if (!empty($unidad)) {

            $query->where('alumnos.id_unidad', '=', $unidad);
        }

        return $query;


    }

    public function html(): \Yajra\DataTables\Html\Builder
    {

        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->scrollX(true)
            ->language(['url' => 'js/spanish.json'])
            ->parameters([

            ])
            ->addColumn([

                'data' => 'action',
                'name' => 'action',
                'className' => 'align-middle', // 'align-middle
                'title' => 'Acciones',
                'orderable' => false,
                'searchable' => false,

            ])

            ->buttons([
                Button::make()->text('<span> Crear</span>')->className('btn btn-success text-white')->titleAttr('Crear nuevo parte')->attr([
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#exampleModal',
                    'title' => 'Crear nuevo parte',
                    'type' => 'button',
                    'id' => 'btnCrearParte',
                    'onclick' => 'crearParte()',

                ]),
                Button::make('excel')->titleAttr('Exportar a Excel'),
                Button::make('csv')->titleAttr('Exportar a CSV'),
                Button::make('print')->titleAttr('Imprimir'),
                Button::make('reset')->titleAttr('Restablecer'),
                Button::make('reload')->titleAttr('recargar'),
            ]);

    }

    public function getColumns(): array
    {
        return [
//            Column::make('id'),
            Column::make('created_at')->title('Fecha')->className('align-middle text-center'),
            Column::make('nombre')->name('alumnos.nombre')->title('Nombre')->className('align-middle text-center'),
            Column::make('colectivo')->title('¿Colectivo?')->data('colectivo')->className('align-middle text-center')->searchable(false),
            Column::make('descripcion')->title('Descripcion')->data('descripcion')->className('align-middle text-center')->searchable(false),
            Column::make('descripcion_conducta_negativa')->title('Conducta Negativa')->data('descripcion_conducta_negativa')->className('align-middle text-center')->searchable(false),
            Column::make('puntos_penalizados')->className('align-middle text-center')->searchable(false),
//            Column::make('descripcion')->title('descripcion')->data('descripcion_conducta')->className('align-middle'),

//            Column::make('parte.colectivo')->title('Colectivo')->data('parte.colectivo')->className('align-middle'),
            // Column::make('dni')->title('dni')->data('profesors.dni')->className('align-middle'),

        ];
    }

    protected function filename(): string
    {
        return 'Partes_' . date('YmdHis');
    }
}
