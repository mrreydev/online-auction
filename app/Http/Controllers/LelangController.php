<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Lelang;
use App\Barang;
use App\FotoBarang;
use App\HistoryLelang;

// Export
use App\Exports\LelangExport;
use App\Exports\LelangTahunanExport;
use App\Exports\LelangBulananExport;
use App\Exports\LelangHarianExport;
use App\Exports\LelangCustomExport;
use Maatwebsite\Excel\Facades\Excel;

class LelangController extends Controller
{

    public function __construct(){
        $this->autoStartLelang();
        $this->autoTutupLelang();
    }

    public function allLelang(){
        if($level = Session::get('level') != 'administrator'){
            $petugas = Session::get('id_petugas');
            $lelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->select('*')
                            ->where('id_petugas', $petugas)->get();
            // dd($lelangs);
            foreach($lelangs as $lelang){
                $lelang->start_lelang = date_format(date_create($lelang->start_lelang), 'd-m-Y');
            }
            $barangs = Barang::all();

            return view('petugas.lelang.lelangs', ['dataLelang' => $lelangs, 'dataBarang' => $barangs]);
        }
        $lelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->select('*')->get();
        // dd($lelangs);
        foreach($lelangs as $lelang){
            $lelang->start_lelang = date_format(date_create($lelang->start_lelang), 'd-m-Y');
        }
        $barangs = Barang::all();

        return view('petugas.lelang.lelangs', ['dataLelang' => $lelangs, 'dataBarang' => $barangs]);
    }

    public function viewInsertLelang(){
        return view('petugas.lelang.insert-view-lelang');
    }


    public function storeLelang(Request $request){
        // dd($request->all());
        if($request->input('config-durasi') == 'config-1'){
            $validator = Validator::make($request->all(), [
                'barang-lelang' => 'required|integer',
                'durasi-lelang' => 'required|integer',
                'harga-akhir' => 'required|integer'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Cek Barang di tabel lelang
            $lelangs = Lelang::all();

            foreach($lelangs as $lelang){
                if($lelang->id_barang == $request->input('barang-lelang')){
                    return redirect('/petugas/lelang')->with('error', 'Anda tidak bisa memasukan barang yang sama pada lelang');
                }
            }
            // Insert Data Lelang
            if($request->input('durasi-lelang') == 1){
                $endLelang = Carbon::now()->addDays(1);
            }
            else if($request->input('durasi-lelang') == 2){
                $endLelang = Carbon::now()->addDays(2);
            }
            else if($request->input('durasi-lelang') == 3){
                $endLelang = Carbon::now()->addDays(3);
            }

            $lelangs = new Lelang();
            $lelangs->id_barang = $request->input('barang-lelang');
            $lelangs->start_lelang = Carbon::now();
            $lelangs->end_lelang = $endLelang;
            $lelangs->harga_akhir = $request->input('harga-akhir');
            $lelangs->id_petugas = Session::get('id_petugas');
            $lelangs->status = 'dibuka';

            if($lelangs->save()){
                return redirect('/petugas/lelang')->with('success', 'Berhasil Menambah Lelang');
            }
        }

        if($request->input('config-durasi') == 'config-2'){
            $validator = Validator::make($request->all(), [
                'barang-lelang' => 'required|integer',
                'custom-time-lelang' => 'required',
                'harga-akhir' => 'required|integer'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lelangs = Lelang::all();

            foreach($lelangs as $lelang){
                if($lelang->id_barang == $request->input('barang-lelang')){
                    return redirect('/petugas/lelang')->with('error', 'Anda tidak bisa memasukan barang yang sama pada lelang');
                }
            }

            $lelangs = new Lelang();
            $lelangs->id_barang = $request->input('barang-lelang');
            $lelangs->start_lelang = $request->input('custom-time-lelang');
            $lelangs->harga_akhir = $request->input('harga-akhir');
            $lelangs->id_petugas = Session::get('id_petugas');

            if($lelangs->save()){
                return redirect('/petugas/lelang')->with('success', 'Berhasil menambah lelang <span class="font-weight-bold">Anda Bisa Membuka lelang dengan Klik Detal</span>');
            }
        }
    }

    public function forAjaxLelang($id_lelang){
        $dataLelang = Lelang::where('id_lelang', $id_lelang)->get();
        foreach($dataLelang as $data){
            if(!$data->id_user == null){
                $dataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('petugas', 'petugas.id_petugas', '=', 'lelangs.id_petugas')
                            ->join('masyarakats', 'masyarakats.id_user', '=', 'lelangs.id_user')
                            ->select('lelangs.*', 'barangs.nama_barang', 'petugas.nama_petugas', 'masyarakats.nama_lengkap')
                            ->where('lelangs.id_lelang', $id_lelang)->get();

                return response()->json($dataLelang, 200);
            }
        }
        $dataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('petugas', 'petugas.id_petugas', '=', 'lelangs.id_petugas')
                            ->select('lelangs.*', 'barangs.nama_barang', 'petugas.nama_petugas')
                            ->where('lelangs.id_lelang', $id_lelang)->get();

        return response()->json($dataLelang, 200);
    }

    public function deleteDataLelang($id_lelang){
        $dataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('petugas', 'petugas.id_petugas', '=', 'lelangs.id_petugas')
                            ->select('lelangs.*', 'barangs.nama_barang', 'petugas.nama_petugas')
                            ->where('lelangs.id_lelang', $id_lelang)->get();

        foreach($dataLelang as $data){
            if($data->status == 'dibuka'){
                return redirect('/petugas/lelang')->with('error', 'Anda Tidak Bisa menghapus Data Lelang yang sedang berlangsung');
            }

            if($data->status == 'ditutup'){
                if($data->id_user == null){
                    return redirect('/petugas/lelang')->with('error', 'Anda Tidak Bisa menghapus Data Lelang yang sedang berlangsung');
                }
            }
        }
    }

    public function tutupLelang($id_lelang){
        $dataLelang = Lelang::where('lelangs.id_lelang', $id_lelang)->get();

        foreach($dataLelang as $data){
            if($data->status == 'dibuka'){
                Lelang::where('lelangs.id_lelang', $id_lelang)
                        ->update([
                            'end_lelang' => Carbon::now(),
                            'status' => 'ditutup'
                        ]);
            }
        }

        return redirect('/petugas/lelang')->with('success', 'Berhasil menutup lelang dengan ID ='.$id_lelang);
    }

    public function bukaLelang($id_lelang){
        $dataLelang = Lelang::where('lelangs.id_lelang', $id_lelang)->get();

        foreach($dataLelang as $data){
            if($data->status == null){
                Lelang::where('lelangs.id_lelang', $id_lelang)
                        ->update([
                            'start_lelang' => Carbon::now(),
                            'status' => 'dibuka'
                        ]);
            }
            else if($data->status == 'ditutup'){
                if($data->id_user == null){
                    Lelang::where('lelangs.id_lelang', $id_lelang)
                        ->update([
                            'start_lelang' => Carbon::now(),
                            'end_lelang' => null,
                            'status' => 'dibuka'
                        ]);
                }
            }
        }

        return redirect('/petugas/lelang')->with('success', 'Berhasil membuka Lelang dengan ID = '.$id_lelang);
    }

    public function autoStartLelang(){
        $dataLelang = Lelang::all();
        $tgl_sekarang = Carbon::now();

        foreach($dataLelang as $data){
            $tgl_mulai_lelang = $data->start_lelang;

            if($tgl_mulai_lelang >= $tgl_sekarang){
                if($data->status == null){
                    $updateQuery = Lelang::where('id_lelang', $data->id_lelang)
                                        ->update([
                                            'status' => 'dibuka'
                                        ]);
                }
            }
        }
    }

    public function autoTutupLelang(){
        $dataLelang = Lelang::all();
        $tgl_sekarang = Carbon::now();

        foreach($dataLelang as $data){
            if($data->end_lelang){
                $tgl_akhir_lelang = $data->end_lelang;
                if($tgl_sekarang > $tgl_akhir_lelang){
                    if($data->status == 'dibuka'){
                        $updateQuery = Lelang::where('id_lelang', $data->id_lelang)
                                            ->update([
                                                'status' => 'ditutup'
                                            ]);
                    }
                }
            }
        }
    }

    public function exportLelang(Request $request){
        if($request->input('customRadio') == 'semuaData'){
            return Excel::download(new LelangExport, 'Semua Data Lelang.xlsx');
        }

        if($request->input('customRadio') == 'tahunIni'){
            $year = Carbon::now();
            $year = Carbon::createFromFormat('Y-m-d H:i:s', $year)->year;
            return Excel::download(new LelangTahunanExport($year), 'Data Lelang Tahun '.$year.'.xlsx');
        }

        if($request->input('customRadio') == 'bulanIni'){
            $year = Carbon::now();
            $year = Carbon::createFromFormat('Y-m-d H:i:s', $year)->year;
            $month = Carbon::now();
            $month = Carbon::createFromFormat('Y-m-d H:i:s', $month)->month;
            return Excel::download(new LelangBulananExport($month, $year), 'Data Lelang Bulan '.$month.'-'.$year.'.xlsx');
        }

        if($request->input('customRadio') == 'hariIni'){
            $year = Carbon::now();
            $year = Carbon::createFromFormat('Y-m-d H:i:s', $year)->year;
            $month = Carbon::now();
            $month = Carbon::createFromFormat('Y-m-d H:i:s', $month)->month;
            $day = Carbon::now();
            $day = Carbon::createFromFormat('Y-m-d H:i:s', $day)->day;
            return Excel::download(new LelangHarianExport($day, $month, $year), 'Data Lelang Tgl '.$day.'-'.$month.'-'.$year.'.xlsx');
        }

        if($request->input('customRadio') == 'custom'){
            $from = $request->input('tgl_awal');
            $to = $request->input('tgl_akhir');

            $dari = Carbon::createFromFormat('Y-m-d', $from);
            $hingga = Carbon::createFromFormat('Y-m-d', $to);
            return Excel::download(new LelangCustomExport($from, $to), 'Data Lelang Dari '.$dari.' Hingga '.$hingga.'.xlsx');
        }
    }

    /* Fungsi Sisi Client */
    public function mainMenuCli(Request $request){
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

    public function allLelangCli(){
        $lelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->groupBy('nama_barang')
                            ->paginate(12);
        foreach($lelangs as $lelang){
            $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
        }
        Session::forget('filter-type');
        return view('masyarakat.lelang',  ['dataLelang' => $lelangs]);
    }

    public function filterLelang(Request $request, $filter_type){
        if($filter_type == 'rendah-ke-tinggi'){
            $filterLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->orderBy('lelangs.harga_akhir')
                            ->groupBy('nama_barang')
                            ->paginate(12);

            foreach($filterLelang as $lelang){
                $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
            }

            Session::flash('filter-type', $filter_type);
            return view('masyarakat.lelang',  ['dataLelang' => $filterLelang]);
        }

        if($filter_type == 'tinggi-ke-rendah'){
            $filterLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->orderBy('lelangs.harga_akhir', 'DESC')
                            ->groupBy('nama_barang')
                            ->paginate(12);

            foreach($filterLelang as $lelang){
                $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
            }

            Session::flash('filter-type', $filter_type);
            return view('masyarakat.lelang',  ['dataLelang' => $filterLelang]);
        }

        if($filter_type == 'baru-ke-lama'){
            $filterLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->orderBy('lelangs.tgl_lelang')
                            ->groupBy('nama_barang')
                            ->paginate(12);

            foreach($filterLelang as $lelang){
                $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
            }

            Session::flash('filter-type', $filter_type);
            return view('masyarakat.lelang',  ['dataLelang' => $filterLelang]);
        }

        if($filter_type == 'lama-ke-baru'){
            $filterLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->orderBy('lelangs.tgl_lelang', 'DESC')
                            ->groupBy('nama_barang')
                            ->paginate(12);

            foreach($filterLelang as $lelang){
                $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
            }

            Session::flash('filter-type', $filter_type);
            return view('masyarakat.lelang',  ['dataLelang' => $filterLelang]);
        }

        if($filter_type == 'range'){
            $validator = Validator::make($request->all(), [
                'harga_awal' => 'required|numeric',
                'harga_akhir' => 'required|numeric'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $filterLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'dibuka')
                            ->whereBetween('lelangs.harga_akhir', [$request->input('harga_awal'), $request->input('harga_akhir')])
                            ->groupBy('nama_barang')
                            ->paginate(12);

            foreach($filterLelang as $lelang){
                $lelang->limitText = Str::limit($lelang->deskripsi_barang, 40);
            }

            Session::flash('filter-type', $filter_type);
            Session::flash('harga-awal', $request->input('harga_awal'));
            Session::flash('harga-akhir', $request->input('harga_akhir'));
            return view('masyarakat.lelang',  ['dataLelang' => $filterLelang]);
        }
    }

    public function viewBid($id_lelang){
        $histories = HistoryLelang::where('id_lelang', $id_lelang)
                                    ->get();
        if($histories){
            $dataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->select('lelangs.*', 'barangs.*')
                            ->where('lelangs.id_lelang', $id_lelang)->get();
            if($dataLelang){
                foreach($dataLelang as $data){
                    $fotoBarang = FotoBarang::where('id_barang', $data->id_barang)->get();
                }
            }

            foreach($fotoBarang as $foto){
                $foto->urlFoto = url('/barang/image').'/'.$foto->foto;
            }

            $histories = HistoryLelang::join('masyarakats', 'history_lelangs.id_user', '=', 'masyarakats.id_user')
                                    ->select('history_lelangs.*', 'masyarakats.nama_lengkap')
                                    ->where('id_lelang', $id_lelang)
                                    ->orderBy('penawaran_harga', 'DESC')
                                    ->limit(10)
                                    ->get();

            return view('masyarakat.bidding', ['dataLelang' => $dataLelang, 'fotoBarang' => $fotoBarang, 'historyLelang' => $histories]);
        }

        $dataLelang = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->select('lelangs.*', 'barangs.*')
                            ->where('lelangs.id_lelang', $id_lelang)->get();
        if($dataLelang){
            foreach($dataLelang as $data){
                $fotoBarang = FotoBarang::where('id_barang', $data->id_barang)->get();
            }
        }

        foreach($fotoBarang as $foto){
            $foto->urlFoto = url('/barang/image').'/'.$foto->foto;
        }

        return view('masyarakat.bidding', ['dataLelang' => $dataLelang, 'fotoBarang' => $fotoBarang]);
    }

    public function bidProcess(Request $request, $id_lelang){
        $validator = Validator::make($request->all(), [
            'id_lelang' => 'required',
            'id_barang' => 'required',
            'bid_baru' => 'required|integer'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek harga di database
        $histories = HistoryLelang::where('id_lelang', $request->input('id_lelang'))
                                ->where('id_barang', $request->input('id_barang'))
                                ->orderBy('penawaran_harga', 'DESC')
                                ->limit(1)
                                ->get();
        if($histories){
            foreach($histories as $history){
                if($request->input('bid_baru') <= $history->penawaran_harga){
                    return redirect()->back()->with('error', 'Sudah ada yang menawar dengan harga yang lebih tinggi');
                }
            }
        }

        // Save to History
        $history = new HistoryLelang();
        $history->id_lelang = $request->input('id_lelang');
        $history->id_barang = $request->input('id_barang');
        $history->id_user = $request->input('id_user');
        $history->penawaran_harga = $request->input('bid_baru');

        if($history->save()){
            // Update Main Lelang
            $queryUpdateLelang = Lelang::where('id_lelang', $request->input('id_lelang'))
                                    ->update([
                                        'id_user' => $request->input('id_user'),
                                        'harga_akhir' => $request->input('bid_baru')
                                    ]);
            return redirect('/lelang/bidding/'.$request->input('id_lelang').'')->with('success', 'Berhasil Menambah Bid');
        }

    }

    public function riwayatLelang(){
        $id_user = Session::get('id_user');
        // Record pemenang
        $dataLelangs = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                            ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                            ->select('*')
                            ->where('lelangs.status', 'ditutup')
                            ->where('lelangs.id_user', $id_user)
                            ->groupBy('nama_barang')
                            ->get();

        // Record Mengikuti
        $ikutiLelang = Lelang::join('history_lelangs', 'lelangs.id_lelang', '=', 'history_lelangs.id_lelang')
                                    ->join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                                    ->join('foto_barangs', 'lelangs.id_barang', '=', 'foto_barangs.id_barang')
                                    ->select('lelangs.id_lelang', 'lelangs.harga_akhir', 'lelangs.status', 'foto_barangs.foto', 'barangs.*')
                                    ->where('history_lelangs.id_user', $id_user)
                                    ->groupBy('lelangs.id_lelang')
                                    ->get();

        return view('masyarakat.riwayat', ['menangLelang' => $dataLelangs, 'ikutiLelang' => $ikutiLelang]);
    }
}
