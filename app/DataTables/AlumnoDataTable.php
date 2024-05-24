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

class AlumnoDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('dni')
            ->rawColumns(['nombre'])
            ->editColumn('created_at', function ($user) {
                return $user->updated_at->format('d/m/Y');
            })
            ->filterColumn('nombred', function($query, $keyword) {
                $query->whereRaw("alumnos.nombre like ?", ["%{$keyword}%"]);
            });
    }

    public function query(Alumno $model): QueryBuilder
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

        ->leftJoin('unidades', 'unidades.id', '=', 'alumnos.id_unidad')
        ->leftJoin('cursos', 'unidades.id_curso', '=', 'cursos.id') 
        ->leftJoin('anio_academico', 'cursos.id_anio_academico', '=', 'anio_academico.id')
        ->select('unidades.*', 'alumnos.*', DB::raw('CONCAT("<ul><li>", GROUP_CONCAT(correos.correo SEPARATOR "</li><li>"), "</li></ul>") as Correos'));

        SELECT unidades.*, alumnos.*
from alumnos
LEFT JOIN unidades on unidades.id = alumnos.id_unidad
LEFT JOIN cursos on cursos.id = unidades.id_curso
LEFT JOIN anios_academicos on anios_academicos.id = cursos.id_anio_academico

        $prueba = DB::execute($query);
        echo $prueba;
        if (!empty($unidad)) {

            $query->where('alumnos.id_unidad', '=', $unidad);
        }

        return $query;


    }

    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('alumnos-table')
            ->columns($this->getColumns())
            ->minifiedAjax()

            ->orderBy(0)
            ->scrollX(true)
            ->language(['url' => '/js/spanish.json'])

            ->parameters([

            ])
            ->addColumn([
                'defaultContent' => view('action_menu')->render(),
                'data' => 'action',
                'name' => 'action',
                'className' => 'align-middle', // 'align-middle
                'title' => 'Acciones',
                'orderable' => false,
                'searchable' => false,

            ])
            ->buttons([
                Button::make('excel')->titleAttr('Exportar a Excel'),
                Button::make('csv')->titleAttr('Exportar a CSV'),
                Button::make('pdf')->titleAttr('Exportar a PDF'),
                Button::make('print')->titleAttr('Imprimir'),
                Button::make('reset')->titleAttr('Restablecer'),
                Button::make('reload')->titleAttr('recargar'),
            ]);

    }

    public function getColumns(): array
    {
        return [
            Column::make('dni')->title('DNI')->data('alumnos.dni')->className('align-middle'),
            Column::make('nombre')->name('alumnos.nombre')->title('Nombre')->data('alumnos.nombre')->className('align-middle'),
            Column::make('puntos')->title('Puntos')->data('puntos')->data('alumnos.puntos')->className('align-middle')->searchable(false),
            Column::make('correo')->title('Correos')->className('align-middle')->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Users_'.date('YmdHis');
    }
}
