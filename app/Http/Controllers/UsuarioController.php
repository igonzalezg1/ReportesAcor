<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-user|crear-user|editar-user|borrar-user', ['only'=> ['index']]);
        $this->middleware('permission:crear-user', ['only'=> ['create','store']]);
        $this->middleware('permission:editar-user', ['only'=> ['edit','update']]);
        $this->middleware('permission:borrar-user', ['only'=> ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required|size:5',
            'mobile' => 'required|unique:users|size:10',
            'phone' => 'required|unique:users|size:10',
            'username' => 'required',
            'email' => 'required|string|email|unique:users',
            'roles' => 'required',
            'profile_image'=>'required|image'
        ]);

        $imagen = $request->file('profile_image')->store('public/fotosperfil');
        $url = Storage::url($imagen);
        $data = $request->all();
        $rol = implode(" ", $data['roles']);
        $user = User::create([
                'id_empresa' => 1,
                'id_sucursal' => 110,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'zip_code' => $data['zip_code'],
                'mobile' => $data['mobile'],
                'phone' => $data['phone'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'profile_image' => $url,
                'description' => 'no tiene descripcion',
                'status' => 'activate',
                'activation_key' => 'no tiene key',
                'date_register' => '2000-01-16',
                'user_type' => $rol,
                'remember_token' => 'no tiene token',
            ]);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('usuarios.editar', compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'email' => 'required|string|email',
            'roles' => 'required',
            'profile_image'=>'required|image'
        ]);

        $imagen = $request->file('profile_image')->store('public/fotosperfil');
        $url = Storage::url($imagen);
        $data = $request->all();
        $rol = implode(" ", $data['roles']);
        $user = User::find($id);
        if (!empty($data['password'])) {
            $user->update([
                'id_empresa' => 1,
                'id_sucursal' => 110,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'zip_code' => $data['zip_code'],
                'mobile' => $data['mobile'],
                'phone' => $data['phone'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'profile_image' => $url,
                'description' => 'no tiene descripcion',
                'status' => 'activate',
                'activation_key' => 'no tiene key',
                'date_register' => '2000-01-16',
                'user_type' => $rol,
                'remember_token' => 'no tiene token',
            ]);
        }else{
            $user->update([
                'id_empresa' => 1,
                'id_sucursal' => 110,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'zip_code' => $data['zip_code'],
                'mobile' => $data['mobile'],
                'phone' => $data['phone'],
                'username' => $data['username'],
                'email' => $data['email'],
                'profile_image' => $url,
                'description' => 'no tiene descripcion',
                'status' => 'activate',
                'activation_key' => 'no tiene key',
                'date_register' => '2000-01-16',
                'user_type' => $rol,
                'remember_token' => 'no tiene token',
            ]);
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}
