<?php

namespace App\Charts;

use App\Models\BarangModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class BarangCategoriesPieChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $dataRaw = BarangModel::groupBy('kategori_id')
            ->selectRaw('count(*) as total, kategori_id')
            ->with('kategori')
            ->get();

        $data  = $dataRaw->pluck('total')->toArray();
        $label  = $dataRaw->pluck('kategori')->pluck('kategori_nama')->toArray();


        return $this->chart->pieChart()
            ->setTitle('Kategori Barang')
            ->addData($data)
            ->setLabels($label);
    }
}
