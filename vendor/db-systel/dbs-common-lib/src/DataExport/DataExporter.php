<?php
namespace DbSystel\DataExport;

use DbSystel\DataObject\AbstractDataObject;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DataExporter
{

    /** @var string */
    const EXPORT_FORMAT_JSON = 'json';
    /** @var string */
    const EXPORT_FORMAT_XML = 'xml';
    /** @var string */
    const XML_DEFAULT_ROOT_ELEMENT = 'file_transfer_request';
    /** @var string */
    const XML_DEFAULT_ELEMENT_NAME = 'item';

    /** @var Serializer */
    protected $serializer;

    public function __construct()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setIgnoredAttributes(['__initializer__', '__cloner__', '__isInitialized__']);
        $normalizer->setCircularReferenceHandler(function ($object) {
            try {
                $return = $object->getId();
            } catch (\Error $exception) {
                $return = null;
            }
            $return = null;
            return $return;
        });
        $callbackDateTime = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('Y-m-d H:i:s')
                : null;
        };
        $normalizer->setCallbacks(['created' => $callbackDateTime, 'updated' => $callbackDateTime]);
        $normalizers = [$normalizer];
        $this->serializer = new Serializer($normalizers);
    }

    public function exportToJson(AbstractDataObject $dataObject)
    {
        $data = $this->serializer->normalize($dataObject);
        $data = $this->utf8ize($data);
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function exportToXml(AbstractDataObject $dataObject)
    {
        $data = $this->serializer->normalize($dataObject);
        $data = $this->utf8ize($data);
        $xml = new \SimpleXMLElement('<' . self::XML_DEFAULT_ROOT_ELEMENT . ' />');
        $this->arrayToXml($data, $xml);
        $domDocument = dom_import_simplexml($xml)->ownerDocument;
        $domDocument->formatOutput = true;
        $xmlString = $domDocument->saveXML();
        return $xmlString;
    }

    protected function utf8ize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->utf8ize($value);
            }
        } else if (is_string ($data)) {
            return utf8_encode($data);
        }
        return $data;
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
