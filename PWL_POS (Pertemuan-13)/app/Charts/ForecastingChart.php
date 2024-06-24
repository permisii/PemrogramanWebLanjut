<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;

class ForecastingChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\areaChart
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:ss');

        $dataRaw = DB::select(
            "SELECT sum(pd.harga * pd.jumlah) as total, DATE_FORMAT(p.created_at, '%W %d %M') as day
        from t_penjualan_detail as pd
        inner join t_penjualan as p on p.penjualan_id = pd.penjualan_id
        where p.created_at >='" . $start . "' GROUP by day"
        );

        //parse array to collection
        $dataRaw = collect($dataRaw);
        //to hold processed data
        $processedData = collect();

        // dd(Carbon::now()->subDays(2)->format('l d F'), $dataRaw, (Int) Carbon::now()->format('d'));

        for ($i = 0; $i < ((int) Carbon::now()->format('d')); $i++) {
            $comparisonDate =  Carbon::now()->subDays($i)->format('l d F');

            $existDate = $dataRaw->where('day', $comparisonDate);

            // if($i == 1) dd($existDate, $dataRaw, $comparisonDate, $comparisonDate == $dataRaw[$i]->day? true: false);

            if ($existDate->isEmpty()) {
                $processedData->prepend([
                    'total' => 0,
                    'day' => [(int)Carbon::now()->subDays($i)->format('d')]
                ]);
            } else {
                $processedData->prepend([
                    'total' => $existDate->first()->total,
                    'day' => [(int)Carbon::createFromDate($existDate->first()->day)->format('d')]
                ]);
            }
        }

        $samples = $processedData->pluck('day')->toArray();
        $targets  = $processedData->pluck('total')->toArray();
        $regression = new LeastSquares();
        $regression->train($samples, $targets);

        $diff = (int)Carbon::now()->endOfMonth()->format('d') - (int)Carbon::now()->format('d');

        $dataPrediction = collect();

        for ($i = 1; $i <=  $diff; $i++) {
            $dataPrediction->push([
                'prediction' => $regression->predict([((int)Carbon::now()->addDays($i)->format('d'))]) > 0 ? $regression->predict([((int)Carbon::now()->addDays($i)->format('d'))]) : 0,
                'day' => Carbon::now()->addDays($i)->format('d F Y')
            ]);
        }

        //Number of registrants
        $data = $dataPrediction->pluck('prediction')->toArray();

        //Date
        $date = $dataPrediction->pluck('day')->toArray();

        return $this->chart->areaChart()
            ->setTitle('PWL POS Website Transaction Prediction Report')
            ->setSubtitle('Transaction Prediction Report in ' . Carbon::now()->format('F'))
            ->addData('Transaction Total Prediction', $data)
            ->setXAxis($date)
            ->setColors(['#A0DEFF'])
            ->setMarkers(['#5AB2FF'], 8);
    }
}
