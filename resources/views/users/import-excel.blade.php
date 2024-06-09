@extends('layouts.app')

@section('content')
    @if (session('validation_errors'))
        <div class="alert alert-danger">
            <strong>Errores de validación Importaciones:</strong>
            <ul>
                @foreach (session('validation_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header ">Importar Alumnos y Clases</div>
                    <div class="card-body">
                        <form action="{{route('users.import')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="import_file" name="import_file"
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Importar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
