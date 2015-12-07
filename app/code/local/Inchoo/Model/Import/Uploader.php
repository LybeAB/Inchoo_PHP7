<?php
/**
 * Created on: 07.12.15.
 * Inchoo d.o.o.
 * @author Ivan Čurdinjaković <ivan.curdinjakovic@inchoo.net>
 */ 
class Inchoo_PHP7_Model_Import_Uploader extends Mage_ImportExport_Model_Import_Uploader
{
    protected function _validateFile()
    {
        $filePath = $this->_file['tmp_name'];
        if (is_readable($filePath)) {
            $this->_fileExists = true;
        } else {
            $this->_fileExists = false;
        }

        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$this->checkAllowedExtension($fileExtension)) {
            throw new Exception('Disallowed file type.');
        }
        //run validate callbacks
        foreach ($this->_validateCallbacks as $params) {
            if (is_object($params['object']) && method_exists($params['object'], $params['method'])) {
                $params['object']->{$params['method']}($filePath);
            }
        }
    }
}