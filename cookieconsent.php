<?php

namespace Plugins\CookieConsent;

use \Typemill\Plugin;
use \Typemill\Models\Settings;

class CookieConsent extends Plugin
{
	protected $settings;
	
    public static function getSubscribedEvents()
    {
		return array(
			'onSettingsLoaded'		=> 'onSettingsLoaded',
			'onTwigLoaded' 			=> 'onTwigLoaded'
		);
    }
	
	public function onSettingsLoaded($settings)
	{
		$this->settings = $settings->getData();
	}
	
	public function onTwigLoaded()
	{
        $twig 	= $this->getTwig();
		$loader = $twig->getLoader();
		$loader->addPath(__DIR__ . '/templates');

        $settings = $this->getPluginSettings();

        $this->addJS('//www.unpkg.com/vanilla-cookieconsent@3.1.0/dist/cookieconsent.umd.js');
		$this->addInlineJS($twig->fetch('/cookie-consent-js.twig', $settings));

        /* add CSS */
        $this->addCSS('https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css');
	}
}