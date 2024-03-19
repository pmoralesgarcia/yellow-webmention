<?php
class YellowWebmention {
    const VERSION = "0.1.9";
    public $yellow;         // access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }

    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="webmention" && ($type=="block" || $type=="inline")) {
            $output = '<div class="webmention">';
            $output .= '<ul class="menicons">';
            $output .= '<ul class="menicons">';
            $output .= '<li class="micon"><i class="material-icons">star_border</i><span id="wm_like1"></span>&nbsp;</li>';
            $output .= '<li class="micon"><i class="material-icons-outlined">description</i><span id="wm_ment1"></span>&nbsp;</li>';
            $output .= '';
            $output .= '<li class="micon"><i class="material-icons">chat_bubble_outline</i><span id="wm_reply1"></span></li>';
            $output .= '';
            $output .= '<li class="micon"><i class="material-icons">repeat</i><span id="wm_repost1"></span></li>';
            $output .= '';
            $output .= '<li class="micon"><i class="material-icons">bookmark_border</i><span id="wm_bkmk1"></span>&nbsp;</li>';
            $output .= '';
            $output .= '</div>';
            $output .= '<hr>';
            $output .= '<div id="mentionpanel"></div>';
            $output .= '</div>';

            
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
                $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}icon.css\" />\n";

            }
            return $output;
        }
}