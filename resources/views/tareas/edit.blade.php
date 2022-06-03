@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="showTarea">
                <div class="card-header">
                    <h3 class="card-title"> {{ __('Modificar tarea') }} </h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tareas.update',$tarea->id) }}">
                        @method('PUT')
                        @csrf

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($tarea->nombre) ? $tarea->nombre : old('nombre')}}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-end">{{ __('Descripcion') }}</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ isset($tarea->descripcion) ? $tarea->descripcion : old('descripcion')}}" required autocomplete="descripcion">

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="usuariosA" class="col-md-4 col-form-label text-md-end">{{ __('Usuarios asignados') }}</label>

                            <div class="col-md-6">
                                <select name="usuariosA[]" id="usuariosA" class="form-control" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" @foreach ($tarea->users as $users) {{$user->name == $users->name ? 'selected' : ''}} @endforeach>{{$user->name}}</option>
                                    @endforeach

                                </select>

                                @error('usuariosA')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fechainicio" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de inicio') }}</label>

                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" name="fechainicio" required autocomplete="fechainicio" value="{{ isset($tarea->fechainicio) ? $tarea->fechainicio : old('fechainicio')}}" onchange="minfechafin(this)">

                                @error('fechainicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fechavencimiento" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de vencimiento') }}</label>

                            <div class="col-md-6">
                                <input id="fechavencimiento" type="date" min="" class="form-control @error('fechavencimiento') is-invalid @enderror" name="fechavencimiento" required autocomplete="fechavencimiento" value="{{ isset($tarea->fechavencimiento) ? $tarea->fechavencimiento : old('fechavencimiento')}}">

                                @error('fechavencimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn" style="width: 50%">
                                    {{ __('Editar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10){
  dd='0'+dd
}
if(mm<10){
  mm='0'+mm
}

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("fechainicio").setAttribute("min", today);
document.getElementById("fechavencimiento").setAttribute("min", "{{$tarea->fechainicio}}");

function minfechafin(val){
    document.getElementById("fechavencimiento").setAttribute("min", val.value);
}

</script>
@endsection
