<?php

/**
 * модель словоформ
 */
class Wordform
{
    
    // путь до файла
    protected $_wfFile = null;
    
    public function __construct()
    {
        $this->_wfFile = $_SERVER['DOCUMENT_ROOT'] . '/protected/modules/wordform/wordforms.txt';
    }


    // вернуть текущюю словоформу
    public function getWordform($line)
    {
        $lines = file($this->_wfFile);
        list($badWord, $rightWord) = explode(' > ', $lines[--$line]);
        return array('id' => $line, 'bw' => $badWord, 'rw' => str_replace(array("\r\n", "\r", "\n"), '', $rightWord));
    }
    
    // вернуть сод-е файла со словоформами
    public function getWordforms()
    {
        $wordforms = array();
        $lines = file($this->_wfFile);
        foreach ($lines as $i => $line) {
            list($badWord, $rightWord) = explode(' > ', $line);
            $wordforms[] = array('id' => ++$i, 'bw' => $badWord, 'rw' => str_replace(array("\r\n", "\r", "\n"), '', $rightWord));
        }
        $options = array(
            'id' => 'id',
            'sort' => array('attributes' => array('id', 'bw', 'rw')),
            'pagination' => array('pageSize' => Yii::app()->params['pageSize'], 'pageVar' => 'page'),
            'totalItemCount' => count($wordforms)
            );
        return new CArrayDataProvider($wordforms, $options);
    }
    
    // проверить сущ-е не правильного варианта в правильных вариантах
    public function checkBW($bw)
    {
        $lines = file($this->_wfFile);
        foreach ($lines as $line) {
            list($badWord, $rightWord) = explode(' > ', $line);
            if ($bw == str_replace(array("\r\n", "\r", "\n"), '', $rightWord)) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    // проверить сущ-е правильного варианта в не правильных вариантах
    public function checkRW($rw)
    {
        $lines = file($this->_wfFile);
        foreach ($lines as $line) {
            list($badWord, $rightWord) = explode(' > ', $line);
            if ($rw == $badWord) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    // проверить сущ-е словоформы
    public function checkWF($bw, $rw, $id)
    {
        $lines = file($this->_wfFile);
        foreach ($lines as $k => $line) {
            list($badWord, $rightWord) = explode(' > ', $line);
            if ($bw == $badWord && $rw == str_replace(array("\r\n", "\r", "\n"), '', $rightWord) && $k !== $id) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    // добавить словоформу
    public function addWF($bw, $rw)
    {
        $line = "{$bw} > {$rw}\n";
        file_put_contents($this->_wfFile, $line, FILE_APPEND | LOCK_EX);
        return TRUE;
    }
    
    // редактировать словоформу
    public function updateWF($bw, $rw, $line)
    {
        $lines = file($this->_wfFile);
        $lines[$line] = "{$bw} > {$rw}\n";
        $fp = fopen($this->_wfFile, "w");
        fwrite($fp, implode(NULL, $lines));
        fclose($fp);
        return TRUE;
    }
    
    // удалить словоформу
    public function deleteWF($k)
    {
        $lines = file($this->_wfFile);
        unset($lines[--$k]);
        $fp = fopen($this->_wfFile, "w");
        fwrite($fp, implode(NULL, $lines));
        fclose($fp);
        return TRUE;
    }

}