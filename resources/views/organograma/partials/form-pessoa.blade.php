<form id="formPessoa" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="id" id="pessoa_id">
    
    <div class="mb-3">
        <label class="form-label">Sistema <span class="text-danger">*</span></label>
        <select name="sistema_id" id="pessoa_sistema_id" class="form-select form-select-sm" required>
            <option value="">Selecione o sistema</option>
            @foreach($sistemas as $s)
                <option value="{{ $s->id }}">{{ $s->nome }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">Selecione um sistema</div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Gestor Direto</label>
        <select name="gestor_id" id="pessoa_gestor_id" class="form-select form-select-sm">
            <option value="">Sem gestor (nível superior)</option>
            @foreach($gestores as $g)
                <option value="{{ $g->id }}">{{ $g->nome }} ({{ $g->cargo }})</option>
            @endforeach
        </select>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Nome <span class="text-danger">*</span></label>
            <input type="text" name="nome" id="pessoa_nome" class="form-control form-control-sm" required maxlength="150">
            <div class="invalid-feedback">Nome é obrigatório</div>
        </div>
        <div class="col-6">
            <label class="form-label">Cargo <span class="text-danger">*</span></label>
            <input type="text" name="cargo" id="pessoa_cargo" class="form-control form-control-sm" required maxlength="100">
            <div class="invalid-feedback">Cargo é obrigatório</div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Nível Hierárquico <span class="text-danger">*</span></label>
        <select name="nivel" id="pessoa_nivel" class="form-select form-select-sm" required>
            <option value="">Selecione</option>
            @foreach($niveis as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">Selecione o nível</div>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="pessoa_email" class="form-control form-control-sm" maxlength="150">
        </div>
        <div class="col-6">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" id="pessoa_telefone" class="form-control form-control-sm" maxlength="30" placeholder="(11) 99999-9999">
        </div>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Veículo</label>
            <input type="text" name="veiculo" id="pessoa_veiculo" class="form-control form-control-sm" maxlength="50" placeholder="Ex: FIAT STRADA">
        </div>
        <div class="col-6">
            <label class="form-label">Turno</label>
            <input type="text" name="turno" id="pessoa_turno" class="form-control form-control-sm" maxlength="30" placeholder="Ex: Diurno / Noturno">
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Região de Atuação</label>
        <input type="text" name="regiao" id="pessoa_regiao" class="form-control form-control-sm" maxlength="100" placeholder="Ex: Integrados + Rota 3">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Observações</label>
        <textarea name="observacoes" id="pessoa_observacoes" class="form-control form-control-sm" rows="2"></textarea>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Data Admissão</label>
            <input type="date" name="data_admissao" id="pessoa_data_admissao" class="form-control form-control-sm">
        </div>
        <div class="col-6">
            <label class="form-label">Ordem de Exibição</label>
            <input type="number" name="ordem" id="pessoa_ordem" class="form-control form-control-sm" min="0" value="0">
        </div>
    </div>
    
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" name="ativo" id="pessoa_ativo" checked>
        <label class="form-check-label" for="pessoa_ativo">Ativo</label>
    </div>
    
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill" id="btnSalvarPessoa">
            <i class="bi bi-save me-1"></i> Salvar
        </button>
        <button type="button" class="btn btn-outline-secondary flex-fill" id="btnCancelarPessoa">
            <i class="bi bi-x me-1"></i> Cancelar
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPessoa');
    const btnCancelar = document.getElementById('btnCancelarPessoa');
    
    // Limpar formulário
    function limparFormulario() {
        form.reset();
        document.getElementById('pessoa_id').value = '';
        document.getElementById('pessoa_ativo').checked = true;
        document.getElementById('pessoa_ordem').value = 0;
        form.classList.remove('was-validated');
        document.getElementById('btnSalvarPessoa').innerHTML = '<i class="bi bi-save me-1"></i> Salvar';
    }
    
    // Editar - preencher formulário
    window.editarPessoa = function(pessoa) {
        document.getElementById('pessoa_id').value = pessoa.id;
        document.getElementById('pessoa_sistema_id').value = pessoa.sistema_id || '';
        document.getElementById('pessoa_gestor_id').value = pessoa.gestor_id || '';
        document.getElementById('pessoa_nome').value = pessoa.nome;
        document.getElementById('pessoa_cargo').value = pessoa.cargo;
        document.getElementById('pessoa_nivel').value = pessoa.nivel;
        document.getElementById('pessoa_email').value = pessoa.email || '';
        document.getElementById('pessoa_telefone').value = pessoa.telefone || '';
        document.getElementById('pessoa_veiculo').value = pessoa.veiculo || '';
        document.getElementById('pessoa_turno').value = pessoa.turno || '';
        document.getElementById('pessoa_regiao').value = pessoa.regiao || '';
        document.getElementById('pessoa_observacoes').value = pessoa.observacoes || '';
        document.getElementById('pessoa_data_admissao').value = pessoa.data_admissao || '';
        document.getElementById('pessoa_ordem').value = pessoa.ordem || 0;
        document.getElementById('pessoa_ativo').checked = pessoa.ativo;
        document.getElementById('btnSalvarPessoa').innerHTML = '<i class="bi bi-save me-1"></i> Atualizar';
        
        // Abrir offcanvas
        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCadastros'));
        offcanvas.show();
        
        // Ativar aba pessoa
        const tab = new bootstrap.Tab(document.getElementById('aba-pessoa-tab'));
        tab.show();
    };
    
    // Submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const id = document.getElementById('pessoa_id').value;
        const url = id ? '{{ route('organograma.pessoas.update', ':id') }}'.replace(':id', id) : '{{ route('organograma.pessoas.store') }}';
        const method = id ? 'PUT' : 'POST';
        
        const formData = new FormData(form);
        formData.append('_method', method);
        formData.append('_token', '{{ csrf_token() }}');
        
        const btn = document.getElementById('btnSalvarPessoa');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></i> Salvando...';
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                limparFormulario();
                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCadastros')).hide();
                location.reload(); // Simples: recarregar página
            } else {
                alert(data.message || 'Erro ao salvar');
                if (data.errors) {
                    console.log(data.errors);
                }
            }
        } catch (err) {
            console.error(err);
            alert('Erro de conexão');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
    
    btnCancelar.addEventListener('click', limparFormulario);
    
    // Reset ao fechar offcanvas
    document.getElementById('offcanvasCadastros').addEventListener('hidden.bs.offcanvas', limparFormulario);
});
</script>