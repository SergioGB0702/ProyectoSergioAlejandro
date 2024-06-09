<?php

namespace App\Imports;

use App\Models\Alumno;
use App\Models\AnioAcademico;
use App\Models\Unidad;
use App\Models\Curso;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Comprobar si la fila está vacía
        if (!array_filter($row)) {
            return null;
        }

        // Validar los datos
        $validator = Validator::make($row, [
            'dni' => 'required|unique:alumnos,dni',
            'nombre' => 'required',
            'nombre_curso' => 'required',
            'nombre_unidad' => 'required',
        ]);

        if ($validator->fails()) {
            // Almacena los errores de validación en la sesión
            session()->flash('validation_errors', $validator->errors()->all());
            return null;
        }

        // Crear o encontrar el curso
        $anoacademico = AnioAcademico::firstOrCreate(['anio_academico' => '2023-2024']);

        $curso = Curso::firstOrCreate(['nombre' => $row['nombre_curso'], 'id_anio_academico' => $anoacademico->id]);

        // Crear o encontrar la unidad
        $unidad = Unidad::firstOrCreate(['nombre' => $row['nombre_unidad'], 'id_curso' => $curso->id]);

        // Crear el alumno
        return new Alumno([
            'dni' => $row['dni'],
            'nombre' => $row['nombre'],
            'puntos' => 12,
            'id_unidad' => $unidad->id,
        ]);
    }
}
