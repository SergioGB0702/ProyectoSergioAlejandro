@extends('layouts.app')

@section('content')
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    @endif

    <div class="container">

    @if (session('success'))
        <div class="alert alert-success text-center text-white align-middle" style="background-color: #6b7785 !important; border-color: #979fa9 !important;"">
            <h3 class="mb-0">{{ session('success') }}</h3>
        </div>
    @endif
                    
    <div class="card">
            <div class="card-header">Gestión de Profesores y Alumnos</div>
                <div class="card-body">                    
                    <h2 class="mt-2 mb-4">Introduzca los datos generales</h2>
                    <form class="row">
                        <div class="col-12 mb-1">
                            <label for="inputAnoAcademico" class="d-block">Año Academico</label>
                            <div class="col-6">
                                <div class="form-group">
                                    <select id="inputAnoAcademico" class="selectpicker form-control">
                                        <option value="Seleccione una opcion">Seleccione una opcion</option>
                                        @foreach($anoAcademico as $ano)
                                            <option value="{{$ano->id}}">{{$ano->anio_academico}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="inputCurso" class="d-block">Curso</label>
                            <div class="col-6" >
                                <div class="form-group">
                                    <select id="inputCurso" data-live-search="true" class="selectpicker form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="inputUnidad" class="d-block">Unidad</label>
                            <div class="col-6">
                                <div class="form-group">
                                    <select id="inputUnidad" data-live-search="true" class="selectpicker form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
    {{--                    <div class="col-12 align-self-end">--}}
    {{--                        <button type="button" class="btn btn-primary" id="generate">Buscar</button>--}}
    {{--                        <button type="reset" class="btn btn-danger" id="reset">Limpiar</button>--}}
    {{--                    </div>--}}
                    </form>
                <br>
                <h2 class="mt-2 mb-4">Listado de Alumnos</h2>
                <div class="">
                    {{$dataTable->table(['class'=>'w-100 ' ])}}
                </div>
            </div>


                        </div>
                    </div>
    </div>


@endsection
@push('scripts')

{{ $dataTable->scripts() }}

<script type="text/javascript">

    $(document).ready(function() {
        // Deshabilita el campo de búsqueda global de DataTables
        $('div.dataTables_filter input').prop('disabled', true);
    });

    const table = $('#alumnos-table');



            function handleSelectChange(inputSelect, outputSelect, url) {
                let selectedId = inputSelect.val();
                let options = '';

                $.ajax({
                    url: url, // Reemplaza esto con la URL de tu servidor
                    method: 'GET',
                    data: {selectedId: selectedId},
                    success: function (data) {

                        if (!$.isEmptyObject(data)) {
                            options = '<option value="">Seleccione una opcion</option>';
                        }

                        $.each(data, function (key, value) {
                            options += '<option value="' + key + '">' + value + '</option>';

                        });
                        outputSelect.empty().append(options).selectpicker('refresh');
                    }
                });
            }

            $('#inputAnoAcademico').change(function () {

                if ($(this).val() === 'Seleccione una opcion') {
                    $('#inputCurso').empty().selectpicker('refresh');
                    $('#inputUnidad').empty().selectpicker('refresh');

                    $('div.dataTables_filter input').prop('disabled', true);

                } else {
                    handleSelectChange($(this), $('#inputCurso'), "/cursos");
                }

            });

            $('#inputCurso').change(function () {
                console.log($(this).val());
                if ($(this).val() === '0' || $(this).val() === '') {

                    $('#inputUnidad').empty().selectpicker('refresh');

                    $('div.dataTables_filter input').prop('disabled', true);

                } else {

                    $('#inputUnidad').empty().selectpicker('refresh');

                    $('div.dataTables_filter input').prop('disabled', true);

                    handleSelectChange($(this), $('#inputUnidad'), "/unidades");
                }

            });

            // Añade aquí más eventos change para otros elementos select
            // Por ejemplo:
            // $('#otroInputSelect').change(function() {
            //     handleSelectChange($(this), $('#otroOutputSelect'));
            // });




        table.on('preXhr.dt', function (e, settings, data) {

            data.unidad = $('#inputUnidad').val();
            // console.log(data.clase);


        });

        table.on('init.dt', function (e, settings, data) {

            $('div.dataTables_filter input').prop('disabled', true);
            // console.log(data.clase);


        });


        const hamBurger = document.querySelector(".toggle-btn");


        $('.toggle-btn').on('click', function () {
            table.DataTable.adjust();
            document.querySelector("#sidebar").classList.toggle("expand");
            document.querySelector(".main").classList.toggle("expand"); // Añadido

        });
        $('#inputUnidad').change(function () {
            if ($(this).val() === 1 || $(this).val() === '') {
                $('div.dataTables_filter input').prop('disabled', true);
            } else {
                $('div.dataTables_filter input').prop('disabled', false);
            }


            table.DataTable().ajax.reload();
            return false;
        });

        $('#reset').on('click', function () {

            // table.on('preXhr.dt', function (e, settings, data) {
            //     // data.start_date = '';
            //     // data.end_date = '';
            //     // data.clase = '';
            //
            //
            // });
            $('#start_date').val('')
            $('#end_date').val('')
            $('.selectpicker').selectpicker('deselectAll');
            table.DataTable().ajax.reload();
            return false;
        });



</script>

    <script type="module">




    </script>

    <!-- Bootstrap Select CSS -->


@endpush


