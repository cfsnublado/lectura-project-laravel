<?php

namespace App\Interfaces;

/**
 * Interface for a model with an exclusive 
 * language attribute (e.g., 'en', 'es') with the option of being open
 * with no specific langauge.
 */
interface LanguageExclusive
{
    public const LANGUAGE_EN = 'en';
    public const LANGUAGE_ES = 'es';
    public const LANGUAGE_OPEN = 'xx';

    /**
     * Languages
     * 
     * @var array
     */
    public const LANGUAGES = [
        self::LANGUAGE_EN => 'en',
        self::LANGUAGE_ES => 'es',
        self::LANGUAGE_OPEN => 'open'
    ];

    /**
     *
     */
    public function setLanguageAttribute($value);

   /**
    * 
    */
   public function getLanguageValueAttribute();
}