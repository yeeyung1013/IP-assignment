<?php

/**
 * Description of dataProtection
 *
 * @author Loh JW
 */
class dataProtection {

    public function purgeTemporaryData($data) {
        foreach($data as &$value) {
            $value = null;
        }
        unset($data);
    }
    
    public function disableClientSideCaching() {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    }

}
