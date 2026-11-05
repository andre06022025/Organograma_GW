# Encerra o servidor do Organograma GW (porta 8080).
# Uso: powershell -ExecutionPolicy Bypass -File .\stop.ps1

$porta = 8080
$conexoes = Get-NetTCPConnection -LocalPort $porta -State Listen -ErrorAction SilentlyContinue

if (-not $conexoes) {
    Write-Host "Nenhum processo escutando na porta $porta." -ForegroundColor Yellow
    exit
}

foreach ($conexao in $conexoes) {
    try {
        Stop-Process -Id $conexao.OwningProcess -Force -ErrorAction SilentlyContinue
        Write-Host "Processo encerrado (PID $($conexao.OwningProcess))." -ForegroundColor Green
    } catch {
        Write-Host "Não foi possível encerrar o PID $($conexao.OwningProcess)." -ForegroundColor Red
    }
}
