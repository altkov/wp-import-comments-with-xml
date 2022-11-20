<?php

namespace ICWX\Tools;

use DOMDocument;
use XMLReader;

class Xml {
    private XMLReader $reader;

    public function __construct(string $path) {
        $this->reader = new XMLReader;
        $this->reader->open($path);
    }

    public function readElements(string $element) : \Generator {
        while ($this->reader->read() && $this->reader->name !== $element);

        while ($this->reader->name === $element) {
            $xmlData = simplexml_load_string($this->reader->readOuterXml());
            $json = json_encode($xmlData);

            yield json_decode($json, true);

            $this->reader->next($element);
        }
    }
}