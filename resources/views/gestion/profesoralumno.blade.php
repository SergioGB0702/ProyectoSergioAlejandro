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
                    
    <div class="card mb-4">
        <div class="card-header">Gestión de Profesores y Alumnos</div>
            <!-- Card body alumnos -->
            <div class="card-body">        
                <input id="switchProfeAlumno" onchange="cambiarDiv();" type="checkbox" data-on="Alumnos" data-off="Profesores" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary">            
                <div id="divAlumno">
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
                    {{$dataTable->table(['class'=>'w-100 mb-2' ])}}
                </div>
            </div>
            <div id="divProfesor">
                <h2 class="mt-3 mb-3">Añadir nuevo profesor/a</h2>

                <form class="row" method="post" action="{{route('gestion.negativas.crear')}}">
                    @csrf
                    <div class="col-auto w-75">
                        <label for="nuevaProfesor">Campos del nuevo profesor/a:</label>
                        <div class="row">
                            <input type="text" class="form-control mt-2 col" id="dniProfesor" name="dniProfesor" placeholder="DNI" style="margin-right: 2% !important; margin-left: 2% !important;">
                            <input type="text" class="form-control mt-2 col" id="nombreProfesor" name="nombreProfesor" placeholder="Nombre" style="margin-right: 2% !important; margin-left: 2% !important;">
                            <input type="text" class="form-control mt-2 col" id="telefonoProfesor" name="telefonoProfesor" placeholder="Teléfono" style="margin-right: 2% !important; margin-left: 2% !important;">
                            <input type="email" class="form-control mt-2 col" id="emailProfesor" name="emailProfesor" placeholder="Correo" style="margin-right: 2% !important; margin-left: 2% !important;">
                        </div>
                    </div>
                    <div class="col-auto align-self-end">
                        <button type="submit" class="btn btn-secondary" id="generate">Añadir</button>
                        <button type="reset" class="btn btn-danger text-white" id="reset">Limpiar</button>
                    </div>
                </form>

                <br>

                <h2 class="mt-2 mb-4">Listado de Profesores/as</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 12%" class="text-center">DNI</th>
                            <th scope="col" class="text-center" style="width: 16%">Nombre</th>
                            <th scope="col" class="text-center" style="width: 10%">Teléfono</th>
                            <th scope="col" class="text-center" style="width: 10%">Correo</th>
                            <th scope="col" style="width: 10%" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($profesores as $profesor)
                    <form class="row" method="patch" action="/gestion/conductasnegativas/editar/{{$profesor->id}}">
                        @csrf 
                        <tr class="align-middle">
                            <td><input type="text" class="form-control" id="cambioConducta" name="cambioConducta" value="{{$profesor->dni}}"></td>
                            <td><input type="text" class="form-control" id="cambioConducta" name="cambioConducta" value="{{$profesor->nombre}}"></td>
                            <td><input type="text" class="form-control" id="cambioConducta" name="cambioConducta" value="{{$profesor->telefono}}"></td>
                            <td><input type="text" class="form-control" id="cambioConducta" name="cambioConducta" value="{{$profesor->correo}}"></td>
                            <td class="text-center">
                            <button type="submit" class="btn btn-primary" id="generate">Editar</button>
                    </form>
                            <a class="btn btn-danger text-white sm-mt-2" href="/gestion/conductasnegativas/eliminar/{{$profesor->id}}">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                
                <div class="h-10 grid grid-cols-1 gap-4 content-between">
                {{ $profesores->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAlumno" tabindex="-1" aria-labelledby="modalAlumnoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnoLabel">Formulario</h5>
                </div>
                <div class="modal-body">
                    <form id="formEditarAlumno">
                        <div class="form-group">
                            <label for="text">DNI</label>
                            <input type="text" class="form-control" id="dni" name="text">
                        </div>
                        <div class="form-group">
                            <label for="text">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="text">
                        </div>
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input type="number" class="form-control" id="number" name="number">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <div id="email-fields">
                                <div class="input-group mb-3 email-group">
                                    <input type="email" class="form-control" name="email">
                                    <div class="input-group-append">
                                        <select class="form-control" name="email_type">
                                            <option value="personal">Personal</option>
                                            <option value="tutor">Tutor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="form">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

    @if (isset($paginaProfesor))
    <div id="divPagina" display="none"></div>
    @endif
@endsection
@push('scripts')

{{ $dataTable->scripts() }}
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        // Para controlar si existe página, se crea o no un div oculto con un condicional de su valor
        const divPagina = document.getElementById('divPagina');
        const divProfesor = document.getElementById('divProfesor');
        const divAlumno = document.getElementById('divAlumno');
        const switchProfeAlumno = document.getElementById('switchProfeAlumno');
        if (divPagina != null) {
            divAlumno.style.display = 'none';
            divProfesor.style.display = 'block';
            switchProfeAlumno.checked = true;

        } else {
            divAlumno.style.display = 'block';
            divProfesor.style.display = 'none';
        }
        
        
    });

    function cambiarDiv() {
        const divProfesor = document.getElementById('divProfesor');
        const divAlumno = document.getElementById('divAlumno');
        const checked = document.getElementById('switchProfeAlumno').checked;

        if (checked) {
            divAlumno.style.display = 'block';
            divProfesor.style.display = 'none';
        } else {
            divAlumno.style.display = 'none';
            divProfesor.style.display = 'block';
        }
    }


</script>

    <script type="module">

    const table = $('#alumnos-table');

    $(document).ready(function() {
        // Para controlar si existe página, se crea o no un div oculto con un condicional de su valor
        const divPagina = document.getElementById('divPagina');
        const divProfesor = document.getElementById('divProfesor');
        const divAlumno = document.getElementById('divAlumno');
        const switchProfeAlumno = document.getElementById('switchProfeAlumno');
        const switchToggleProfeAlumno = document.getElementsByClassName('toggle')[0];
        if (divPagina != null) {
            divAlumno.style.display = 'none';
            divProfesor.style.display = 'block';
            switchToggleProfeAlumno.classList.add("off");
            switchProfeAlumno.checked = false;
        } else {
            divAlumno.style.display = 'block';
            divProfesor.style.display = 'none';
        }        
    });

    function cambiarDiv() {
        const divProfesor = document.getElementById('divProfesor');
        const divAlumno = document.getElementById('divAlumno');
        const checked = document.getElementById('switchProfeAlumno').checked;

        if (checked) {
            divAlumno.style.display = 'block';
            divProfesor.style.display = 'none';
        } else {
            divAlumno.style.display = 'none';
            divProfesor.style.display = 'block';
        }
    }

            
    function handleSelectChange(inputSelect, outputSelect, url) {                
        let selectedId = inputSelect.val();               
        let options = '';
            $.ajax({
                url: url,
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

            //$('div.dataTables_filter input').prop('disabled', true);
            } else {
                 handleSelectChange($(this), $('#inputCurso'), "/cursos");
            }

        });

        $('#inputCurso').change(function () {
            console.log($(this).val());
            if ($(this).val() === '0' || $(this).val() === '') {

                $('#inputUnidad').empty().selectpicker('refresh');

                //$('div.dataTables_filter input').prop('disabled', true);

            } else {

                $('#inputUnidad').empty().selectpicker('refresh');

                //$('div.dataTables_filter input').prop('disabled', true);

                handleSelectChange($(this), $('#inputUnidad'), "/unidades");
            }

        });

        table.on('preXhr.dt', function (e, settings, data) {

            data.unidad = $('#inputUnidad').val();
            // console.log(data.clase);


        });

        table.on('init.dt', function (e, settings, data) {

            ///$('div.dataTables_filter input').prop('disabled', true);
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
                //$('div.dataTables_filter input').prop('disabled', true);
            } else {
                //$('div.dataTables_filter input').prop('disabled', false);
            }
            table.DataTable().ajax.reload();
            return false;
        });

        $('#reset').on('click', function () {

            $('#start_date').val('')
            $('#end_date').val('')
            $('.selectpicker').selectpicker('deselectAll');
            table.DataTable().ajax.reload();
            return false;
        });

        $('#alumnos-table').on('click', 'td', function() {
            let data = $('#alumnos-table').DataTable().row(this).data();
            let dni = data.dni;
            let nombre = data.nombre;
            let puntos = data.puntos;
            let correos = data.Correos;
            if (correos == null) {
                alert('DNI: ' + data.dni + '\nNombre: ' + data.nombre + '\nPuntos: ' + data.puntos);
            } else {
                let correosBienFormato = [];
                let datosForm = {
                    "dni" : dni
                }
                $.ajax({
                    url: '/gestion/obtenerCorreos',
                    type: 'GET',
                    data: datosForm,
                    dataType: 'json',
                    success: function(datos) {
                        for (let i = 0; i < datos.length; i++) {
                            correosBienFormato[i] = datos[i];
                        }
                        var emailGroup = $('.email-group').first().clone();
                        emailGroup.find('input').val('');
                        emailGroup.find('.add-email').removeClass('add-email').addClass('remove-email').text('Eliminar');
                        $('#email-fields').append(emailGroup);
                        $("#modalAlumno").modal("show");
                    },
                    error: function( error) {
                        
                    }
                });
            }
    });

    $(document).on('click', '.remove-email', function() {
            $(this).closest('.email-group').remove();
        });

    </script>


@endpush


