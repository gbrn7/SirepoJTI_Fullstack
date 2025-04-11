<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

class ThesisTotalPerYearLineChart
{
    protected $chart;
    protected $data;

    public function __construct(LarapexChart $chart, SupportCollection $data)
    {
        $this->chart = $chart;
        $this->data = $data;
    }

    public function build()
    {
        $count = $this->data->pluck('aggregate')->toArray();
        $year = $this->data->pluck('date')->toArray();

        return $this->chart->lineChart()
            ->addData('Jumlah', $count)
            ->setHeight('220')
            ->setColors(['#ea5455'])
            ->setXAxis($year);
    }
}
