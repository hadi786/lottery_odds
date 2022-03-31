<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LotteryController extends Controller
{
  public function odds_results(Request $request){
    $n = $request->balls_main_pool;
    $r = $request->balls_drawn;

    $numerator_value = $this->calculate_odds($n, $r);

    for($m =  1; $m <= $n; $m++){
        $denominator_part_one = $this->calculate_odds($r, $m);
        $denominator_part_two = $this->calculate_odds(($n - $r), ($r - $m));
        $data_set[] = $numerator_value / ($denominator_part_one * $denominator_part_two);
    }

    return response()->json($data_set, 200);
  }

  private function calculate_odds($n, $r){
    return $this->factorial($n)  / ($this->factorial($r) * $this->factorial($n-$r));
  }

  private function factorial($int) {
    if ($int == 0) {
     return 1;
    }
    return $this->factorial($int-1) * $int;
   }
}
