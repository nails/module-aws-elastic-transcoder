<?php

namespace Nails\Aws\ElasticTranscoder;

use Nails\Aws\ElasticTranscoder\Constants;
use Nails\Factory;

class Preset
{
    protected $sId;

    /**
     * @var Client
     */
    protected $oClient;

    // --------------------------------------------------------------------------

    /**
     * Preset constructor.
     *
     * @param array $aConfig Values to initialise the class with
     */
    public function __construct($aConfig = [])
    {
        if (array_key_exists('id', $aConfig)) {
            $this->setId($aConfig['id']);
        }

        $this->oClient = Factory::service('Client', Constants::MODULE_SLUG);
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Preset's ID
     *
     * @param string $sId the ID to set
     */
    protected function setId($sId)
    {
        $this->sId = $sId;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Preset's ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->sId;
    }
}
