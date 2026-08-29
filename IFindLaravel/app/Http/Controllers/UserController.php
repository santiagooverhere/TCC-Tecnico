<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->loadCount('posts');
        return view('users.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->posts()->exists()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Não é possível excluir usuário com posts vinculados.');
        }

        if ($user->comentarios()->withTrashed()->exists()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Não é possível excluir usuário com comentários vinculados');
        }

        $user->delete();
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuário removido com sucesso!');
    }
}
