<?php

namespace App\Providers;

use HTMLPurifier_HTMLDefinition;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\ServiceProvider;

class PurifySetupProvider extends ServiceProvider
{
    const DEFINITION_ID = 'tinymce-editor';
    const DEFINITION_REV = 5;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** @var \HTMLPurifier $purifier */
        $purifier = Purify::getPurifier();
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', static::DEFINITION_ID);
        $config->set('HTML.DefinitionRev', static::DEFINITION_REV);
        if ($def = $config->maybeGetRawHTMLDefinition()) {
            $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');
        }

        $purifier->config = $config;
    }

    public function boot()
    {
        // /** @var \HTMLPurifier $purifier */
        // $purifier = Purify::getPurifier();

        // /** @var \HTMLPurifier_Config $config */
        // $config = $purifier->config;

        // $config->set('HTML.DefinitionID', static::DEFINITION_ID);
        // $config->set('HTML.DefinitionRev', static::DEFINITION_REV);

        // if ($def = $config->maybeGetRawHTMLDefinition()) {
        //     $this->setupDefinitions($def);
        // }

        // $purifier->config = $config;
    }

    protected function setupDefinitions(HTMLPurifier_HTMLDefinition $def)
    {
        $def->addAttribute('a', 'target', 'Text');
        // $def->set('Attr.AllowedFrameTargets', array('_blank')); 
    }
}
