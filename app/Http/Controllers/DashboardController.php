<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PenerimaBantuan;
use App\Models\ProgramBantuan;
use App\Models\Warga; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index()
    {
        
        $dataWarga = Warga::count();
        $dataKK = Keluarga::count(); 
        $dataBLT = PenerimaBantuan::query()->where('Status', 'Layak')->count();       
        $chartData = $this->getChartData('Pendidikan');

        return view('dashboard', [
            'dataWarga' => $dataWarga,
            'dataKK' => $dataKK,
            'dataBLT' => $dataBLT,
            'initialChartData' => json_encode($chartData) 
        ]);
    }

    /**
     * Method ini akan dipanggil oleh AJAX untuk mengambil data chart baru.
     */
    public function fetchChartData(Request $request)
    {
        
        $filterType = $request->input('filter', 'Pendidikan'); 

        $data = $this->getChartData($filterType);

        
        return response()->json($data);
    }

    /**
     * Helper function untuk mengambil data dari database.
     */
    private function getChartData($filterType)
    {
        $query = Warga::query();

        
        $column = '';
        switch ($filterType) {
            case 'Pekerjaan':
                $column = 'Pekerjaan';
                break;
            case 'Usia':
                
                
                return $this->getChartDataByUsia();
            case 'Pendidikan':
            default:
                $column = 'Pendidikan';
                break;
        }

        
        $data = $query->select($column, DB::raw('count(*) as total'))
                     ->groupBy($column)
                     ->orderBy($column)
                     ->get();

        $colors = [
            '#007bff',
          
        ];

        return [
            'labels' => $data->pluck($column), 
            'datasets' => [
                [
                    'label' => 'Total Warga berdasarkan ' . $filterType,
                    'data' => $data->pluck('total'), 
                    'backgroundColor' => $colors,
                ]
            ]
        ];
    }
    
    /**
     * Helper khusus untuk filter Usia (karena lebih kompleks)
     */
    private function getChartDataByUsia()
    {
        
        $bins = [
            '0-17' => [0, 17],
            '18-25' => [18, 25],
            '26-35' => [26, 35],
            '36-45' => [36, 45],
            '46-55' => [46, 55],
            '55+' => [56, 200], 
        ];

        $query = Warga::select(DB::raw("
            CASE
                WHEN YEAR(CURDATE()) - YEAR(Tanggal_Lahir) BETWEEN 0 AND 17 THEN '0-17 Tahun'
                WHEN YEAR(CURDATE()) - YEAR(Tanggal_Lahir) BETWEEN 18 AND 25 THEN '18-25 Tahun'
                WHEN YEAR(CURDATE()) - YEAR(Tanggal_Lahir) BETWEEN 26 AND 35 THEN '26-35 Tahun'
                WHEN YEAR(CURDATE()) - YEAR(Tanggal_Lahir) BETWEEN 36 AND 45 THEN '36-45 Tahun'
                WHEN YEAR(CURDATE()) - YEAR(Tanggal_Lahir) BETWEEN 46 AND 55 THEN '46-55 Tahun'
                ELSE '55+ Tahun'
            END as Kelompok_Usia,
            COUNT(*) as total
        "))
        ->groupBy('Kelompok_Usia')
        ->orderBy('Kelompok_Usia')
        ->get();

         $colors = [
            '#007bff',
        ];

        return [
            'labels' => $query->pluck('Kelompok_Usia'),
            'datasets' => [
                [
                    'label' => 'Total Warga berdasarkan Usia',
                    'data' => $query->pluck('total'),
                    'backgroundColor' => $colors,
                ]
            ]
        ];
    }
}