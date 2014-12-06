<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Thumb extends AbstractHelper {

    protected $scriptUrl = '/scripts/timthumb/timthumb.php';

    public function __invoke($src, $width = 0, $heigh = 0) {
        $scriptUrl = $this->scriptUrl;
        $domain = parse_url($src);
        return "$scriptUrl?src=$domain[path]&w=$width&h=$heigh";
    }
}