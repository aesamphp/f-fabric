<?php

namespace App\Services;

class XmlFileGenerator {

    private $fileName,
            $previousElement,
            $elements = [];

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function getFileName() {
        return $this->fileName;
    }
    
    public function setElements(Array $elements) {
        $this->elements = $elements;
    }
    
    public function getElements() {
        return $this->elements;
    }
    
    public function __construct($fileName, Array $elements = []) {
        $this->setFileName($fileName);
        $this->setElements($elements);
    }
    
    public function generate() {
        $writer = new \XMLWriter;
        $writer->openURI($this->getFileName());
        $writer->startDocument("1.0");
        $this->writeElements($writer, $this->getElements());
        $writer->endDocument();
        $writer->flush();
    }
    
    private function writeElements(&$writer, $elements) {
        foreach ($elements as $element => $value) {
            if (is_array($value)) {
                $this->previousElement = is_numeric($element) ? $this->previousElement : $element;
                $writer->startElement(is_numeric($element) ? str_singular($this->previousElement) : $element);
                $this->writeElements($writer, $value);
                $writer->endElement();
            } else {
                $this->writeElement($writer, $element, $value);
            }
        }
        return $writer;
    }
    
    private function writeElement(&$writer, $element, $value) {
        $writer->startElement($element);
        $writer->text($value);
        $writer->endElement();
        return $writer;
    }

}
