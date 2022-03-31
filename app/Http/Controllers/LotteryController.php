<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LotteryController extends Controller
{
  public function odds_results(Request $request){
    $n = $request->balls_main_pool;
    $r = $request->balls_drawn;

    $numerator_value = $this->calculate_combinations($n, $r);

    $data_set = array();
    for($m = $r; $m > 0; $m--){
      $denominator_part_one = $this->calculate_combinations($r, $m);
      $denominator_part_two = $this->calculate_combinations(($n - $r), ($r - $m));
      $result_value = round($numerator_value / ($denominator_part_one * $denominator_part_two));
      $result_value = number_format($result_value);

      $item = array("number_matched" => $m, "calucated_odds" => "1 of " . $result_value);

      array_push($data_set,$item);
    }

    return response()->json($data_set, 200);
  }

  private function calculate_combinations($n, $r){
    // change $r to $n in denomiator first value before muliplication
    return $this->factorial($n)  / ($this->factorial($r) * $this->factorial($n-$r));
  }

  private function factorial($n) {
    $fact = 1;
    while($n > 0)
    {
      $fact = $fact * $n;
      $n--;
    }
    return $fact;
   }
}
