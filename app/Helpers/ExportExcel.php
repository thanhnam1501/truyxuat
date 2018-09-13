<?php

namespace App\Helpers;

use DB;
use Auth;
use Excel;

class ExportExcel {

  public static function exportExcel($datas, $attributes, $properties)
  {

    $export = Excel::create($properties['filename'], function($excel) use($datas, $attributes, $properties) {

      $excel->sheet($properties['sheet'], function($sheet) use($datas, $attributes, $properties) {
          
          $sheet->setStyle([
            'font' => [
              'name'      =>  'Calibri',
              'size'      =>  12,
            ],
            'borders' => [
                'allborders' => [
                    'color' => [
                        'rgb' => '000000'
                    ]
                ]
            ]
          ]);

          $sheet->getRowDimension(1)->setRowHeight(5);

          $sheet->loadView('backend.admins.'.$properties['view'].'.excel')
                    ->with([
                      'datas' => $datas,
                      'attributes' => $attributes
                    ]);

          $sheet->getStyle('A1:'.$properties['lastColumn'].$properties['lastRow'])->getAlignment()->setWrapText(true);
      });

    })->download('xlsx');

    return $export;
  }
}
?>
