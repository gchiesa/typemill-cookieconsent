<?php

namespace Plugins\CookieConsent;

use \Typemill\Plugin;

class CookieConsent extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onTwigLoaded' => 'onTwigLoaded',
            'onCspLoaded' => 'onCspLoaded',
        ];
    }

    public function onTwigLoaded()
    {
        $twig = $this->getTwig();
        $loader = $twig->getLoader();
        $loader->addPath(__DIR__ . '/templates');

        $settings = $this->getPluginSettings();

        if (!is_array($settings))
        {
            $settings = [];
        }

        $settings['message_base'] = $this->prepareTextForJs($settings['message_base'] ?? '');
        $settings['message_analytics'] = $this->prepareTextForJs($settings['message_analytics'] ?? '');
        $settings['message_functionality'] = $this->prepareTextForJs($settings['message_functionality'] ?? '');
        $settings['message_marketing'] = $this->prepareTextForJs($settings['message_marketing'] ?? '');
        $settings['legal_and_privacy_url'] = $this->prepareUrlForJs($settings['legal_and_privacy_url'] ?? '');

        $this->addJS('//unpkg.com/vanilla-cookieconsent@3.1.0/dist/cookieconsent.umd.js');
        $this->addInlineJS($twig->fetch('/cookie-consent-js.twig', $settings));

        /* add CSS */
        $this->addCSS('https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css');
    }

    public function onCspLoaded($csp)
    {
        $data = $csp->getData();
        $domains = ['cdn.jsdelivr.net', 'unpkg.com'];

        foreach ($domains as $domain)
        {
            if (!in_array($domain, $data))
            {
                $data[] = $domain;
            }
        }

        $csp->setData($data);
    }

    /**
     * Prepare a plain-text admin message for safe embedding in a double-quoted JS string.
     *
     * Strips HTML tags and escapes characters that would break the JS string literal.
     */
    private function prepareTextForJs(?string $text): string
    {
        if ($text === null)
        {
            return '';
        }

        $text = trim(strip_tags($text));

        return $this->escapeJsString($text);
    }

    /**
     * Prepare a URL for safe embedding in a double-quoted JS string.
     *
     * HTML-escapes the URL first so the href attribute stays valid when the
     * consent library renders it as HTML. Then it escapes characters that would
     * break the JS string literal.
     */
    private function prepareUrlForJs(?string $url): string
    {
        if ($url === null)
        {
            return '';
        }

        $url = htmlspecialchars(trim($url), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return $this->escapeJsString($url);
    }

    /**
     * Escape characters that would break a double-quoted JavaScript string literal.
     */
    private function escapeJsString(string $text): string
    {
        return str_replace(
            ['\\', '"', "\n", "\r", "\t"],
            ['\\\\', '\\"', '\\n', '', ' '],
            $text
        );
    }
}
