<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Organograma GW</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Source Sans Pro', sans-serif; }
        .login-box { max-width: 420px; }
        .card { border-radius: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .card-header { border-radius: 1rem 1rem 0 0 !important; }
        .btn-lte-purple { background: #6f42c1; border-color: #6f42c1; }
        .btn-lte-purple:hover { background: #5a32a3; border-color: #5a32a3; }
        .form-control:focus { border-color: #6f42c1; box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25); }
    </style>
</head>
<body class="hold-transition login-page bg-lte-gray-bg">
    <div class="login-box">
        <div class="login-logo text-center mb-4">
            <a href="{{ route('organograma.index') }}" class="text-dark">
                <i class="fas fa-sitemap fa-2x text-lte-purple mr-2"></i>
                <span class="font-weight-bold text-lg">Organograma GW</span>
            </a>
        </div>
        
        <div class="card">
            <div class="card-header bg-lte-purple text-white text-center py-3">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt mr-2"></i> Acesso ao Sistema</h4>
            </div>
            
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="email"><i class="fas fa-envelope mr-1"></i> E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="{{ old('email') }}" required autofocus autocomplete="email">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="password"><i class="fas fa-lock mr-1"></i> Senha</label>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
                    </div>
                    
                    <div class="form-group mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                            <label class="custom-control-label" for="remember">Lembrar-me</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-lte-purple btn-block btn-lg py-2">
                        <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                    </button>
                </form>
                
                <div class="text-center mt-4 text-muted small">
                    <p class="mb-1">General Water - Centro de Controle Operacional</p>
                    <p class="mb-0">Organograma Corporativo 2027</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>