<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

class ThesisTotalPerTopicDonatChart
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

        return $this->chart->donutChart()
            ->addData($value)
            ->setHeight(170)
            ->setLabels($label);
    }
}
