<?php

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

const BOOK_TYPES = [
    'Poétiques',
    'Narratifs',
    'Théâtraux',
    'Épistolaires',
    'Argumentatifs',
    'Descriptifs',
    'Graphiques',
    'Romance'
];

const REQUIRED_MESSAGE = "Ce champ est obligatoire.";

if (!function_exists('jsonDecode')) {
    function jsonDecode($json)
    {
        return json_decode($json, true);
    }
}

if (!function_exists('doValidations')) {
    function doValidations($violations)
    {
        if (count($violations)) {
            $message = 'Impossible de procéder à cette opération. ';
            foreach ($violations as $violation) {
                $message .= sprintf("%s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new UnprocessableEntityHttpException($message);
        }

    }
}

if(!function_exists('from_camel_case')) {
    /**
     * Translates a camel case string into a string with - (e.g. firstName -&gt; first-name)
     * @param string $str String in camel case format
     * @return    string            $str Translated into underscore format
     */
    function from_camel_case($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "-" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }
}

if(!function_exists('to_camel_case')) {
    /**
     * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
     * @param string $str String in underscore format
     * @param bool $capitalise_first_char If true, capitalise the first char in $str
     * @return   string                              $str translated into camel caps
     */
    function to_camel_case($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }
}




