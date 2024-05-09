@extends('layouts.app')

@section('content')
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="card">
            <div class="card-header">Incidencia</div>
            <div class="card-body">

                <form class="row" action="{{route('parte.create')}}" method="post">
                    @csrf
                    <div class="col-12 mb-1">
                        <label for="inputFecha" class="d-block">Fecha:</label>
                        <div class="col-6">
                            <div class="form-group">

                                <input name="inputFecha" type="date" id="inputFecha" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-1">
                        <label for="inputProfesor" class="d-block">Profesional que registra el incidente:</label>
                        <div class="col-6">
                            <div class="form-group">
                                <select  data-live-search="true" name="inputProfesor" id="inputProfesor"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{$profesor->dni}}">{{$profesor->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputProfesor')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputTramoHorario" class="d-block">Tramo Horario: </label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputTramoHorario" id="inputTramoHorario" data-live-search="true"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($tramos as $tramo)
                                        <option value="{{$tramo->id}}">{{$tramo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputTramoHorario')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputCurso" class="d-block">Curso: </label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputCurso" id="inputCurso" data-live-search="true"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{$curso->id}}">{{$curso->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputCurso')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputUnidad" class="d-block">Unidad: </label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputUnidad" id="inputUnidad" data-live-search="true"
                                        class="selectpicker form-control">

                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputUnidad')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputAlumno" class="d-block">Alumno Implicados: </label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputAlumno" id="inputAlumno" data-live-search="true"
                                        class="selectpicker form-control">

                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputAlumno')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputIncidencia" class="d-block">Incidencia: </label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputIncidencia" id="inputIncidencia" data-live-search="true"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($incidencias as $incidencia)
                                        <option value="{{$incidencia->id}}">{{$incidencia->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputIncidencia')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputConductasNegativa" class="d-block">Conductas Negativas</label>
                        <div class="col-6">
                            <div class="form-group">

                                <select multiple data-actions-box="true" name="inputConductasNegativa[]" id="inputConductasNegativa" data-live-search="true"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($conductasNegativas as $conductaNegativa)
                                        <option value="{{$conductaNegativa->id}}">{{$conductaNegativa->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputConductasNegativa')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputCorrecionesAplicadas" class="d-block">Correciones Aplicadas</label>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="inputCorrecionesAplicadas" id="inputCorrecionesAplicadas" data-live-search="true"
                                        class="selectpicker form-control">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach($correcionesAplicadas as $correcionesAplicada)
                                        <option value="{{$correcionesAplicada->id}}">{{$correcionesAplicada->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('inputCorrecionesAplicadas')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <label for="inputDescripcionDetallada" class="d-block">Descripcion Detallada</label>
                        <div class="col-6">
                            <div class="form-group">
                                <textarea name="inputDescripcionDetallada" class="form-control"
                                          id="inputDescripcionDetallada"></textarea>
                            </div>
                        </div>
                    </div>
                    @error('inputDescripcionDetallada')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="col-12 mb-1">
                        <div class="col-6">
                            <div class="form-group">
                                <button class="btn btn-success text-white">Crear</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

<script type="module">

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/translations/es.js"></script>
<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', (event) => {
        let fechaActual = new Date();

        // Formatea la fecha en el formato correcto (yyyy-mm-dd)
        let dia = String(fechaActual.getDate()).padStart(2, '0');
        let mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses en JavaScript comienzan desde 0
        let ano = fechaActual.getFullYear();

        let fechaFormateada = ano + '-' + mes + '-' + dia;

        // Establece la fecha formateada en el campo de entrada de fecha
        document.getElementById('inputFecha').value = fechaFormateada;



        ClassicEditor
            .create(document.querySelector('#inputDescripcionDetallada'), {
                language: 'es',
                extraPlugins: [MyCustomUploadAdapterPlugin],
            })
            .catch(error => {
                console.error(error);
            });

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        const data = new FormData();
                        data.append('upload', file);

                        axios.post('/upload', data)
                            .then(response => {
                                resolve({default: response.data.url});
                            })
                            .catch(error => {
                                reject('Upload failed');
                                console.error(error);
                            });
                    }));
            }

            abort() {
            }
        }



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


        $('#inputCurso').change(function () {
            // console.log($(this).val());

            handleSelectChange($(this), $('#inputUnidad'), "/unidades");


        });

        $('#inputUnidad').change(function () {
            // console.log($(this).val());

            handleSelectChange($(this), $('#inputAlumno'), "/alumnos");


        });

    });




</script>



