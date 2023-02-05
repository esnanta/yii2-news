<?php

namespace backend\editor;

/**
 * Class File
 * @package bajadev\ckeditor\models
 * @author Bajadev <info@bajadev.hu>
 * @link http://bajadev.hu
 */
class File extends \bajadev\ckeditor\models\File
{
    /**
     * Method: rules
     * @return array
     * @author Bajadev <info@bajadev.hu>
     * @link http://bajadev.hu
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [
                ['file'],
                'file',
                'extensions' => 'jpg,bmp,gif,png,jpeg','maxSize' => (1 * 1024 * 1024), 'tooBig' => 'Limit is 1 MB',
            ],
        ];
    }
}