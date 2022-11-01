<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FotoBarangController;
use App\Barang;
use Validator,Redirect,Response,File;
use App\FotoBarang;
use App\Lelang;

class BarangController extends Controller
{
    protected $fotoBarangCtrl;

    public function __construct(){
        $this->fotoBarangCtrl = new FotoBarangController();
    }

    public function showAllBarang(){
        $barangs = Barang::all();
        // dd($barangs);
        foreach($barangs as $barang){
            $barang->date = date_format(date_create($barang->date), "d-m-Y");
        }
        return $barangs;
    }

    public function insertBarang($nama_barang, $harga_awal, $deskripsi_barang, $image){
        $barangs = new Barang();
        $barangs->nama_barang = $nama_barang;
        $barangs->date = date('yy-m-d');
        $barangs->harga_awal = $harga_awal;
        $barangs->deskripsi_barang = $deskripsi_barang;

        if($barangs->save()){
            $barangs = Barang::where('nama_barang', $nama_barang)->first();
            $check = $this->fotoBarangCtrl->insertFoto($barangs->id_barang, $image);

            if($check = 'tambah-foto'){
                return 'berhasil';
            }
        }
    }

    public function viewOneBarang($id_barang){
        $barangs = Barang::where('barangs.id_barang', $id_barang)
                        ->join('foto_barangs', 'foto_barangs.id_barang', '=', 'barangs.id_barang')
                        ->select('*')->get();
        $url = url('/barang/image/');

        foreach ($barangs as $barang) {
            # code...
            $barang->date = date_format(date_create($barang->date), 'd-m-Y');
            $barang->foto = $url.'/'.$barang->foto;
        }

        // dd($barangs);
        return $barangs;
    }

    public function deleteBarangCord($id_barang){
        $satuDataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                                ->where('lelangs.id_barang', $id_barang)->get();
        foreach($satuDataLelang as $data){
            if($data->id_barang){
                return redirect('/petugas/barang')->with('error', 'Anda tidak bisa menghapus barang yang sedang dilelang');
            }
        }

        $images = FotoBarang::where('id_barang', $id_barang)->get();
        $urlImg = public_path('barang/image');

        foreach($images as $image){
            if(File::exists($urlImg.'/'.$image->foto)){
                if(File::delete($urlImg.'/'.$image->foto)){
                    FotoBarang::where('id_barang', $image->id_barang)->delete();
                    $check = 'img-deleted';
                }
            }
        }

        if($check == 'img-deleted'){
            $barangs = Barang::where('id_barang', $id_barang);
            if($barangs->delete()){
                return 'all-data-deleted';
            }
        }
    }

    public function viewUpdateBarang($id_barang){
        $dataBarang = Barang::where('id_barang', $id_barang)->get();
        $fotoBarangs = FotoBarang::where('id_barang', $id_barang)->get();

        $url = url('/barang/image/');

        foreach ($fotoBarangs as $barang) {
            # code...
            $barang->url = $url.'/'.$barang->foto;
        }

        $datas = [
            'dataBarang' => $dataBarang,
            'fotoBarang' => $fotoBarangs
        ];
        // dd($datas);
        return $datas;
    }

    public function editOneDataBarang(Request $request, $id_barang){
        if($request->file('imageBarang')){
            $validator = Validator::make($request->all(), [
                'nama_barang' => 'required',
                'harga_awal' => 'required|numeric',
                'deskripsi_barang' => 'required|string|max:150',
                'imageBarang' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->fotoBarangCtrl->insertFoto($id_barang, $request->file('imageBarang'));
            $updateBarang = Barang::where('id_barang', $id_barang)
                            ->update([
                                'nama_barang' => $request->input('nama_barang'),
                                'harga_awal' => $request->input('harga_awal'),
                                'deskripsi_barang' => $request->input('deskripsi_barang')
                            ]);
            if($updateBarang){
                return redirect('/petugas/barang')->with('success', 'Berhasil memperbaharui data Barang dengan ID = '.$id_barang);
            }
        }
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_awal' => 'required|numeric',
            'deskripsi_barang' => 'required|string|max:150',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateBarang = Barang::where('id_barang', $id_barang)
                            ->update([
                                'nama_barang' => $request->input('nama_barang'),
                                'harga_awal' => $request->input('harga_awal'),
                                'deskripsi_barang' => $request->input('deskripsi_barang')
                            ]);
        if($updateBarang){
            return redirect('/petugas/barang')->with('success', 'Berhasil memperbaharui data Barang dengan ID = '.$id_barang);
        }
    }
}
