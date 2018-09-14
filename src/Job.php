<?php

namespace Nails\Aws\ElasticTranscoder;

use Nails\Aws\ElasticTranscoder\Exception\Exception;
use Nails\Aws\ElasticTranscoder\Exception\InvalidPipeline;
use Nails\Aws\ElasticTranscoder\Exception\InvalidPreset;
use Nails\Aws\ElasticTranscoder\Exception\Job\InvalidSource;
use Nails\Aws\ElasticTranscoder\Exception\Job\InvalidTarget;
use Nails\Factory;

class Job
{
    protected $sId;
    protected $iStatus;
    protected $sSource;
    protected $sTarget;

    /**
     * @var Client
     */
    protected $oClient;

    /**
     * @var Pipeline
     */
    protected $oPipeline;

    /**
     * @var Preset
     */
    protected $oPreset;

    // --------------------------------------------------------------------------

    const STATUS_NOT_STARTED = 0;
    const STATUS_STARTED     = 1;
    const STATUS_FINISHED    = 2;
    const STATUS_ERROR       = 3;

    // --------------------------------------------------------------------------

    /**
     * Job constructor.
     *
     * @param array $aConfig Values to initialise the class with
     */
    public function __construct($aConfig = [])
    {
        if (array_key_exists('id', $aConfig)) {
            $this->setId($aConfig['id']);
        }

        if (array_key_exists('status', $aConfig)) {
            $this->setStatus($aConfig['status']);
        } else {
            $this->setStatus(static::STATUS_NOT_STARTED);
        }

        $this->oClient = Factory::service('Client', 'nails/module-aws-elastic-transcoder');

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's ID
     *
     * @param string $sId The ID to set
     */
    protected function setId($sId)
    {
        $this->sId = $sId;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->sId;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's status
     *
     * @param integer $iStatus The status to set
     */
    protected function setStatus($iStatus)
    {
        $this->iStatus = $iStatus;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->iStatus;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's source file
     *
     * @param string $sSource The source file to set
     */
    protected function setSource($sSource)
    {
        $this->sSource = $sSource;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's source file
     *
     * @return string
     */
    public function getSource()
    {
        return $this->sSource;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's target file
     *
     * @param string $sTarget The target file to set
     */
    protected function setTarget($sTarget)
    {
        $this->sTarget = $sTarget;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's target file
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->sTarget;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's pipeline
     *
     * @param Pipeline $oPipeline The pipeline to place the job into
     */
    protected function setPipeline($oPipeline)
    {
        $this->oPipeline = $oPipeline;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's pipeline
     *
     * @return Pipeline
     */
    public function getPipeline()
    {
        return $this->oPipeline;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the Job's preset
     *
     * @param Preset $oPreset The preset to place the job into
     */
    protected function setPreset($oPreset)
    {
        $this->oPreset = $oPreset;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the Job's preset
     *
     * @return Preset
     */
    public function getPreset()
    {
        return $this->oPreset;
    }

    // --------------------------------------------------------------------------

    /**
     * Start the job
     *
     * @throws InvalidPipeline
     * @throws InvalidPreset
     * @throws InvalidSource
     * @throws InvalidTarget
     */
    public function start()
    {
        if ($this->getStatus() !== static::STATUS_NOT_STARTED) {
            throw new Exception('Job has already been started');
        }

        if (is_null($this->oPipeline)) {
            throw new InvalidPipeline('No pipeline has been set');
        } elseif (!$this->oPipeline->getId()) {
            throw new InvalidPipeline('No pipeline ID has been set');
        }

        if (is_null($this->oPreset)) {
            throw new InvalidPreset('No preset has been set');
        } elseif (!$this->oPreset->getId()) {
            throw new InvalidPipeline('No preset ID has been set');
        }

        if (!$this->getSource()) {
            throw new InvalidSource();
        }

        if (!$this->getTarget()) {
            throw new InvalidTarget();
        }

        $this->setStatus(static::STATUS_STARTED);

        $aData = [
            'PipelineId' => $this->oPipeline->getId(),
            'Input'      => [
                'Key' => $this->getSource(),
            ],
            'Output'     => [
                'Key'      => $this->getTarget(),
                'PresetId' => $this->oPreset->getId(),
            ],
        ];

        return $this->oClient->api()->createJob($aData);
    }
}
