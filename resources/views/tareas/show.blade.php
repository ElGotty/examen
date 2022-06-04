@extends('layouts.app')

@section('content')

<div class="container" >
    <div class=" row justify-content-center">
        <div class="col-md-8">
            <div class="showTarea">
                <div class="card-header">
                    <h3 class="card-title"> Tarea: {{$tarea->nombre }} </h3>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <strong >Descripcion: </strong>
                            {{$tarea->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong for="">Fecha de inicio: </strong>
                            {{$tarea->fechainicio }}
                        </div>
                        <div class="form-group">
                            <strong for="">Fecha limite: </strong>
                            {{$tarea->fechavencimiento }}
                        </div>
                        <div class="form-group">
                            <strong for="">Usarios asignados: </strong><p>
                            @foreach ($tarea->users as $users )
                                <p>{{$users->name}}</p>
                            @endforeach
                        </div>
                        <div class="rowbtn">
                            <a class="btninrowleft" href="{{ route('tareas.edit', $tarea->id) }}" >Editar</a>
                            <form action="{{ route('tareas.destroy',  $tarea) }}" class="formEliminar" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border-color: #e3342f;" class="btninrowrightDelete" onclick="eliminar()"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>

    function eliminar(){
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault()
            event.stopPropagation()
            Swal.fire({
                title: 'Eliminar Registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();

                }
            })
        }, false)
        })
    }
</script>
@endsection


