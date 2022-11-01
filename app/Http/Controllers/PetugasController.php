<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Petugas;
use App\Level;

use App\Http\Controllers\BarangController;

class PetugasController extends Controller
{
    protected $barangCtrl;

    public function __construct(){
        $this->middleware('web');
        $this->barangCtrl = new BarangController();
    }

    public function index(Request $request){
        return view('petugas.login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Username dan Password Harus Lebih dari 6 Karakter');
        }

        $username = $request->input('username');
        $password = $request->input('password');

        $petugas = Petugas::where('username', $username)->first();
        if($petugas){
            $decryptPass = Crypt::decryptString($petugas->password);
            if($password == $decryptPass){
                $petugas = Petugas::where('username', $username)
                                    ->join('levels', 'petugas.id_level', '=', 'levels.id_level')
                                    ->select('petugas.id_petugas', 'petugas.nama_petugas', 'petugas.username', 'levels.level')->first();

                $request->session()->put('id_petugas', $petugas->id_petugas);
                $request->session()->put('nama_petugas', $petugas->nama_petugas);
                $request->session()->put('username', $petugas->username);
                $request->session()->put('level', $petugas->level);

                return redirect('/petugas/dashboard');
            }
            else{
                return redirect('/petugas/login')->with('error', 'Username atau Password Salah');
            }
        }
        else{
            return redirect('/petugas/login')->with('error', 'Akun ini tidak terdaftar');
        }
    }

    public function logout(Request $request){
        $request->session()->forget(['id_petugas', 'nama_petugas', 'username', 'level']);
        return redirect('/petugas/login');
    }

    public function dashboard(){
        $pengguna = DB::select('CALL countAllPengguna()');
        $barang = DB::select('CALL countAllBarang()');
        $lelang = DB::select('CALL countAllLelang()');
        $bid = DB::select('CALL countAllBid()');

        $barChart = DB::select('CALL getStatsBid()');
        $lineChart = DB::select('CALL getStatsMasyarakat()');

        foreach($barChart as $bar){
            $bar->dateonly = date_format(date_create($bar->dateonly), "d-M-Y");
        }

        foreach($lineChart as $line){
            $line->dateonly = date_format(date_create($line->dateonly), 'd-M-Y');
        }

        $data = [
            'ctPengguna' => $pengguna[0]->totalPengguna,
            'ctBarang' => $barang[0]->totalBarang,
            'ctLelang' => $lelang[0]->totalLelang,
            'ctBid' => $bid[0]->totalBid,
            'barChartData' => $barChart,
            'lineChartData' => $lineChart
        ];

        return view('petugas.dashboard', $data);
    }

    public function barang(){
        $barangs = $this->barangCtrl->showAllBarang();
        return view('petugas.barang', ['data' => $barangs]);
    }

    public function storeBarang(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_awal' => 'required|numeric',
            'deskripsi_barang' => 'required|string|max:150',
            'imageBarang' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // dd($request->all());
        $nama_barang = $request->input('nama_barang');
        $harga_awal = $request->input('harga_awal');
        $deskripsi_barang = $request->input('deskripsi_barang');
        if($images = $request->file('imageBarang')){
            $check = $this->barangCtrl->insertBarang($nama_barang, $harga_awal, $deskripsi_barang, $images);

            if($check == 'berhasil'){
                return redirect('/petugas/barang')->with('success', 'Berhasil Menambah Barang');
            }
            else{
                return redirect('/petugas/barang')->with('error', 'Gagal Menambah Barang');
            }
        }

    }

    public function dateTest(){
        dd(Carbon::now());
    }

    public function forAjaxBarang($id_barang){
        $data = $this->barangCtrl->viewOneBarang($id_barang);
        return response()->json($data, 200);
    }

    public function deleteBarang($id_barang){
        $check = $this->barangCtrl->deleteBarangCord($id_barang);
        if($check == 'all-data-deleted'){
            return redirect('/petugas/barang')->with('success', 'Berhasil menghapus barang dengan ID = '.$id_barang);
        }
    }

    public function viewUpdateBarang($id_barang){
        $barangs = $this->barangCtrl->viewUpdateBarang($id_barang);
        return view('petugas.update-barang', [
            'dataBarang' => $barangs['dataBarang'],
            'fotoBarang' => $barangs['fotoBarang']
        ]);
    }

    // Manage Petugas
    public function viewPetugas(){
        $petugases = Petugas::join('levels', 'levels.id_level', '=', 'petugas.id_level')
                                ->select('*')->get();
        return view('petugas.manage-petugas', ['data' => $petugases]);
    }

    public function storePetugas(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:25',
            'username' => 'required|string|min:6|max:25',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insertPetugas = new Petugas();
        $insertPetugas->nama_petugas = $request->input('nama_petugas');
        $insertPetugas->username = $request->input('username');
        $insertPetugas->password = Crypt::encryptString($request->input('password'));
        $insertPetugas->id_level = 2;

        if($insertPetugas->save()){
            return redirect('/petugas/manage-petugas')->with('success', 'Berhasil Menambah Petugas Baru');
        }
    }

    public function viewOnePetugas($id_petugas){
        $petugases = DB::select('CALL getOnePetugas(?)', [$id_petugas]);

        foreach($petugases as $petugas){
            $petugas->password = Crypt::decryptString($petugas->password);
        }

        if($petugases){
            return response()->json($petugases, 200);
        }
    }

    public function updatePetugas(Request $request, $id_petugas){
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:25',
            'username' => 'required|string|min:6|max:25',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateQuery = Petugas::where('id_petugas', $id_petugas)
                            ->update([
                                'nama_petugas' => $request->input('nama_petugas'),
                                'username' => $request->input('username'),
                                'password' => Crypt::encryptString($request->input('password'))
                            ]);
        return redirect('/petugas/manage-petugas')->with('success', 'Berhasil Memperbaharui data Petugas dengan ID = '.$id_petugas);
    }

    public function deletePetugas($id_petugas){
        $petugas = Petugas::where('id_petugas', $id_petugas);
        if($petugas->delete()){
            return redirect('/petugas/manage-petugas')->with('success', 'Berhasil Menghapus data Petugas dengan ID = '.$id_petugas);
        }
    }
}
