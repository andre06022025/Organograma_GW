<form id="formSistema" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="id" id="sistema_id">
    
    <div class="mb-3">
        <label class="form-label">Área <span class="text-danger">*</span></label>
        <select name="area_id" id="sistema_area_id" class="form-select form-select-sm" required>
            <option value="">Selecione a área</option>
            @foreach($areas as $a)
                <option value="{{ $a->id }}">{{ $a->nome }} ({{ $a->tipo }})</option>
            @endforeach
        </select>
        <div class="invalid-feedback">Selecione uma área</div>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-8">
            <label class="form-label">Nome do Sistema <span class="text-danger">*</span></label>
            <input type="text" name="nome" id="sistema_nome" class="form-control form-control-sm" required maxlength="150">
            <div class="invalid-feedback">Nome é obrigatório</div>
        </div>
        <div class="col-4">
            <label class="form-label">Sigla</label>
            <input type="text" name="sigla" id="sistema_sigla" class="form-control form-control-sm" maxlength="30" placeholder="Ex: SIST1">
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="descricao" id="sistema_descricao" class="form-control form-control-sm" rows="2" placeholder="Descrição opcional do sistema..."></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Coordenador Responsável</label>
        <select name="coordenador_id" id="sistema_coordenador_id" class="form-select form-select-sm">
            <option value="">Selecione o coordenador</option>
            @foreach($coordenadores as $c)
                <option value="{{ $c->id }}">{{ $c->nome }} ({{ $c->cargo }})</option>
            @endforeach
        </select>
    </div>
    
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Ordem de Exibição</label>
            <input type="number" name="ordem" id="sistema_ordem" class="form-control form-control-sm" min="0" value="0">
        </div>
        <div class="col-6">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" name="ativo" id="sistema_ativo" checked>
                <label class="form-check-label" for="sistema_ativo">Ativo</label>
            </div>
        </div>
    </div>
    
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill" id="btnSalvarSistema">
            <i class="bi bi-save me-1"></i> Salvar
        </button>
        <button type="button" class="btn btn-outline-secondary flex-fill" id="btnCancelarSistema">
            <i class="bi bi-x me-1"></i> Cancelar
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formSistema');
    const btnCancelar = document.getElementById('btnCancelarSistema');
    
    function limparFormulario() {
        form.reset();
        document.getElementById('sistema_id').value = '';
        document.getElementById('sistema_ativo').checked = true;
        document.getElementById('sistema_ordem').value = 0;
        form.classList.remove('was-validated');
        document.getElementById('btnSalvarSistema').innerHTML = '<i class="bi bi-save me-1"></i> Salvar';
    }
    
    window.editarSistema = function(sistema) {
        document.getElementById('sistema_id').value = sistema.id;
        document.getElementById('sistema_area_id').value = sistema.area_id;
        document.getElementById('sistema_nome').value = sistema.nome;
        document.getElementById('sistema_sigla').value = sistema.sigla || '';
        document.getElementById('sistema_descricao').value = sistema.descricao || '';
        document.getElementById('sistema_coordenador_id').value = sistema.coordenador_id || '';
        document.getElementById('sistema_ordem').value = sistema.ordem || 0;
        document.getElementById('sistema_ativo').checked = sistema.ativo;
        document.getElementById('btnSalvarSistema').innerHTML = '<i class="bi bi-save me-1"></i> Atualizar';
        
        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCadastros'));
        offcanvas.show();
        
        const tab = new bootstrap.Tab(document.getElementById('aba-sistema-tab'));
        tab.show();
    };
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const id = document.getElementById('sistema_id').value;
        const url = id ? '{{ route('organograma.sistemas.update', ':id') }}'.replace(':id', id) : '{{ route('organograma.sistemas.store') }}';
        const method = id ? 'PUT' : 'POST';
        
        const formData = new FormData(form);
        formData.append('_method', method);
        formData.append('_token', '{{ csrf_token() }}');
        
        const btn = document.getElementById('btnSalvarSistema');
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
            
            if (response.ok) {
                limparFormulario();
                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCadastros')).hide();
                location.reload();
            } else {
                const data = await response.json();
                alert(data.message || 'Erro ao salvar');
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
    document.getElementById('offcanvasCadastros').addEventListener('hidden.bs.offcanvas', limparFormulario);
});
</script>