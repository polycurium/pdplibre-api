<?php

namespace App\Common;

trait XmlLoader
{
    /**
     * @throws \DOMException in case of invalid XML content
     */
    protected static function loadXml(string $xmlContent): \DOMDocument
    {
        $dom = new \DOMDocument();

        $result = @$dom->loadXML($xmlContent);
        if (!$result) {
            throw new \DOMException('Invalid XML.');
        }

        return $dom;
    }
}
