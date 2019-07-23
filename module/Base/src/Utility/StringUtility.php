<?php
namespace Base\Utility;

class StringUtility
{

    /**
     * Checks, whether the $string is valid.
     * It is valid, if it's prefixed by the $prefix.
     * There also may be multiple prefixs.
     * In this case at least one prefix match is enough.
     *
     * @param string $string
     * @param string|array $prefix
     * @return boolean
     */
    public function validateStringByPrefix(string $string, $prefix)
    {
        $valid = false;
        if (is_string($prefix)) {
            if (strpos($string, $prefix) === 0) {
                $valid = true;
            }
        } elseif (is_array($prefix)) {
            foreach ($prefix as $partPrefix) {
                if (strpos($string, $partPrefix) === 0) {
                    $valid = true;
                    break;
                }
            }
        }
        return $valid;
    }

}
