<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return view('dashboard.pengaturan.list-akun.index', [
            'users' => $users
        ]);
    }

    public function create() {
        $roles = Role::all();
        
        return view('dashboard.pengaturan.list-akun.create', [
            'roles' => $roles
        ]);
    }

    public function edit($id) {
        $roles = Role::all();
        $user = User::findOrFail($id);

        return view('dashboard.pengaturan.list-akun.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'userid' => 'required',
            'account_name' => 'required',
            'role_id' => 'required',
            'password' => 'required',
        ]);
        
        DB::beginTransaction();
        
        try {
            $data['password'] = bcrypt($request->password);
            
            User::create($data);

            DB::commit();

            return redirect(route('list-akun'))->with('success', 'Akun berhasil dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'userid' => 'required',
            'account_name' => 'required',
            'role_id' => 'required',
        ]);
        
        DB::beginTransaction();
        
        try {
            $user = User::findOrFail($id);

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            } else {
                $data['password'] = $user->password;
            }
            $user->update($data);

            DB::commit();

            return back()->with('success', 'Akun berhasil di ubah.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());

            // return back()->with('error', 'Terjadi kesalahan saat mengubah data.');
        }
    }

    public function destroy($id) {
        
        DB::beginTransaction();
        
        try {
            User::findOrFail($id)->delete();

            DB::commit();

            return back()->with('success', 'Akun berhasil di hapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
