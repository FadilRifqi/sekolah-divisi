<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function getAll(){
        //Mencari Seluruh User
        $user = User::all();

        // Kembalikan response dengan status 200 dan pesan sukses
        return response()->json(UserResource::collection($user),200);
    }
    public function get($id){
        try {
            // Mencari user berdasarkan ID
            $user = User::find($id);

            // Jika user tidak ditemukan, kembalikan response dengan status 400
            if (!$user) {
                return response()->json(["message" => "Ga ada user"], 404);
            }

            // Kembalikan response dengan status 200 dan pesan sukses
            return response()->json(UserResource::collection($user), 200);

        } catch (\Exception $e) {
            // Tangkap kesalahan lain dan kembalikan response dengan status 500
            return response()->json([
                "message" => "Terjadi kesalahan",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request){
         try {
            // Validasi input (opsional)
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ]);

            // Buat pengguna baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Kembalikan response JSON dengan status 201 (Created)
            return response()->json($user, 201);

        } catch (ValidationException $e) {
            // Tangkap kesalahan validasi dan kembalikan response dengan status $e->status
            return response()->json([
                'status' => $e->status,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], $e->status);

        }  catch (\Exception $e) {
            // Tangani kesalahan lainnya dan kembalikan response dengan status 500 (Internal Server Error)
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request,$id){
        try {
            // Mencari user berdasarkan ID
            $user = User::find($id);

            // Jika user tidak ditemukan, kembalikan response dengan status 400
            if (!$user) {
                return response()->json(["message" => "Ga ada user"], 404);
            }

            // Aturan validasi untuk memastikan email hanya unik jika tidak sama dengan email pengguna yang sedang diupdate
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6'  
            ]);

            // Periksa apakah email dalam permintaan sama dengan email pengguna yang sedang diupdate
            if ($request->input('email') !== $user->email) {
                // Validasi tambahan untuk memastikan email unik di tabel users jika berubah
                $request->validate([
                    'email' => 'unique:users,email'
                ]);
            }

            // Update user dengan data baru
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password) || $user->password
            ]);

            // Kembalikan response dengan data user yang telah diupdate dan status 200
            return response()->json(UserResource::collection($user), 200);

        } catch (ValidationException $e) {
            // Tangkap kesalahan validasi dan kembalikan response dengan status $e->status
            return response()->json([
                'status' => $e->status,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], $e->status);

        } catch (\Exception $e) {
            // Tangkap kesalahan lain dan kembalikan response dengan status 500
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id){
        try {
            // Mencari user berdasarkan ID
            $user = User::find($id);

            // Jika user tidak ditemukan, kembalikan response dengan status 400
            if (!$user) {
                return response()->json(["message" => "Ga ada user"], 404);
            }

            // Hapus user
            $user->delete();

            // Kembalikan response dengan status 200 dan pesan sukses
            return response()->json(["message" => "User berhasil dihapus"], 200);

        } catch (\Exception $e) {
            // Tangkap kesalahan lain dan kembalikan response dengan status 500
            return response()->json([
                "message" => "Terjadi kesalahan",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
