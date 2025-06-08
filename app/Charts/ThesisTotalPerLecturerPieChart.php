<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

class ThesisTotalPerLecturerPieChart
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
        $label = $this->data->pluck('label')->toArray();
        $value = $this->data->pluck('value')->toArray();

        return $this->chart->pieChart()
            ->addData($value)
            ->setHeight(220)
            ->setLabels($label);
    }
}
