<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

class ThesisTotalPerTypeHztBarChart
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
        $barChart = $this->chart
            ->horizontalBarChart();

        foreach ($this->data as $item) {
            $barChart->addData($item->get('label'), [$item->get('value')]);
        }


        return $barChart->setHeight('320');
    }
}
