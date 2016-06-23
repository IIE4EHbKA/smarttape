<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function index(Request $request)
    {
        $data['currency'] = (!empty($request->input('curransy'))) ? $request->input('curransy') : 'eur';
        $data['bar'] = (!empty($request->input('bar'))) ? strtotime($request->input('bar')) : date('Y-m-d H:i:00', time());
        $data['volume'] = (!empty($request->input('volume'))) ? $request->input('volume') : '0';
        $data['rows'] = (!empty($request->input('rows'))) ? $request->input('rows') : '0';
        $data['timeframe'] = (!empty($request->input('timeframe'))) ? $request->input('timeframe') : '5';

        $operation = 'Null';
        $direction = 'Null';
        $counter = 0;
        $open = 'Null';
        $close = 'Null';
        $min = 'Null';
        $max = 'Null';
        $middle = 0.0;
        $allVolume = 0;
        $counterTemp = 0;
        $maxRows = DB::table('st_' . $data['currency'])->where('created_at', '>=', $data['bar'])->where('tVolume', '>=', $data['volume'])->get();

        for ($i = 0; $i < count($maxRows); $i++) {
            if ($i !== 0) {
                if ($maxRows[$i]->tDirection == $maxRows[$i - 1]->tDirection) {
                    $counter++;
                } else {
                    if ($counter > $counterTemp) $counterTemp = $counter;
                    $counter = 1;
                }
                if ($counter > $counterTemp) {
                    $direction = $maxRows[$i]->tDirection;
                }
            }
            if ($data['rows'] == '0') {
                $direction = $maxRows[$i]->tDirection;
            }
        }

        $bar = strtotime(date('Y-m-d H:i:00', time()) . "- " . $data['timeframe'] . " min");
        $rows = app('db')->table('st_' . $data['currency'])
            ->select('tPrice', 'tVolume', 'tDirection')
            ->where('created_at', '>', $bar)
            ->orderBy('id', 'asc')
            ->get();
        if (!empty($rows)) {
            $arraySize = count($rows) - 1;
            $max = max($rows)->tPrice;
            $min = min($rows)->tPrice;
            $open = $rows[0]->tPrice;
            $close = $rows[$arraySize]->tPrice;
            $middle = str_replace('.',',',(str_replace(',','.',$max) - str_replace(',','.',$min))+str_replace(',','.',$min));

            foreach ($rows as $row) {
                $allVolume += $row->tVolume;
            }

            if ($direction == 'Buy' and $open >= $middle and $close <= $middle and $counter >= $data['rows']) {
                $operation = 'Sell';
            } elseif ($direction == 'Sell' and $open <= $middle and $close >= $middle and $counter >= $data['rows']) {
                $operation = 'Buy';
            } else {
                $operation = 'Null';
            }

        }

        return $this->response($operation, $direction, $counter, $open, $close, $middle, $min, $max);
    }

    private function response($operation = 'Null', $direction = 'Null', $counter = 'Null', $open = 'Null', $close = 'Null', $middle = 'Null', $min = 'Null', $max = 'Null')
    {
        return $operation . "|" . $direction . "|" . $counter . "|" . $open . "|" . $close . "|" . $middle . "|" . $min . "|" . $max;
    }
}
