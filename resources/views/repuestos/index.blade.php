@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Repuestos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">


                        @can('crear-repuesto')
                        <a class="btn btn-warning" href="{{ route('repuestos.create') }}">Nuevo</a>
                        @endcan

                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">nombre</th>
                                <th style="color:#fff;">Imagen</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($repuestos as $repuesto)
                                <tr>
                                    <td style="display: none;">{{ $repuesto->id }}</td>

                                    <td>
                                        {{ $repuesto->nombre }}
                                    </td>

                                    <td>
                                        {{-- <img src="/imagen/{{$repuesto->imagen}}" width="60%"> --}}
                                        <center>
                                            <img class="w-28 h-28" src="/imagen/{{($repuesto->imagen)}}" >
                                        </center>

                                    </td>
                                    

                                    <td>
                                        <form action="{{ route('repuestos.destroy',$repuesto->id) }}" method="POST">
                                            @can('editar-repuesto')
                                            <a class="btn btn-info"
                                                href="{{ route('repuestos.edit',$repuesto->id) }}">
                                                Editar
                                            </a>
                                            @endcan

                                            @csrf
                                            @method('DELETE')
                                            @can('borrar-repuesto')
                                            <button type="submit" class="btn btn-danger">
                                                Borrar
                                            </button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $repuestos->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection