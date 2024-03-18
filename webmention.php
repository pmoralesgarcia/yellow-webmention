<?php
class YellowWebmention {
    const VERSION = "0.1.3";
    public $yellow;         // access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }

    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="webmention" && ($type=="block" || $type=="inline")) {
            $output .= '<div id="webmentions"></div>';
        }
        return $output;
    }

        // Handle page extra data
        public function onParsePageExtra($page, $name) {
            $output = null;
            if ($name=="header") {
                $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
                $output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}webmention.css\" />\n";
                $output .= "<script async type=\"text/javascript\" defer=\"defer\" src=\"{$extensionLocation}webmention.js\"></script>\n";
                $output .= "<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined\" rel=\"stylesheet\">";

            }
            return $output;
        }
}