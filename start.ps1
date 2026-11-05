# Inicia o servidor do Organograma GW com reinício automático.
# Uso: clique com o botão direito > "Executar com PowerShell" ou rode:
#   powershell -ExecutionPolicy Bypass -File .\start.ps1

$ErrorActionPreference = "SilentlyContinue"

$projeto = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $projeto

$porta = 8080

# Encerra qualquer processo antigo escutando na porta para evitar conflito.
$conexoes = Get-NetTCPConnection -LocalPort $porta -State Listen -ErrorAction SilentlyContinue
foreach ($conexao in $conexoes) {
    try {
        Stop-Process -Id $conexao.OwningProcess -Force -ErrorAction SilentlyContinue
        Write-Host "Processo antigo na porta $porta encerrado (PID $($conexao.OwningProcess))." -ForegroundColor DarkYellow
    } catch {
        # ignora
    }
}

Write-Host ""
Write-Host " ==============================================" -ForegroundColor Cyan
Write-Host "  Organograma GW" -ForegroundColor Cyan
Write-Host "  http://localhost:$porta/organograma" -ForegroundColor Green
Write-Host "  Pressione Ctrl+C para parar." -ForegroundColor Cyan
Write-Host " ==============================================" -ForegroundColor Cyan
Write-Host ""

# Mantém o servidor vivo: se ele cair, reinicia automaticamente.
while ($true) {
    php artisan serve --host=0.0.0.0 --port=$porta
    Write-Host "Servidor encerrou. Reiniciando em 2 segundos..." -ForegroundColor Yellow
    Start-Sleep -Seconds 2
}
