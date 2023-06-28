<?php
// Comment extension, https://github.com/pmoralesgarcia/yellow-webmention

class YellowWebmention {
    const VERSION = "0.1.0";
    public $yellow;         //access to API

     // Handle initialisation
    public function onLoad($yellow) {
    $this->yellow = $yellow;
        $this->yellow->system->setDefault("webmentionModerator", "");
        $this->yellow->system->setDefault("webmentionDirectory", "webmention/");
        $this->yellow->system->setDefault("webmentionAutoPublish", "0");
        $this->yellow->system->setDefault("webmentionMaxSize", "5000");
        $this->yellow->system->setDefault("webmentionTimeout", "0");
        $this->yellow->system->setDefault("webmentionOpening", "30");
        $this->yellow->system->setDefault("webmentionAuthorNotification", "1");
        $this->yellow->system->setDefault("webmentionSpamFilter", "href=|url=");
        $this->yellow->system->setDefault("webmentionIconSize", "80");
        $this->yellow->system->setDefault("webmentionProfileIcon", "0");
        $this->yellow->system->setDefault("webmentionProfileIconDefault", "mp");
        $this->yellow->system->setDefault("webmentionConsent", "0");
        $this->yellow->language->setDefaults([
