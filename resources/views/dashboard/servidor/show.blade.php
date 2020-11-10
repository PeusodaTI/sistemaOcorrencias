@extends('layouts.app')

@push('style')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" crossorigin="anonymous" />

@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Listagem de todos os servidores cadastrados no sistema
                    <button type="submit" class="btn btn-primary btnp">
                        <!-- Redirecionando para a rota de cadastro -->
                        <div class="btn"> <a href="{{ route('servidor.create') }}" id="btn">Cadastrar </a></div>
                    </button>
                </div>
                @include('flash::message')
                <div class="card-body">
                   <div class="portlet-body table-responsive">
                   
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>Nome do Servidor</th>
                                <th>E-mail</th>
                                <th>Siape</th>
                                <th>Contato</th>
                                <th>Função</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($serv as $servidor)
                            <tr class="active">
                                
                                <td>{{ $servidor->nome }}</td>
                                <td>{{ $servidor->email }}</td>
                                <td>{{ $servidor->siape }}</td>
                                <td>{{ $servidor->contato }}</td>
                                @if($servidor->funcao == 'p')
                                    <td>Professor</td>
                                @else
                                    <td>Servidor</td>
                                @endif
                                <td><a href="{{ route('servidor.update', $servidor->id) }}" class="btn btn-info btn-sm"> Atualizar
                                    </a>&ensp;</td>
                                    <td><a class="btn btn-danger btn-sm delete-confirm"
                                        href="#">
                                        Excluir </a></td>
                                
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('/js/jquery.min.js')  }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#table').DataTable({
            "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Seguinte",
                    "sLast": "Último"
                }
            }

        });
    } );
</script>

@endpush



