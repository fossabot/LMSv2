<?php

require_once APPPATH . '/PhpSpreadsheet/src/Bootstrap.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cFields
 *
 * @author dvlpserver
 */
class cexcel {

    //put your code here

    function __construct() {

        $this->CI = & get_instance();
        $this->CI->load->model('docrep/document_repository_model', 'docrepmodel', TRUE);



        //require_once APPPATH."/plugins/PhpSpreadsheet/src/PhpSpreadsheet/Spreadsheet.php";
        //$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        /*
          require_once APPPATH . '/PhpSpreadsheet/src/Bootstrap.php';
          $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
          $sheet = $this->SelectedWorksheet;
          $sheet->setCellValue('A1', 'Hello World !');


          $sheet = $this->SelectedWorksheet;
          $sheet->setCellValue('A1', 'Hello World !');

          $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
          $writer->save('/tmp/hello world.xlsx');
         */

        $this->printArea = array();
        $this->docrepdefault = -1;

        $this->rowFrom = null;
        $this->rowTo = null;
        $this->columnFrom = null;
        $this->columnTo = null;
        $this->coordStart = null;
        $this->coordEnd = null;
    }

    public function setDocRep($docrep) {
        $this->docrepdefault = $docrep;
    }
    
    public function newSpreadSheet($title = '') {
        $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $this->SelectedWorksheet = $this->spreadsheet->getActiveSheet();

        if ($title != '') {
            $this->SelectedWorksheet->setTitle($title);
        }

        $this->chartSheet = $this->spreadsheet->createSheet();
        $this->chartSheet->setTitle('SheetCalc');
        $this->chartSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet::SHEETSTATE_VERYHIDDEN);

        \PhpOffice\PhpSpreadsheet\Shared\Font::setTrueTypeFontPath('/usr/share/fonts/truetype/msttcorefonts/');

        $this->spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $this->spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $this->spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        \PhpOffice\PhpSpreadsheet\Shared\Font::setAutoSizeMethod(\PhpOffice\PhpSpreadsheet\Shared\Font::AUTOSIZE_METHOD_EXACT);
        \PhpOffice\PhpSpreadsheet\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        $this->fillBackground = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
        
        $this->SelectedWorksheet->getPageMargins()->setTop(0.75);
        $this->SelectedWorksheet->getPageMargins()->setRight(0.25);
        $this->SelectedWorksheet->getPageMargins()->setLeft(0.25);
        $this->SelectedWorksheet->getPageMargins()->setBottom(0.75);
        
    }
    
    public function setFontDefault($name, $size) {
        $this->spreadsheet->getDefaultStyle()->getFont()->setName($name);
        $this->spreadsheet->getDefaultStyle()->getFont()->setSize($size);

    }

    public function setTitle($title) {
        $this->spreadsheet->getActiveSheet()->setTitle($title);
    }

    public function newSheet($title, $select = true) {
        $this->spreadsheet->createSheet()->setTitle($title);

        if ($select) {
            $this->selectActiveSheet($title);
        }
    }

    public function wrapText($column) {
        $this->SelectedWorksheet->getStyle($column."1:$column".$this->SelectedWorksheet->getHighestRow())->getAlignment()->setWrapText(true); 

    }
    
    public function setRepeatingHeader($rowstart, $rowend) {
        $this->SelectedWorksheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($rowstart, $rowend);
    }

    public function resetPrintArea() {
        $this->printArea = array();
    }

    public function setPaperSize($size) {

        switch ($size) {
            case 'A4':
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                break;

            case 'A3':
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3;
                break;

            case 'LETTER':
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER;

                break;


            default:
                break;
        }

        $this->SelectedWorksheet->getPageSetup()->setPaperSize($size);
    }

    public function setPaperOrientation($orientation) {
        switch ($orientation) {
            case 'L':
                $ori = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                break;
            case 'P':
                $ori = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT;
                break;


            default:
                break;
        }

        $this->SelectedWorksheet->getPageSetup()->setOrientation($ori);
    }

    public function setPrintArea() {
        array_push($this->printArea, $this->coordStart . ':' . $this->coordEnd);
    }

    public function selectActiveSheet($title) {
        $this->spreadsheet->setActiveSheetIndexByName($title);
        $this->SelectedWorksheet = $this->spreadsheet->getActiveSheet();
    }

    
    public function setAlignVCenter() {
        $this->SelectedWorksheet->getStyle($this->getSelectedAreaString())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

    public function setAlignVTop() {
        $this->SelectedWorksheet->getStyle($this->getSelectedAreaString())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
    }

    public function setAlignVBottom() {
        $this->SelectedWorksheet->getStyle($this->getSelectedAreaString())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
    }

    public function setAlignHCenter() {

        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function setAlignHRight() {

        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    }

    public function setAlignHLeft() {

        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    }

    public function setColumnCollapsed($column, $bool) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getColumnDimensionByColumn($column - 1)->setCollapsed($bool);
    }

    public function setColumnVisible($column, $bool) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getColumnDimensionByColumn($column - 1)->setVisible($bool);
    }

    public function setItemString($row, $column, $value) {
        $sheet = $this->SelectedWorksheet;
        $value = trim($value);
        
        
        //$style = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($column - 1, $row)->getStyle();
        
        if (is_numeric($value)) {
            $sheet->setCellValueExplicitByColumnAndRow($column - 1, $row, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        } else {
            $sheet->getCellByColumnAndRow($column - 1, $row)->setDataType(\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueByColumnAndRow($column - 1, $row, $value);
        }
        
        
        
        
        //$sheet->setCellValueExplicitByColumnAndRow($column - 1, $row, trim($value), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        
        
        //$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        //$spreadsheet->getActiveSheet()->getCellByColumnAndRow($column - 1, $row)->setDataType(\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
        
        //$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        //
        //$spreadsheet->getActiveSheet()->setCellValueExplicitByColumnAndRow($column - 1, $row, trim($value), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        
        
    }

    public function addChartBar($rowLabelStart, $colLabelStart, $rowLabelFinish, $colLabelFinish, $rowValueStart, $colValueStart, $rowValueFinish, $colValueFinish) {

        $sheet = $this->SelectedWorksheet;

        $colValueStart = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($colValueStart - 1);
        $colValueFinish = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($colValueFinish - 1);

        $colLabelStart = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($colLabelStart - 1);
        $colLabelFinish = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($colLabelFinish - 1);

        $title = $sheet->getTitle();
        $dataSeriesLabels = [
            new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', $title . '!$B$1', null, 1)
        ];


        $dataSeriesValues = [
            new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', $title . '!$' . $colValueStart . '$' . $rowValueStart . ':$' . $colValueFinish . '$' . $rowValueFinish . '', null, 4)
        ];


        $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_BARCHART, // plotType
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_STANDARD, // plotGrouping
                range(0, count($dataSeriesValues) - 1), // plotOrder
                $dataSeriesLabels, // plotLabel
                null, // plotCategory
                $dataSeriesValues        // plotValues
        );


        $series->setPlotDirection(\PhpOffice\PhpSpreadsheet\Chart\DataSeries::DIRECTION_COL);

//	Set the series in the plot area
        $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea(null, [$series]);
//	Set the chart legend
        $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, null, false);

        $title = new \PhpOffice\PhpSpreadsheet\Chart\Title('Test Column Chart');
        $yAxisLabel = new \PhpOffice\PhpSpreadsheet\Chart\Title('Value ($k)');

//	Create the chart
        $chart = new \PhpOffice\PhpSpreadsheet\Chart(
                'chart1', // name
                $title, // title
                $legend, // legend
                $plotArea, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                null, // xAxisLabel
                $yAxisLabel  // yAxisLabel
        );

//	Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('A3');
        $chart->setBottomRightPosition('H20');

//	Add the chart to the worksheet
        $sheet->addChart($chart);
    }

    public function setItemProgress($row, $column, $value) {
        $this->chartSheet->setCellValueByColumnAndRow(0, $row, $value - 0);
        $this->chartSheet->setCellValueByColumnAndRow(1, $row, 100 - $value);

        $col1 = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex(0);
        $col2 = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex(1);

        $dataSeriesValues2 = [
            new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', 'SheetCalc!$' . $col1 . '$' . $row . ':$' . $col2 . '$' . $row, null, 2),
        ];

//	Build the dataseries
        $series2 = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_PIECHART, // plotType
                null, // plotGrouping (Donut charts don't have any grouping)
                range(0, count($dataSeriesValues2) - 1), // plotOrder
                null, // plotLabel
                null, // plotCategory
                $dataSeriesValues2        // plotValues
        );
        //	Set up a layout object for the Pie chart
        $layout2 = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
        $layout2->setShowVal(false);
        $layout2->setShowCatName(false);
        $layout2->setShowSerName(false);


//	Set the series in the plot area
        $plotArea2 = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea($layout2, [$series2]);
        $plotArea2->getLayout()->setShowLeaderLines(false);
        $title = new \PhpOffice\PhpSpreadsheet\Chart\Title($value . '%');
        //$legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_TOPRIGHT, null, false);
//	Create the chart
        $chart2 = new \PhpOffice\PhpSpreadsheet\Chart(
                'chart2' . $row, // name
                null, // title
                null, // legend
                $plotArea2, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                null, // xAxisLabel
                null   // yAxisLabel		- Like Pie charts, Donut charts don't have a Y-Axis
        );

//	Set the position where the chart should appear in the worksheet
        //die ($this->coordStart);
        $this->selectArea($row, $column);
        $chart2->setTopLeftPosition($this->coordStart);
        $this->selectArea($row + 1, $column + 1);

        $chart2->setBottomRightPosition($this->coordStart, -1, -1);
//	Add the chart to the worksheet
        $this->SelectedWorksheet->addChart($chart2);
    }

    public function setItemFloat($row, $column, $value, $decimal = 4) {
        $sheet = $this->SelectedWorksheet;

        if ($decimal != 0) {
            $format = "#,##0." . str_repeat('0', $decimal);
            $value = round($value, $decimal);
        } else {
            $format = '#,##0';
            $value = round($value, 0);
        }



        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $sheet->setCellValueByColumnAndRow($column - 1, $row, $value);
        $sheet->getStyleByColumnAndRow($column - 1, $row)->getNumberFormat()->setFormatCode($format);
    }

    public function setItemPercentual($row, $column, $value) {
        $sheet = $this->SelectedWorksheet;

        $sheet->setCellValueByColumnAndRow($column - 1, $row, $value / 100);
        $sheet->getStyleByColumnAndRow($column - 1, $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);
    }

    public function setItemDate($row, $column, $value) {
        $sheet = $this->SelectedWorksheet;
        $value = $this->CI->cdbhelper->dateGridtoDb($value);
        if ($value == 'null') {
            return;
        }

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }




        $sheet->setCellValueByColumnAndRow($column - 1, $row, $value);

        $sheet->getStyleByColumnAndRow($column - 1, $row)
                ->getNumberFormat()
                ->setFormatCode('mm/dd/yyyy');
    }

    public function selectArea($rowfrom, $columnfrom, $rowto = null, $columnto = null) {
        $this->rowFrom = $rowfrom;
        $this->rowTo = $rowto;
        $this->columnFrom = $columnfrom - 1;
        $this->columnTo = $columnto - 1;

        $this->coordStart = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($columnfrom - 1) . $rowfrom;
        $this->coordEnd = null;
        if ($columnto != null) {
            $this->coordEnd = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($columnto - 1) . $rowto;
        }
    }

    public function getSelectedAreaString() {
        $coord = $this->coordStart;

        if ($this->coordEnd != null) {
            $coord = $coord . ':' . $this->coordEnd;
        }

        return $coord;
    }

    public function setColumnWidth($column, $width) {
        $column = $column - 1;
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $sheet->getColumnDimensionByColumn($column)->setWidth($width);
    }

    public function setColumnWidthAuto($column) {
        $column = $column - 1;
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }


        $sheet->getColumnDimensionByColumn($column)->setAutoSize(true);
    }

    public function setRowHeight($line, $height) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getRowDimension($line)->setRowHeight($height);
    }

    public function setRowHeightAuto($line) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getRowDimension($line)->setRowHeight(-1);
    }

    public function setBorderThin() {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }

    public function setBorderMedium() {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }

    public function setBorderThick() {

        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }

    public function setBorderOuterThin() {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }

    public function setBorderOuterMedium() {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'outline' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }

    public function setBorderOuterThick() {

        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
                ),
            ),
        );
        $sheet->getStyle($this->getSelectedAreaString())
                ->applyFromArray($styleArray);
    }
    
    
    
    
    
    
    
    
    public function setBorderColor($color) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getBorders()
                ->getAllBorders()->getColor()->setRGB($color);
    }

    public function setBackgroundColor($color, $end = null) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getFill()->setFillType($this->fillBackground)->getStartColor()->setRGB($color);


        if ($end != null) {
            $sheet->getStyle($this->getSelectedAreaString())
                    ->getFill()->setFillType($this->fillBackground)->getEndColor()->setRGB($end);
        }
    }

    public function setFooter($footer, $position) {
        $position = '&'.$position;
        
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }

        
        $sheet->getHeaderFooter()->setOddFooter($position  . $footer);
        ;
    }
    
    public function addPageNumberFooter($position) {
        $this->setFooter('Page &P of &N' , $position);
    }
   

    public function setFontBold($setbold) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getFont()->setBold($setbold);
    }

    public function setFontItalic($setitalic) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getFont()->setItalic($setitalic);
    }

    public function setFontColor($color) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getFont()->getColor()->setRGB($color);
    }

    
    public function setShowGridLines($bool ){
         $this->SelectedWorksheet->setShowGridlines($bool);

    }
    
    public function setFontSize($size) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        
        $sheet->getStyle($this->getSelectedAreaString())->getFont()->setSize($size);
    }

    public function setFontName($name) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $sheet->getStyle($this->getSelectedAreaString())
                ->getFont()->setName($name);
    }

    public function setBackGroundFillSolid() {
        $this->fillBackground = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
    }

    public function setBackGroundFillGradient() {
        $this->fillBackground = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR;
    }

    public function mergeCells() {
        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }
        $this->SelectedWorksheet->mergeCellsByColumnAndRow($this->columnFrom, $this->rowFrom, $this->columnTo, $this->rowTo);
    }

    public function unMergeCells() {
        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }
        $this->SelectedWorksheet->unmergeCellsByColumnAndRow($this->columnFrom, $this->rowFrom, $this->columnTo, $this->rowTo);
    }

    public function pixelsToPoints($pixels) {
        return PhpOffice\PhpSpreadsheet\Shared\Drawing::pixelsToPoints($pixels);
    }

    public function pointsToPixels($points) {
        return PhpOffice\PhpSpreadsheet\Shared\Drawing::pointsToPixels($points);
    }

    public function pixelsToCellDimension($value) {
        $defaultFont = $this->spreadsheet->getDefaultStyle()->getFont();
        return PhpOffice\PhpSpreadsheet\Shared\Drawing::pixelsToCellDimension($value, $defaultFont);
    }

    public function cellDimensionToPixels($value) {
        $defaultFont = $this->spreadsheet->getDefaultStyle()->getFont();
        return PhpOffice\PhpSpreadsheet\Shared\Drawing::cellDimensionToPixels($value, $defaultFont);
    }

    public function addPicture($row, $column, $picture, $maxHeight = 0, $maxWidth = 0) {
        $sheet = $this->SelectedWorksheet;

        if (false) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $this->SelectedWorksheet;
        }


        $this->selectArea($row, $column);
        $col = $this->getSelectedAreaString();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($picture);

        $columnHeight = $this->pointsToPixels($sheet->getRowDimension($row)->getRowHeight());

        $drawing->setOffsetX(1);
        $drawing->setOffsetY(1);

        if ($maxWidth != 0 && $maxHeight != 0) {
            $drawing->setResizeProportional(false);
            $drawing->setHeight($maxHeight);
            $drawing->setWidth($maxWidth);
        } else {
            $drawing->setResizeProportional(true);



            $columnWidth = $sheet->getColumnDimensionByColumn($column - 1)->getWidth();

            if ($maxHeight == 0) {
                $drawing->setHeight($columnHeight - 4);

                $imgWidthPoints = $this->pixelsToCellDimension($drawing->getWidth());


                if ($columnWidth < $imgWidthPoints) {
                    $sheet->getColumnDimensionByColumn($column - 1)->setWidth($imgWidthPoints);
                }
            } else {
                $drawing->setHeight($maxHeight);
            }
        }


        $drawing->setWorksheet($this->SelectedWorksheet);
        $drawing->setCoordinates($col);
    }

    public function setFitToWidth($bool) {
        $this->SelectedWorksheet->getPageSetup()->setFitToWidth($bool ? 1 : 0);
    }

    public function setFitToHeight($bool) {
        $this->SelectedWorksheet->getPageSetup()->setFitToHeight($bool ? 1 : 0);
    }

    public function saveAsXLSX($filename) {

        if (count($this->printArea) > 0) {
            $this->SelectedWorksheet->getPageSetup()->setPrintArea(implode(',', $this->printArea));
        }


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->spreadsheet);
        if (file_exists($filename)) {
            unlink($filename);
        }

        $writer->save($filename);
        chmod($filename, 0777);
    }

    public function saveAsOutput($filename) {

        if (count($this->printArea) > 0) {
            //die (implode(',', $this->printArea));
            $this->SelectedWorksheet->getPageSetup()->setPrintArea(implode(',', $this->printArea));
        }


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);

        $writer->save('php://output');
    }

    public function cleanMemory() {
        $this->printArea = array();

        $this->spreadsheet->garbageCollect();
    }

    public function createExcelByGrid($title, $columns, $titlecolumns, $columngroup, $recordset, $rowheight = 100) {

        $array_column = array();
        $columnindex = 1;
        $columns = (array) $columns;
        $titlecolumns = (array) $titlecolumns;
        //$rowheight = $rowheight;
        $f = $this->CI->cfields;


        if (1 == 2) {
            $f = new Cfields();
        }

        foreach ($columns as $key => $value) {
            $value = (array) $value;

            if ((!isset($value['hidden']) || $value['hidden'] != 1 ) && isset($titlecolumns[$value['field']])) {

                $datacol = array('type' => $value['internaltype'], 'title' => $titlecolumns[$value['field']], 'columnIndex' => $columnindex);

                if (isset($value["render"])) {
                    $tst = explode(':', $value["render"]);
                    if (count($tst) == 2) {
                        $datacol['decimal'] = $tst[1];
                    }
                }

                $array_column[$value['field']] = $datacol;
                $columnindex ++;
            }
        }

        $columnindex --;


        $this->selectArea(1, 1, 1, $columnindex - 1);
        $this->mergeCells();
        $this->setItemString(1, 1, $title);
        $this->setBorderThin();
        $this->setFontSize(13);
        $this->setFontBold(true);

        $this->selectArea(1, $columnindex);
        $this->setItemDate(1, $columnindex, date('m/d/Y'));
        $this->setBorderThin();
        $this->setFontSize(13);
        $this->setFontBold(true);


        //cabecalhos
        foreach ($array_column as $key => $value) {
            $row = 2;

            $this->setItemString($row, $value['columnIndex'], $value['title']);
            $this->selectArea($row, $value['columnIndex']);
            $this->setFontBold(true);

            foreach ($recordset as $key2 => $record) {
                $row ++;
                $vlr = '';
                $columnIndex = $value['columnIndex'];
                if (isset($record[$key])) {
                    $vlr = $record[$key];
                }


                if ($columnIndex == 1) {
                    $this->setRowHeight($row, $rowheight);
                }


                switch ($value['type']) {
                    case $f->retTypeImageSku():
                        $this->addPicture($row, $columnIndex, $this->getImageSKU($vlr), $rowheight);


                        break;

                    case $f->retTypeImageSpec():

                        $this->addPicture($row, $columnIndex, $this->getImageSpec($vlr), $rowheight);

                        break;
                    
                    case $f->retTypeFirstPicture():
                        $this->addPicture($row, $columnIndex, $this->getFirstImageDocRep($this->docrepdefault, $vlr), $rowheight);
                        break;

                    case $f->retTypeInteger():
                    case $f->retTypeFloat():
                    case $f->retTypeNum():

                        $vdec = 0;
                        if (isset($value['decimal'])) {
                            $vdec = $value['decimal'];
                        }

                        $this->setItemFloat($row, $columnIndex, $vlr, $vdec);

                        break;

                    case $f->retTypePercentual():
                    case $f->retTypeProgressBar():

                        $this->setItemPercentual($row, $columnIndex, $vlr);
                        break;




                    case $f->retTypeDate():
                    case $f->retTypeDeactivated():
                        $this->setItemDate($row, $columnIndex, $vlr);

                        break;

                    default:
                        $this->setItemString($row, $columnIndex, $vlr);

                        break;
                }
            }

            if ($value['type'] != $f->retTypeImageSku() && $value['type'] != $f->retTypeImageSpec()) {
                $this->setColumnWidthAuto($columnIndex);
            }
        }


        $this->selectArea(2, 1, 2, $columnindex);
        $this->setBorderThin();
        $this->setBackgroundColor('D3D3D3');
        /*
          $this->SelectedWorksheet->fromArray(
          [
          ['', 2010, 2011, 2012],
          ['Q1', 12, 15, 21],
          ['Q2', 56, 73, 86],
          ['Q3', 52, 61, 69],
          ['Q4', 30, 32, 0],
          ]
          ); */

//	Set the X-Axis Labels
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
//	Set the Data values for each data series we want to plot
//		Datatype
//		Cell reference for data
//		Format Code
//		Number of datapoints in series
//		Data values
//		Data Marker
    }

    public function getImageSKU($cd_shoe_sku) {
        $sql = 'SELECT * FROM retShoeSkuPictures(' . $cd_shoe_sku . ') where cd_document_repository != -1 ORDER BY nr_order, ds_spec_picture_type LIMIT 1';

        $resultset = $this->CI->cdbhelper->basicSQLArray($sql);

        if (count($resultset) == 0) {
            $resourcePath = $this->CI->cdbhelper->getSystemParameters('FULL_RESOURCE_PATH');
            $filename = $resourcePath . 'missing-image-rect.png';
        } else {
            $filename = $resultset[0]['ds_document_file_thumbs_path'];
        }


        return $filename;
    }

    public function setItemLabel($row, $column, $value) {

        $this->selectArea($row, $column);
        $this->setItemString($row, $column, $value);
        $this->setFontBold(true);
        $this->setBorderThin();
        $this->setBackgroundColor('D3D3D3');
    }

    public function getImageSpec($cd_generic_shoe_specification) {
        $sql = 'SELECT * FROM retGenSpecPictures(' . $cd_generic_shoe_specification . ') where cd_document_repository != -1 ORDER BY nr_order, ds_spec_picture_type LIMIT 1';

        $resultset = $this->CI->cdbhelper->basicSQLArray($sql);

        if (count($resultset) == 0) {
            $resourcePath = $this->CI->cdbhelper->getSystemParameters('FULL_RESOURCE_PATH');
            $filename = $resourcePath . 'missing-image-rect.png';
        } else {
            $filename = $resultset[0]['ds_document_file_thumbs_path'];
        }


        return $filename;
    }

    
    public function getFirstImageDocRep($id, $pk) {
        $filename = $this->CI->docrepmodel->getFirstPicture($id, $pk);

        if (!$filename) {
            $resourcePath = $this->CI->cdbhelper->getSystemParameters('FULL_RESOURCE_PATH');
            $filename = $resourcePath . 'missing-image-rect.png';
            //die ($filename);
        }



        return $filename;
    }
    
    public function createExcelGrid($startrow, $startcol, $columns, $recordset, $rowheight = 100, $showTitle = true) {

        $array_column = array();
        $columnindex = 1;
        $columns = (array) $columns;
        //$rowheight = $rowheight;
        $f = $this->CI->cfields;


        if (1 == 2) {
            $f = new Cfields();
        }

        foreach ($columns as $key => $value) {
            $value = (array) $value;

            $datacol = array('type' => $value['internaltype'], 'title' => $value['caption'], 'field' => $value['field']);

            if (isset($value["render"])) {
                $tst = explode(':', $value["render"]);
                if (count($tst) == 2) {
                    $datacol['decimal'] = $tst[1];
                }
            }

            array_push($array_column, $datacol);
        }



        //cabecalhos
        foreach ($array_column as $key => $value) {
            $row = $startrow;
            $col = $key + $startcol;

            if ($showTitle) {
                $this->setItemLabel($row, $col, $value['title']);
                $this->selectArea($row, $col);
                $this->setFontBold(true);
            }

            foreach ($recordset as $key2 => $record) {
                $row ++;
                $vlr = '';

                if (isset($record[$value['field']])) {
                    $vlr = $record[$value['field']];
                }

                switch ($value['type']) {
                    case $f->retTypeImageSku():
                        $this->addPicture($row, $col, $this->getImageSKU($vlr), $rowheight);

                        break;

                    case $f->retTypeImageSpec():

                        $this->addPicture($row, $col, $this->getImageSpec($vlr), $rowheight);


                        break;


                    case $f->retTypeInteger():
                    case $f->retTypeFloat():
                    case $f->retTypeNum():

                        $vdec = 0;
                        if (isset($value['decimal'])) {
                            $vdec = $value['decimal'];
                        }

                        $this->setItemFloat($row, $col, $vlr, $vdec);

                        break;

                    case $f->retTypePercentual():
                    case $f->retTypeProgressBar():

                        $this->setItemPercentual($row, $col, $vlr);
                        break;




                    case $f->retTypeDate():
                    case $f->retTypeDeactivated():
                        $this->setItemDate($row, $col, $vlr, $vdec);

                        break;

                    default:
                        $this->setItemString($row, $col, $vlr);

                        break;
                }
            }

            if ($value['type'] != $f->retTypeImageSku() && $value['type'] != $f->retTypeImageSpec()) {
                $this->setColumnWidthAuto($col);
            }
        }
        return $row;
    }

}
