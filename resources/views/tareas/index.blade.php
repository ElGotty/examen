@extends('layouts.app')

@section('content')

    @if(count($tareas) > 0)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2" >
                <div class="showTarea">
                    <a class="btnheader" style="border-radius: 5%" href="{{route('tareas.create')}}" ><i class="fa fa-pencil-square-o fa-2x"  aria-hidden="true"></i> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($tareas as $tarea)


        <div class="card">
            <div class="card-header">
            <h1>{{$tarea->nombre}}</h1>
            </div>
            <div class="card-body">
            <p>
                {{$tarea->descripcion}}
            </p>
            <div class="rowbtn">
                <a href="{{route('tareas.show',$tarea->id)}}" class="btninrowleft">Mostrar</a>
                <form action="{{ route('tareas.update',$tarea->id) }}" class="formfinalizar" method="POST" >
                    <input type="hidden" value = "1" name="terminar">
                    @csrf
                    @method('PUT')
                    <button type="submit" style="border-color: #2fa360;" class="btninrowright" onclick="finalizar()"><i class="fa fa-check" aria-hidden="true"></i></button>
                </form>

            </div>

            </div>
        </div>
        @endforeach


    </div>
    @else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="showTarea">
                    <div class="card-header">
                        <h3 class="card-title"> {{ __('No hay tareas registradas') }} </h3>
                    </div>
                    <a class="btnheader" href="{{route('tareas.create')}}" ><i class="fa fa-pencil-square-o fa-2x"  aria-hidden="true"></i> </a>
                </div>
            </div>
        </div>
    </div>
    @endif


@endsection
@section('script')
<script>

    function finalizar(){
        var forms = document.querySelectorAll('.formfinalizar')
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault()
            event.stopPropagation()
            Swal.fire({
                title: 'Finalizar tarea?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2fa360',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Finalizar',
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
