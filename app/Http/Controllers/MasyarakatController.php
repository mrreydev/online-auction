<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Masyarakat;
use App\Lelang;

class MasyarakatController extends Controller
{
    public function __construct(){
        $this->middleware('web');
    }

   	public function userRegister(){
   		return view('masyarakat.register');
   	}

   	public function doRegister(Request $request){
   		$validator = Validator::make($request->all(), [
   			'nama_lengkap' => 'required|string|max:191',
   			'username' => 'required|min:6|max:30|unique:masyarakats,username',
   			'password' => 'required|min:6',
   			'telepon' => 'required|min:6'
   		]);

   		if($validator->fails()){
   			return redirect('/')->withErrors($validator);
   		}

   		$nama_lengkap = $request->nama_lengkap;
   		$username = $request->username;
   		$password = $request->password;
   		$telepon = $request->telepon;

   		$masyarakat = new Masyarakat();
   		$masyarakat->nama_lengkap = $nama_lengkap;
   		$masyarakat->username = $username;
   		$masyarakat->password = Crypt::encryptString($password);
   		$masyarakat->telp = $telepon;

   		if($masyarakat->save()){
   			return redirect('/')->with('success', 'Anda Berhasil Melakukan Registrasi');
   		}
    }

    public function index(Request $request){
		if($request->session()->get('id_user') && $request->session()->get('nama_lengkap') && $request->session()->get('username') && $request->session()->get('telp')){
			return redirect('/beranda');
		}
        return view('masyarakat.login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $username = $request->input('username');
        $password = $request->input('password');

        $masyarakats = Masyarakat::where('username', $username)->first();

        if(!$masyarakats){
            return redirect('/')->with('error', 'Username atau Password Salah');
        }
        $decryptPass = Crypt::decryptString($masyarakats->password);

        if($password == $decryptPass){
            $request->session()->put('id_user', $masyarakats->id_user);
            $request->session()->put('nama_lengkap_mas', $masyarakats->nama_lengkap);
            $request->session()->put('username_mas', $masyarakats->username);
            $request->session()->put('telp', $masyarakats->telp);

            return redirect('/beranda')->with('masyarakat', 'Kamu adalah User dengan id = '.$masyarakats->id_user);
        }
        else{
            return redirect('/')->with('error', 'Username atau Password Salah');
        }
    }

    public function logout(Request $request){
        $request->session()->forget(['id_user', 'nama_lengkap_mas', 'username_mas', 'telp']);
        return redirect('/');
    }

    // Main Menu Masyarakat
    public function mainMenu(Request $request){
        if(!$request->session()->get('id_user')){
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu');
        }

        $lelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->orderBy('lelangs.start_lelang', 'desc')
                            ->limit(8)
                            ->groupBy('nama_barang')->get();
        foreach($lelangs as $lelang){
            $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
        }
        return view('masyarakat.beranda', ['dataLelang' => $lelangs]);
    }

    public function allLelang(){
        $lelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->groupBy('nama_barang')->get();
        foreach($lelangs as $lelang){
            $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
        }
        return view('masyarakat.lelang',  ['dataLelang' => $lelangs]);
    }
}
