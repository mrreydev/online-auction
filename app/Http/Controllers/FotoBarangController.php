<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Illuminate\Support\Str;
use App\FotoBarang;

class FotoBarangController extends Controller
{
    public function insertFoto($id, $files){
        $destinationPath = 'barang/image/'; // upload directory
        $inserts = array();
        foreach ($files as $file) {
            $random = Str::random(10);
            $profileImage = date('YmdHis')."-".$random.".".$file->getClientOriginalExtension();
            $file->move($destinationPath, $profileImage);
            $inserts[]= "$profileImage";
        }

        foreach ($inserts as $insert) {
            $fotoBarangs = new FotoBarang();
            $fotoBarangs->id_barang = $id;
            $fotoBarangs->foto = $insert;
            $fotoBarangs->save();
        }

        return 'tambah-foto';
    }

    public function deleteFotoBarang($id_barang){
        $images = FotoBarang::where('id_barang', $id_barang);
        $urlImg = public_path('barang/image');

        foreach($images as $image){
            if(File::exists($urlImg.'/'.$image->foto)){
                if(File::delete($urlImg.'/'.$image->foto)){
                    FotoBarang::where('id_barang', $image->id_barang)->delete();
                    $check = 'img-deleted';
                }
            }
        }

        return 'img-deleted';
    }

    public function editOneFotoBarang(Request $request, $id_barang){
        $validator = Validator::make($request->all(), [
            'gambarBaru' => 'required|image|mimes:jpeg,jpg,png,svg|max:2048'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $namaGambar = $request->input('nama-gambar');
        $gambarBaru = $request->file('gambarBaru');

        $gambars = FotoBarang::where('id_barang', $id_barang)
                                ->where('foto', $namaGambar)->get();
        $pathGambarLama = public_path('/barang/image');

        if(File::exists($pathGambarLama.'/'.$gambars[0]->foto)){
            if(File::delete($pathGambarLama.'/'.$gambars[0]->foto)){
                $random = Str::random(10);
                $pathBaru = 'barang/image';
                $namaGambarBaru = date('YmdHis')."-".$random.".".$gambarBaru->getClientOriginalExtension();
                $gambarBaru->move($pathBaru, $namaGambarBaru);

                $updateQuery = FotoBarang::where('id_barang', $id_barang)
                ->where('foto', $namaGambar)
                ->update(['foto' => (string)$namaGambarBaru]);

                if($updateQuery){
                    return redirect('/petugas/barang/update/'.$id_barang);
                }
            }

        }
    }

    public function deleteOneFotoBarang($id_barang, $namaGambar){
        $fotoBarangs = FotoBarang::where('id_barang', $id_barang)
                                ->where('foto', $namaGambar)->get();
        $pathGambar = public_path('barang/image');
        foreach($fotoBarangs as $fotoBarang){
            if(File::exists($pathGambar.'/'.$fotoBarang->foto)){
                // dd('Foto Ada');
                $deleteQuery = FotoBarang::where('id_barang', $id_barang)
                ->where('foto', $namaGambar)->delete();

                if($deleteQuery){
                    File::delete($pathGambar.'/'.$fotoBarang->foto);
                    return redirect('/petugas/barang/update/'.$id_barang);
                }
            }
        }
    }
}
