<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('grupo');

        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where(function ($q) use ($termo) {
                $q->where('name', 'like', "%{$termo}%")
                  ->orWhere('email', 'like', "%{$termo}%")
                  ->orWhere('cargo', 'like', "%{$termo}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('grupo_id')) {
            $query->where('grupo_id', $request->grupo_id);
        }

        $usuarios = $query->orderBy('name')->paginate(20)->withQueryString();

        $grupos = Grupo::ativos()->get(['id', 'nome']);
        $gestores = User::where('status', 'ativo')
            ->where('role', '!=', 'visualizador')
            ->orderBy('name')
            ->get(['id', 'name', 'cargo', 'role']);

        return view('cadastros.usuarios.index', compact('usuarios', 'grupos', 'gestores'));
    }

    public function create()
    {
        $grupos = Grupo::ativos()->get(['id', 'nome']);
        $gestores = User::where('status', 'ativo')
            ->where('role', '!=', 'visualizador')
            ->orderBy('name')
            ->get(['id', 'name', 'cargo', 'role']);

        return view('cadastros.usuarios.create', compact('grupos', 'gestores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('usuarios', 'public');
            $dados['foto_path'] = $path;
        }

        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return redirect()
            ->route('cadastros.usuarios.index')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(User $usuario)
    {
        $grupos = Grupo::ativos()->get(['id', 'nome']);
        $gestores = User::where('status', 'ativo')
            ->where('id', '!=', $usuario->id)
            ->where('role', '!=', 'visualizador')
            ->orderBy('name')
            ->get(['id', 'name', 'cargo', 'role']);

        return view('cadastros.usuarios.edit', compact('usuario', 'grupos', 'gestores'));
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $dados = $this->validar($request, $usuario);

        if ($request->hasFile('foto')) {
            if ($usuario->foto_path && Storage::disk('public')->exists($usuario->foto_path)) {
                Storage::disk('public')->delete($usuario->foto_path);
            }
            $path = $request->file('foto')->store('usuarios', 'public');
            $dados['foto_path'] = $path;
        }

        if ($request->filled('password')) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password'], $dados['password_confirmation']);
        }

        $usuario->update($dados);

        return redirect()
            ->route('cadastros.usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('cadastros.usuarios.index')
                ->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        if ($usuario->foto_path && Storage::disk('public')->exists($usuario->foto_path)) {
            Storage::disk('public')->delete($usuario->foto_path);
        }

        $usuario->delete();

        return redirect()
            ->route('cadastros.usuarios.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    private function validar(Request $request, ?User $usuario = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'cargo' => ['nullable', 'string', 'max:100'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'grupo_id' => ['nullable', Rule::exists('grupos', 'id')],
            'gestor_id' => ['nullable', Rule::exists('users', 'id')],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($usuario?->id)],
            'password' => $usuario ? ['nullable', 'string', 'min:6', 'confirmed'] : ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'gestao', 'operador', 'visualizador'])],
            'status' => ['required', Rule::in(['ativo', 'inativo'])],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'ramal' => ['nullable', 'string', 'max:20'],
            'unidade' => ['nullable', 'string', 'max:100'],
        ]);
    }
}