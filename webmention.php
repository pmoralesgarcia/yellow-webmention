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
            $output = '<div class="wm_summary">';
            $output .= '<ul class="menicons">';
            $output .= '<li class="micon"><i class="fa-solid fa-star"></i>&nbsp<span id="wm_like1"></span>&nbsp; likes</li>';
            $output .= '<li class="micon"><i class="fa-regular fa-file"></i>&nbsp<span id="wm_ment1"></span>&nbsp; mentions</li>';
            $output .= '<li class="micon"><i class="fa-regular fa-comment"></i>&nbsp<span id="wm_reply1"> </span>&nbsp; </li>';
            $output .= '<li class="micon"><i class="fa-solid fa-repeat"></i>&nbsp<span id="wm_repost1"></span>&nbsp;reposts</li>';
            $output .= '<li class="micon"><i class="fa-regular fa-bookmark"></i>&nbsp<span id="wm_bkmk1"></span>&nbsp;bookmarks</li>';
            $output .= '</div>';
            $output .= '<hr>';
            $output .= '<div id="mentionpanel"></div>';
            
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
                $output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}icons.css\" />\n";

            }
            return $output;
        }
}