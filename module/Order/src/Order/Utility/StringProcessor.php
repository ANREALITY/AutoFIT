<?php
namespace Order\Utility;

class StringProcessor
{
    public function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        $haystackEndsWithNeedle = false; 
        $expectedNeedlePosition = strlen($haystack) - strlen($needle);
        $actualNeedlePosition = strpos($haystack, $needle, $expectedNeedlePosition);
        
        $return = $needle === '' || ($expectedNeedlePosition >= 0 && $actualNeedlePosition !== false);

        return $return;
    }
}
