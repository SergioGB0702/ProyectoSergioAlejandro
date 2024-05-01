<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('updated_at', function ($user) {
                return $user->updated_at->format('d/m/Y H:i:s');
            });
    }

    public function query(User $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $clase = $this->request()->get('clase');

        $query =  $model->newQuery();

        if (!empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);

            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if (!empty($clase)) {
            $query->where('clase', $clase);
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
                'defaultContent' => view('action_menu')->render(),
                'data' => 'action',
                'name' => 'action',
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
//            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('clase'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_'.date('YmdHis');
    }
}
