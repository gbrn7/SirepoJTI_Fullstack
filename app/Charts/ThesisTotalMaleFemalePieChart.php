<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

class ThesisTotalMaleFemalePieChart
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
        $male = $this->data->get('male');
        $female = $this->data->get('female');

        return $this->chart->pieChart()
            ->addData([$male, $female])
            ->setHeight('220')
            ->setColors(['#ea5455', '#F07B3F'])
            ->setLabels(['Laki - Laki', 'Perempuan']);
    }
}
