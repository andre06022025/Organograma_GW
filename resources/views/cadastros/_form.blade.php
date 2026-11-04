@php
    $operadores = old('operadores', $cadastro->operadores ?? []);
    $operadores = is_array($operadores) ? array_values($operadores) : [];
@endphp

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label font-weight-bold">Nome <span class="text-danger">*</span></label>
        <input type="text" name="nome" class="form-control" value="{{ old('nome', $cadastro->nome) }}"
               required maxlength="200" placeholder="Nome da unidade/cliente">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label font-weight-bold">Tipo <span class="text-danger">*</span></label>
        <select name="tipo" class="form-control" required>
            @foreach(\App\Models\Cadastro::TIPOS as $valor => $rotulo)
                <option value="{{ $valor }}" {{ old('tipo', $cadastro->tipo ?? 'ETA') === $valor ? 'selected' : '' }}>
                    {{ $rotulo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Gestor</label>
        <select name="gestor_id" class="form-control">
            <option value="">Sem gestor</option>
            @foreach($gestores as $gestor)
                <option value="{{ $gestor->id }}" {{ (string) old('gestor_id', $cadastro->gestor_id) === (string) $gestor->id ? 'selected' : '' }}>
                    {{ $gestor->nome_completo }} ({{ $gestor->cargo }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Sistema</label>
        <select name="sistema" class="form-control">
            <option value="">Sem sistema</option>
            @foreach($sistemas as $valor => $rotulo)
                <option value="{{ $valor }}" {{ old('sistema', $cadastro->sistema) === $valor ? 'selected' : '' }}>{{ $rotulo }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Contrato</label>
        <input type="text" name="contrato" class="form-control" value="{{ old('contrato', $cadastro->contrato) }}"
               maxlength="150" placeholder="Número/identificação do contrato">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Data do contrato</label>
        <input type="date" name="data_contrato" class="form-control"
               value="{{ old('data_contrato', $cadastro->data_contrato?->format('Y-m-d')) }}">
    </div>

    <div class="col-12 mb-3">
        <label class="form-label font-weight-bold">Informações da gestão / contratos</label>
        <textarea name="informacoes" rows="3" class="form-control"
                  placeholder="Contratos, observações e informações da gestão">{{ old('informacoes', $cadastro->informacoes) }}</textarea>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label font-weight-bold">Operação</label>
        <input type="text" name="operacao" class="form-control" value="{{ old('operacao', $cadastro->operacao) }}"
               maxlength="150" placeholder="Ex.: Operação ETA">
    </div>

    <div class="col-12 mb-1">
        <label class="form-label font-weight-bold mb-1">Operadores <small class="text-muted">(até 4 nomes)</small></label>
    </div>
    @for($i = 0; $i < 4; $i++)
        <div class="col-md-3 mb-3">
            <input type="text" name="operadores[]" class="form-control"
                   value="{{ old('operadores.' . $i, $operadores[$i] ?? '') }}"
                   maxlength="150" placeholder="Operador {{ $i + 1 }}">
        </div>
    @endfor

    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Número de poços</label>
        <input type="number" name="numero_pocos" class="form-control"
               value="{{ old('numero_pocos', $cadastro->numero_pocos) }}" min="0" placeholder="Deixe vazio se não houver">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label font-weight-bold">Quantidade de operadores</label>
        <input type="number" name="quantidade_operadores" class="form-control"
               value="{{ old('quantidade_operadores', $cadastro->quantidade_operadores) }}" min="0" placeholder="Deixe vazio se não houver">
    </div>
</div>
