<?php

class Parser_Model_Comics
{
    public function parse($xkcdId = 1)
    {
        $link = 'http://xkcd.com/' . (int)$xkcdId;
        $client = new Zend_Http_Client($link);
        $response = $client->request();
        $body = $response->getBody();

        $dom = new Zend_Dom_Query();
        $dom->setDocumentHtml($body);

        $comics = array();

        $comics['xkcd_title'] = $dom->query('div.s > h1')->current()->nodeValue;
        $image = $dom->query('div.s > img')->current();
        $imageSrc = $image->getAttribute('src');
        $comics['xkcd_description'] = $image->getAttribute('title');
        $comics['xkcd_transcription'] = $dom->query('div#transcript')->current()->nodeValue;
        $idString = $dom->query('div.s > h3')->current()->nodeValue;

        $pattern = '/\/([0-9]+)\//';
        preg_match($pattern, $idString, $idMatches);
        $comics['xkcd_id'] = (int) $idMatches[1];


        $pattern = '/\/([^\/]+)$/';
        preg_match($pattern, $imageSrc, $filenameMatches);
        $comics['xkcd_filename'] = $filenameMatches[1];

        if ($comics['xkcd_id']) {
            $comicsTable = new Parser_Model_DbTable_Comics();
            $select = $comicsTable->select()
                                   ->where('xkcd_id = ?', $comics['xkcd_id']);
            $comicsResult = $comicsTable->fetchRow($select);
            $imageFile = file_get_contents($imageSrc);
            $localPath = realpath(APPLICATION_PATH . '/../public/images/') . '/';
            if (!file_exists($localPath . $comics['xkcd_filename'])) {
                $imageFile = file_get_contents($imageSrc);
                if ($imageFile) {
                    file_put_contents($localPath . $comics['xkcd_filename'], $imageFile);
                }
            }
            if (count($comicsResult) > 0) {
                return $comicsResult->xkcd_id;
            }
            return $comicsTable->insert($comics);
        }
    }

    public function parseAll()
    {
        for ($i = 405; $i < 968; $i++) {
            $this->parse($i);
        }
    }
}