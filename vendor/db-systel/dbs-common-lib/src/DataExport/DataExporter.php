<?php
namespace DbSystel\DataExport;

use DbSystel\DataObject\AbstractDataObject;

class DataExporter
{

    const EXPORT_FORMAT_JSON = 'json';

    const EXPORT_FORMAT_XML = 'xml';

    const XML_DEFAULT_ROOT_ELEMENT = 'file_transfer_request';

    const XML_DEFAULT_ELEMENT_NAME = 'item';

    public function exportToJson(AbstractDataObject $dataObject)
    {
        return json_encode($dataObject, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function exportToXml(AbstractDataObject $dataObject)
    {
        $dataObjectVars = json_decode(json_encode($dataObject->jsonSerialize()), true);
        $xml = new \SimpleXMLElement('<' . self::XML_DEFAULT_ROOT_ELEMENT . ' />');
        $this->arrayToXml($dataObjectVars, $xml);
        $domxml = new \DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($xml->asXML());
        $xmlString = $domxml->saveXML();
        return $xmlString;
    }

    /**
     * Converts an $array to XML and
     * saves the result to the $xml argument.
     *
     * @param array $array
     * @param \SimpleXMLElement $xml
     * @return void
     */
    protected function arrayToXml($array, &$xml){
        foreach ($array as $key => $value) {
            if(is_array($value)){
                if(is_int($key)){
                    $key = self::XML_DEFAULT_ELEMENT_NAME;
                }
                $label = $xml->addChild($key);
                $this->arrayToXml($value, $label);
            }
            else {
                $xml->addChild($key, $value);
            }
        }
    }

}
