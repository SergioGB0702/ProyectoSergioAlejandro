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
                        <div class="card-header">Gestión de Incidencias</div>
                        <div class="card-body">

                                <h2 class="mt-3 mb-3">Añadir nueva Incidencia</h2>

                                <form class="row" method="post" action="{{route('gestion.incidencias.crear')}}">
                                    @csrf
                                    <div class="col-auto w-75">
                                        <label for="nuevaIncidencia">Descripción de la incidencia a añadir:</label>
                                        <input type="text" class="form-control mt-2" id="nuevaIncidencia" name="nuevaIncidencia" placeholder="Descripción incidencia">
                                    </div>
                                    <div class="col-auto align-self-end">
                                        <button type="submit" class="btn btn-secondary" id="generate">Añadir</button>
                                        <button type="reset" class="btn btn-danger text-white" id="reset">Limpiar</button>
                                    </div>
                                </form>

                            <br>

                            <h2 class="mt-2 mb-4">Listado de incidencias</h2>
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" style="width: 8%" class="text-center">#</th>
                                        <th scope="col" class="text-center">Descripción</th>
                                        <th scope="col" style="width: 17%" class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($incidencias as $incidencia)
                                <form class="row" method="patch" action="/gestion/incidencias/editar/{{$incidencia->id}}">
                                    @csrf 
                                    <tr class="align-middle">
                                        <th class="text-center">{{$incidencia->id}}</th>
                                        <td><input type="text" class="form-control" id="cambioIncidencia" name="cambioIncidencia" value="{{$incidencia->descripcion}}"></td>
                                        <td class="text-center">
                                        <button type="submit" class="btn btn-primary" id="generate">Editar</button>
                                </form>
                                <a class="btn btn-warning text-black sm-mt-2" href="/gestion/incidencias/habilitar/{{$incidencia->id}}">Deshabilitar</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="h-10 grid grid-cols-1 gap-4 content-between">
                                {{ $incidencias->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            <div class="">
                            
                            </div>


                        </div>
                    </div>
                </div>
                
@endsection
@push('scripts')

    <script type="text/javascript">

    </script>

    <script type="module">

        


    </script>

    <!-- Bootstrap Select CSS -->


@endpush


