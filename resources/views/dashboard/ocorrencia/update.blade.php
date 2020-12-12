@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" crossorigin="anonymous" />
<link rel="stylesheet" href="{{ asset('/js/select2/select2.min.css')  }}" crossorigin="anonymous" />
<style>
  .select2-container {
    width: 100% !important;
    padding: 0;
  }

  h11 {
    color: red;
  }

  #logo {
    width: 50%;
    height: 50%;
  }

  table.dataTable tr th.select-checkbox.selected::after {
    content: "✔";
    margin-top: -11px;
    margin-left: -4px;
    text-align: center;
    text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
  }

  .panel-heading {
    font-size: 150%;
  }
</style>
@endpush
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Cadastro de Ocorrencia</div>
        <div class="card-body">
          <div class="portlet-body table-responsive">
            {{ Form::model($ocorrencia, ['route' => 'ocorrencia.updateConf','id' => 'form', 'method' => 'PUT', 'files' => true, 'enctype' => 'multipart/form-data']) }}
            <fieldset>

              <!-- Select Basic -->
              <div class="form-group">
                {{ Form::label('tipo_id', 'Motivo da Ocorrência *', array('class' => 'col-md-12 control-label')) }}
                <!--<label class="col-md-1 control-label" for="radios">Função<h11>*</h11></label>-->
                <div class="col-md-12">
                  {{ Form::select (
                            'tipo_id',
                            $tipos->pluck('descricao', 'id'),
                            ['id' => 'tipo_id',
                            'class' => 'form-control chosen-select',
                            'required',
                            'value' => $ocorrencia->tipo->tipo_ocorrencia_id,
                            'autofocus'])
                    }}
                </div>
              </div>

              <input type="hidden" value="{{ $ocorrencia->id }}" name="id">
              <!-- Text input-->
              <div class="form-group">
                {{ Form::label('disciplina', 'Disciplina *', array('class' => 'col-md-2 control-label')) }}
                <div class="col-md-8 ">
                  {{ Form::text('disciplina', 'old'('disciplina'), ['class' => 'form-control input-md', 'required']) }}
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                {{ Form::label('data_ocorrencia', 'Data da Ocorrência *', array('class' => 'col-md-5 control-label')) }}
                <div class="col-md-3">
                  {{ Form::date('data_ocorrencia', 'old'('data_ocorrencia'), ['class' => 'form-control input-md', 'required']) }}
                </div>
              </div>

              <!-- Select Basic -->
              <div class="form-group">
                {{ Form::label('turma_id', 'Turma *', array('class' => 'col-md-4 control-label')) }}
                <!--<label class="col-md-1 control-label" for="radios">Função<h11>*</h11></label>-->
                <div class="col-md-4">
                  {{ Form::select (
                            'turma_id',
                            $turmas->pluck('codigo', 'id'),
                            old('turma_id'),
                            ['id' => 'turma_id',
                            'class' => 'form-control chosen-select',
                            'required',
                            'autofocus'])
                    }}
                </div>
              </div>

              <div class="form-group">
                {{ Form::label('relato', 'Relato', array('class' => 'col-md-5 control-label')) }}
                <div class="col-md-12">
                  {{ Form::text('relato', 'old'('relato'), ['class' => 'form-control input-md']) }}
                </div>
              </div>

              <table class="table display" id="table" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Turma</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($alunos as $aluno)
                  <tr class="active" value="{{ $aluno->id }}">
                    <td><input type="checkbox" name="checkbox[{{ $aluno->id }}]" value="{{ $aluno->id }}" @foreach($aluno->ocorrenciaAluno as $oc)@if($oc->ocorrencia_id == $ocorrencia->id) checked @endif @endforeach></td>
                    <td>{{ $aluno->nome }}</td>
                    <td>{{ $aluno->turma->codigo }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <!-- Button (Double) -->
            </fieldset>
            <div class="col-md-12">
              {{ Form::submit('Atualizar Ocorrência', ['class' => 'btn btn-success btn-block btn-lg']) }}
            </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!------ Include the above in your HEAD tag ---------->
@endsection

@push('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('/js/jquery.min.js')  }}"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script>
  $(document).ready(function() {
    var table = $('#table').DataTable({
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
      },
      /*'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order': [[1, 'asc']],*/
      dom: 'lrtip'

    });

    $(".dataTables_filter").hide();

    $('#turma_id').on('change', function() {
      table.search(this.selectedOptions[0].textContent).draw();
    });
    $("#turma_id").trigger("change");

  });

  $(document).ready(function() {
    $('[name=tipo_id]').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });
</script>
@endpush