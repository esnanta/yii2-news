<?php
namespace common\helper;

use Yii;

use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

class ReportCloud {
    
    public static function getBorderStyle(){
        $border = (new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
            ->setBorderRight(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
            ->build();

        return $border;
    }

    public static function getHeaderStyle(){
        $border = self::getBorderStyle();
        $headerStyle = (new StyleBuilder())
            ->setBackgroundColor(Color::LIGHT_BLUE)
            ->setBorder($border)
            //->setShouldWrapText(false)
            ->build();

        return $headerStyle;
    }

    public static function getRowStyle(){
        $border = self::getBorderStyle();
        $rowStyle = (new StyleBuilder())
            ->setBorder($border)
            //->setShouldWrapText(false)
            ->build();

        return $rowStyle;
    }

    public static function getWriterFactory(){
        return WriterEntityFactory::createODSWriter();
//        return WriterEntityFactory::createXLSXWriter();
    }
    
    public static function getFileExtension(){
        return '.ods';
//        return '.xlsx';
    }
}

?>