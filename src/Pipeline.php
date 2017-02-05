<?php

namespace Nails\Aws\ElasticTranscoder;

use Nails\Factory;

class Pipeline
{
    protected $sId;

    /**
     * @var Client
     */
    protected $oClient;

    // --------------------------------------------------------------------------

    /**
     * Pipeline constructor.
     *
     * @param array $aConfig Values to initialise the class with
     */
    public function __construct($aConfig = [])
    {
        if (array_key_exists('id', $aConfig)) {
            $this->setId($aConfig['id']);
        }

        $this->oClient = Factory::service('Client', 'nailsapp/module-aws-elastic-transcoder');

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Pipeline's ID
     *
     * @param string $sId the ID to set
     */
    protected function setId($sId)
    {
        $this->sId = $sId;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Pipeline's ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->sId;
    }
}
