<?php

class TemplateNamePhpExtension extends ViewPhpExtension
{
    // ...

    /**
     * Возвращает правильный title для страницы
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function getTitle(array $variables): string
    {
        if (
            $this->isSmartPage() &&
            $this->macros('seoSmartFiltersUnika', 'moduleEnable')
        ) {
            return $this->macros('seoSmartFiltersUnika', 'getMeta', [$variables['page']])['title'];
        }

        return isset($variables['page']) && $variables['page']->getValue('title')
            ? $variables['page']->getValue('title')
            : $variables['title'];
    }

    /**
     * Возвращает правильный description для страницы
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function getDescription(array $variables): string
    {
        if (
            $this->isSmartPage() &&
            $this->macros('seoSmartFiltersUnika', 'moduleEnable')
        ) {
            return $this->macros('seoSmartFiltersUnika', 'getMeta', [$variables['page']])['description'];
        }

        return isset($variables['page']) && $variables['page']->getValue('meta_descriptions')
            ? $variables['page']->getValue('meta_descriptions')
            : $variables['meta']['description'];
    }

    /**
     * Возвращает правильный H1
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function getH1(array $variables): string
    {
        $h1 = '';
        if (
            $this->isSmartPage() &&
            $this->macros('seoSmartFiltersUnika', 'moduleEnable')
        ) {
            $h1 = $this->macros('seoSmartFiltersUnika', 'getMeta', [$variables['page']])['h1'] ?? '';
        }

        if ($h1) {
            return $h1;
        }

        return $variables['page']->getValue('h1') ?? $variables['page']->getName();
    }

    /**
     * Возвращает правильный контент
     * @param array $variables
     * @return mixed|string
     * @throws Exception
     */
    public function getContent(array $variables): string
    {
        $content = '';
        if (
            $this->isSmartPage() &&
            $this->macros('seoSmartFiltersUnika', 'moduleEnable')
        ) {
            $content = $this->macros('seoSmartFiltersUnika', 'getMeta', [$variables['page']])['content'] ?? '';
        }

        if ($content) {
            return $content;
        }

        return $variables['page']->getValue('descr') ?? '';
    }

    /**
     * Возвращает правильный keywords для страницы
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function getKeywords(array $variables): string
    {
        $keywords = '';
        if (
            $this->isSmartPage() &&
            $this->macros('seoSmartFiltersUnika', 'moduleEnable')
        ) {
            $keywords = $this->macros('seoSmartFiltersUnika', 'getMeta', [$variables['page']])['keywords'];
        }

        if ($keywords) {
            return $keywords;
        }

        return isset($variables['page']) && $variables['page']->getValue('keywords')
            ? $variables['page']->getValue('keywords')
            : $variables['meta']['keywords'];
    }

    /**
     * Является ли текущая страница, страницей смарт фильтра
     * @return bool
     */
    private function isSmartPage(): bool
    {
        static $isSmart;

        if ($isSmart) {
            return $isSmart;
        }

        return $isSmart = stripos($_SERVER['REQUEST_URI'], '/f/') !== false;
    }
}
