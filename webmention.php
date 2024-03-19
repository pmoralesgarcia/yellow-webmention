<?php
class YellowWebmention {
    const VERSION = "0.1.9";
    public $yellow;         // access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("webmentionEndpoint", "PUT_YOUR_WEBMENTION_ENDPOINT_HERE");
    }

    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="webmention" && ($type=="block" || $type=="inline")) {
            if ($this->yellow->extension->isExisting("icon")) {
                $output = "<div class=\"webmention\">";
                $output .= "<ul class=\"menicons\">";
                $output .= "<li class=\"micon\"><i class=\"icon fa-star-o\"></i><span id=\"wm_like1\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"icon fa-file-text-o\"></i><span id=\"wm_ment\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"icon fa-comment-o\"></i><span id=\"wm_reply\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"icon fa-refresh\"></i><span id=\"wm_repost\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"icon fa-bookmark-o\"></i><span id=\"wm_bkmk\"></span></li>";
                $output .= "</ul>";
                $output .= "</div>";
                $output .= "<hr>";
                $output .= "<div id=\"mentionpanel\"></div>";
                $output .= "</div>";
            } else {
                $output = "<div class=\"webmention\">";
                $output .= "<ul class=\"menicons\">";
                $output .= "<li class=\"micon\"><i class=\"material-icons\">star_border</i><span id=\"wm_like1\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"material-icons-outlined\">description</i><span id=\"wm_ment\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"material-icons\">chat_bubble_outline</i><span id=\"wm_reply\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"material-icons\">repeat</i><span id=\"wm_repost\"></span></li>";
                $output .= "<li class=\"micon\"><i class=\"material-icons\">bookmark_border</i><span id=\"wm_bkmk\"></span></li>";
                $output .= "</ul>";
                $output .= "</div>";
                $output .= "<hr>";
                $output .= "<div id=\"mentionpanel\"></div>";
                $output .= "</div>";
            }
        }
        return $output;
    }

    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="webmention") { // So that it is displayed with `echo $this->yellow->page->getExtraHtml("webmention")`
            $output .= $this->onParseContentShortcut($page, "webmention", "", "block");
        }
        if ($name=="header") {
            $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
            $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}webmention.css\">\n";
            $output .= "<link rel=\"webmention\" href=\"". $this->yellow->system->get("webmentionEndpoint") ."\">\n";
            $output .= "<script async type=\"text/javascript\" defer=\"defer\" src=\"{$extensionLocation}webmention.js\"></script>\n";
        }
        return $output;
    }
}