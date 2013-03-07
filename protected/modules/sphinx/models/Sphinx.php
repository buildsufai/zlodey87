<?php

/**
 * класс для работы со сфинксом
 */
class Sphinx
{

    /*
     * источник подключения к сфинксу
     */
    protected static $_sphinxCon = null;

    /*
     * возвращает источник подключения к сфинксу
     * @return source
     */
    public static function getSphinxConnection()
    {
        if (null === self::$_sphinxCon) {
            self::$_sphinxCon = new PDO('mysql:host=127.0.0.1;port=9306');
        }

        return self::$_sphinxCon;
    }

    // возвращает сгенер-й id для таблицы rt_content
    public static function getSphinxId($id, $tableName)
    {
        return crc32(md5($tableName . $id));
    }
    
    /*
     * клиент сфинкса
     */
    protected static $_sphinxClient = null;

    /*
     * возвращает клиента сфинкса
     * @return source
     */
    public static function getSphinxClient()
    {
        if (null === self::$_sphinxClient) {
            require_once '/protected/components/sphinxapi.php';
            self::$_sphinxClient = new SphinxClient();
            self::$_sphinxClient->SetServer('localhost', 9312);
        }

        return self::$_sphinxClient;
    }

    /*
     * выполнить запрос
     * @return result
     */
    public static function Query($q)
    {
        $cl = self::getSphinxClient();
        $cl->SetRankingMode(SPH_RANK_WORDCOUNT);
        $cl->SetMatchMode(SPH_MATCH_EXTENDED2);
        $result = $cl->Query($q);
        if ($result === false) {
            throw new Exception(500, "Ошибка запроса: " . $cl->GetLastError() . ".\n");
        } else {
            if ($cl->GetLastWarning()) {
                throw new ChttpException(500, "ВНИМАНИЕ: " . $cl->GetLastWarning());
            }
            $data = array();
            if (!empty($result["matches"])) {
                // если все нормально и есть рез-ы поиска, то пройтись по ним 
                // и подготовить массив для постр-й навигации
                $i = 0;
                foreach ($result["matches"] as $product) {
                    $data[] = array('id' => ++$i, 't' => $product['attrs']['t'], 'price' => $product['attrs']['price'],
                        'note' => $product['attrs']['note'], 'alias' => $product['attrs']['alias']);
                }
            }
        }
        return $data;
    }

}