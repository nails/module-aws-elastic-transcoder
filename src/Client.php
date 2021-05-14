<?php

namespace Nails\Aws\ElasticTranscoder;

use Aws\ElasticTranscoder\ElasticTranscoderClient;

class Client
{
    protected $sAwsUserKey;
    protected $sAwsUserSecret;
    protected $sAwsUserRegion;
    protected $sAwsApiVersion;
    protected $oClient;

    // --------------------------------------------------------------------------

    /**
     * Client constructor.
     *
     * @param array $aConfig Values to initialise the class with
     */
    public function __construct($aConfig = [])
    {
        if (array_key_exists('key', $aConfig)) {
            $this->setUserKey($aConfig['key']);
        } elseif (defined('APP_AWS_ELASTIC_TRANSCODER_USER_KEY')) {
            $this->setUserKey(APP_AWS_ELASTIC_TRANSCODER_USER_KEY);
        } elseif (defined('DEPLOY_AWS_ELASTIC_TRANSCODER_USER_KEY')) {
            $this->setUserKey(DEPLOY_AWS_ELASTIC_TRANSCODER_USER_KEY);
        }
        if (array_key_exists('secret', $aConfig)) {
            $this->setUserSecret($aConfig['secret']);
        } elseif (defined('APP_AWS_ELASTIC_TRANSCODER_USER_SECRET')) {
            $this->setUserSecret(APP_AWS_ELASTIC_TRANSCODER_USER_SECRET);
        } elseif (defined('DEPLOY_AWS_ELASTIC_TRANSCODER_USER_SECRET')) {
            $this->setUserSecret(DEPLOY_AWS_ELASTIC_TRANSCODER_USER_SECRET);
        }
        if (array_key_exists('region', $aConfig)) {
            $this->setUserRegion($aConfig['region']);
        } elseif (defined('APP_AWS_ELASTIC_TRANSCODER_USER_REGION')) {
            $this->setUserRegion(APP_AWS_ELASTIC_TRANSCODER_USER_REGION);
        } elseif (defined('DEPLOY_AWS_ELASTIC_TRANSCODER_USER_REGION')) {
            $this->setUserRegion(DEPLOY_AWS_ELASTIC_TRANSCODER_USER_REGION);
        }
        if (array_key_exists('version', $aConfig)) {
            $this->setApiVersion($aConfig['version']);
        } elseif (defined('APP_AWS_ELASTIC_TRANSCODER_API_VERSION')) {
            $this->setApiVersion(APP_AWS_ELASTIC_TRANSCODER_API_VERSION);
        } elseif (defined('DEPLOY_AWS_ELASTIC_TRANSCODER_API_VERSION')) {
            $this->setApiVersion(DEPLOY_AWS_ELASTIC_TRANSCODER_API_VERSION);
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Set the user's AWS key
     *
     * @param string $sKey the user's AWS key
     */
    protected function setUserKey($sKey)
    {
        $this->sAwsUserKey = $sKey;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the AWS key being used
     *
     * @return string
     */
    public function getUserKey()
    {
        return $this->sAwsUserKey;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the user's AWS secret
     *
     * @param string $sSecret The user's AWS secret
     */
    protected function setUserSecret($sSecret)
    {
        $this->sAwsUserSecret = $sSecret;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the AWS secret being used
     *
     * @return string
     */
    public function getUserSecret()
    {
        return $this->sAwsUserSecret;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the user's AWS region
     *
     * @param string $sRegion The user's AWS region
     */
    protected function setUserRegion($sRegion)
    {
        $this->sAwsUserRegion = $sRegion;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the AWS region being used
     *
     * @return string
     */
    public function getUserRegion()
    {
        return $this->sAwsUserRegion;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the AWS API version
     *
     * @param string $sVersion The API version to use
     */
    protected function setApiVersion($sVersion)
    {
        $this->sAwsApiVersion = $sVersion;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the AWS API version being used
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->sAwsApiVersion;
    }

    // --------------------------------------------------------------------------

    /**
     * Opens the AWS ET API, connecting on demand
     *
     * @return ElasticTranscoderClient
     */
    public function api()
    {
        if (is_null($this->oClient)) {
            $this->oClient = ElasticTranscoderClient::factory([
                'version'     => $this->getApiVersion(),
                'region'      => $this->getUserRegion(),
                'credentials' => [
                    'key'    => $this->getUserKey(),
                    'secret' => $this->getUserSecret(),
                ],
            ]);
        }

        return $this->oClient;
    }
}
