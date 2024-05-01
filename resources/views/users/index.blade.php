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

                    <div class="card">
                        <div class="card-header">Manage Users</div>
                        <div class="card-body">

                                <h2 class="mt-3 mb-3">Busqueda</h2>

                                <form class="row">
                                    <div class="col-auto">
                                        <label for="inputUsername">Start date</label>
                                        <input type="datetime-local" class="form-control" id="start_date" placeholder="Username">
                                    </div>
                                    <div class="col-3">
                                        <label for="inputPassword">End Date</label>
                                        <input type="datetime-local" class="form-control" id="end_date" placeholder="Password">
                                    </div>
{{--                                    <div class="col-4 ">--}}
{{--                                        <label for="inputPassword">Clase</label>--}}
{{--                                        <select data-placeholder="Seleccione una clase"  id="clase" multiple>--}}
{{--                                            <option ></option>--}}
{{--                                            <option value="Introducción a la Programación">Introducción a la Programación</option>--}}
{{--                                            <option value="Desarrollo Web con HTML, CSS y JavaScript">Desarrollo Web con HTML, CSS y JavaScript</option>--}}
{{--                                            <option value="Algoritmos y Estructuras de Datos">Algoritmos y Estructuras de Datos</option>--}}
{{--                                            <option value="Inteligencia Artificial">Inteligencia Artificial</option>--}}
{{--                                            <option value="Diseño de Interfaces de Usuario">Diseño de Interfaces de Usuario</option>--}}
{{--                                            <option value="Desarrollo de Aplicaciones Móviles">Desarrollo de Aplicaciones Móviles</option>--}}
{{--                                            <option value="Bases de Datos y SQL">Bases de Datos y SQL</option>--}}
{{--                                            <option value="Machine Learning">Machine Learning</option>--}}
{{--                                            <option value="Redes Neuronales">Redes Neuronales</option>--}}
{{--                                            <option value="Seguridad Informática">Seguridad Informática</option>--}}
{{--                                        </select>--}}

{{--                                    </div>--}}
                                    <select class="selectpicker " data-selected-text-format="count > 0" multiple data-live-search="true" data-actions-box="true">
                                        <option data-tokens="Algoritmos y Estructuras de Datos">Algoritmos y Estructuras de Datos</option>
                                        <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                        <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                                    </select>


                                    {{--                                    <div class="col-4 ">--}}
{{--                                        <label for="inputPassword">Clase</label>--}}
{{--                                        <select class="selectpicker">--}}
{{--                                            <option>Mustard</option>--}}
{{--                                            <option>Ketchup</option>--}}
{{--                                            <option>Barbecue</option>--}}
{{--                                        </select>--}}

{{--                                    </div>--}}


                                    <div class="col-auto align-self-end">
                                        <button type="button" class="btn btn-primary" id="generate">Buscar</button>
                                        <button type="reset" class="btn btn-danger" id="reset">Limpiar</button>
                                    </div>

                                </form>


                            <br>
                            <div class="" >
                            {{$dataTable->table(['class'=>'w-100 ' ])}}
                            </div>


                        </div>
                    </div>
                </div>





@endsection

@push('scripts')

    {{ $dataTable->scripts() }}




    <script type="text/javascript">

    </script>





    <script type="module">

        $(document).ready(function() {
            $('.bootstrap-select button:first').removeClass().addClass('form-select').css('padding-left', '9px');
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-coreui-theme') {
                        if ($('html').attr('data-coreui-theme') === 'dark') {
                            $('.bootstrap-select button:eq(1), .bootstrap-select button:eq(2)').removeClass('btn-light').addClass('btn-dark');
                        } else {
                            $('.bootstrap-select button:eq(1), .bootstrap-select button:eq(2)').removeClass('btn-dark').addClass('btn-light');
                        }
                    }
                });
            });

            observer.observe(document.documentElement, { attributes: true });

            if ($('html').attr('data-coreui-theme') === 'dark') {
                $('.bootstrap-select button:eq(1), .bootstrap-select button:eq(2)').removeClass('btn-light').addClass('btn-dark');
            } else {
                $('.bootstrap-select button:eq(1), .bootstrap-select button:eq(2)').removeClass('btn-dark').addClass('btn-light');
            }
        });
        const table = $('#users-table');

        table.on('preXhr.dt', function (e, settings, data) {
            data.start_date = $('#start_date').val();
            data.end_date = $('#end_date').val();
            data.clase = $('.selectpicker').val();
            console.log(data.clase);


        });


        const hamBurger = document.querySelector(".toggle-btn");


        $('.toggle-btn').on('click', function () {
            table.DataTable.adjust();
            document.querySelector("#sidebar").classList.toggle("expand");
            document.querySelector(".main").classList.toggle("expand"); // Añadido

        });
        $('#generate').on('click', function () {

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

        // $('#clase').on('change', function () {
        //     table.DataTable().ajax.reload();
        // });
        $('#buttone').on('click', function () {

            if ($(window).width() >= 992) {
                $('.dataTables_scrollHeadInner').attr('style', 'width: 100% !important;');
            }

        });


    </script>

    <!-- Bootstrap Select CSS -->


@endpush


