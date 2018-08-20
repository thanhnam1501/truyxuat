<?php

namespace App\Helpers;

use App\Models\RoundCollection;
use App\Models\Organization;
use Auth;

class ViewFile {

  /**
   * format money
   *
   *
   * @param string $str: 100,000...; $symbol: vnđ, đ, usd...;
   * @return return $str in integer: 100000
   */
  public static function check($data){
    // $data = ['key', 'link'];
    $or = Organization::find($data['organization_id']);
    $or->name = str_slug($or->name);
    $id = str_pad($data['parent_id'], 6, '0', STR_PAD_LEFT);
    $number_input = str_pad($data['number_input'], 2, '0', STR_PAD_LEFT);

    $file_name = "S".$data['number_step']."-".$data['code_form']."-".$or->name."-".$id."-".$number_input.".pdf";

    return $file_name;
  }
}
?>
