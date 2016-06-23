<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function index(Request $request)
    {
        $data['currency'] = (!empty($request->input('curransy'))) ? $request->input('curransy') : 'eur';
        $data['bar'] = (!empty($request->input('bar'))) ? $request->input('bar') : date('Y-m-d H:i:00', time());
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
        $allVolume = 0;

        $maxRows = app('db')->table('st_' . $data['currency'])->where([['created_at', '>=', $data['bar']], ['tVolume', '>=', $data['volume']]])->get();
        $counterTemp = 1;
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
        }

        if (!empty($direction) and $counter >= $data['rows']){
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
                $rows = $rows;
                foreach ($rows as $row) {
                    $allVolume += $row->tVolume;
                }

                if ($direction == 'Buy' and $open > $close and $close <= $min) {
                    $operation = 'Sell';
                } elseif ($direction == 'Sell' and $open < $close and $close >= $max) {
                    $operation = 'Buy';
                }else{
                    $operation = 'Null';
                }

            }
        }
        return $this->response($operation,$direction,$counter,$open,$close,$min,$max);
    }

    private function response($operation = 'Null', $direction = 'Null', $counter = 'Null', $open = 'Null', $close = 'Null', $min = 'Null', $max = 'Null')
    {
        return $operation . "|" . $direction . "|" . $counter . "|" . $open . "|" . $close . "|" . $min . "|" . $max;
    }
}
