<?php

use Symfony\Component\Yaml\Yaml;

class RequestContext
{

    private $_restObject = null;
    private $_entity_type = null;
    private $_restObjectMethod = 'get';
    private $_client = null;
    private $_response = null;
    private $_requestUrl = null;
    private $_parameters = array();
    private $_pathUrl = "";

    /**
     * Initializes Guzzle service context.
     *
     */
    public function __construct(array $parameters)
    {
        $this->_restObject = new stdClass();
        $this->_client = new Guzzle\Service\Client();
        $this->_parameters = $parameters;
    }

    public function getParameter($name)
    {
        if (count($this->_parameters) === 0) {
            throw new \Exception('Parameters not loaded!');
        } else {
            $parameters = $this->_parameters;
            return (isset($parameters[$name])) ? $parameters[$name] : null;
        }
    }

    public function addAnEntityByName($entity_name)
    {
        $this->_entity_type   = ucwords(strtolower($entity_name));
        $this->_restObjectMethod = 'put';
    }

    public function getAnEntityByName($entity_name)
    {
        $this->_entity_type   = ucwords(strtolower($entity_name));
        $this->_restObjectMethod = 'get';
    }

    public function removeAnEntityByName($entity_name)
    {
        $this->_entity_type   = ucwords(strtolower($entity_name));
        $this->_restObjectMethod = 'delete';
    }

    public function addProviderToPathUrl($provider_name)
    {
        $this->$_pathUrl = "";
        switch(mb_strtoupper($provider_name)) {
            case 'FACEBOOK':
                $this->$_pathUrl = $this->getParameter('facebook_provider_url');
                break;
            case 'FOURSQUARE':
                $this->$_pathUrl = $this->getParameter('foursquare_provider_url');
                break;
            case 'SONAR':
                $this->$_pathUrl = $this->getParameter('sonar_uuid_url');
                break;
            default:
                throw new Exception("The provider name ".$provider_name." is not defined");
        }
    }

    public function addPropertyToObject($propertyName, $propertyValue)
    {
        $this->_restObject->$propertyName = $propertyValue;
    }

    public function executeProviderRequest($providerPlaceId)
    {
        $this->executeRequest($this->$pathUrl.$providerPlaceId);
    }

    public function executeUuidRequest($sonarPlaceId)
    {
        $this->executeRequest($this->$pathUrl.$sonarPlaceId);
    }

    public function executeRequest($path_url)
    {
        $baseUrl = $this->getParameter('base_url');
        $basePath = $this->getParameter('base_path');
        $this->_requestUrl = $baseUrl.$basePath.$path_url;
        $response = null;

        switch (strtoupper($this->_restObjectMethod)) {
            case 'GET':
                $response = $this->_client
                    ->get($this->_requestUrl.'?'.http_build_query((array)$this->_restObject))
                    ->send();
                break;
            case 'PUT':
                $postFields = (array)$this->_restObject;
                $response = $this->_client
                    ->post($this->_requestUrl,null,$postFields)
                    ->send();
                break;
            case 'DELETE':
                $response = $this->_client
                    ->delete($this->_requestUrl.'?'.http_build_query((array)$this->_restObject))
                    ->send();
                break;
        }
        $this->_response = $response;
    }

    public function isTheResponseAJsonObject()
    {
        $data = json_decode($this->_response->getBody(true));

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->_response);
        }
    }

    public function isPropertyPresentInResponse($propertyName)
    {
        $data = json_decode($this->_response->getBody(true));

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function isPropertyEqualsTo($propertyName, $propertyValue)
    {
        $data = json_decode($this->_response->getBody(true));

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            if ($data->$propertyName !== $propertyValue) {
                throw new \Exception('Property value mismatch! (given: '.$propertyValue.', match: '.$data->$propertyName.')');
            }
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function isPropertyNameInResponse($propertyName)
    {
        $data = json_decode($this->_response->getBody(true));

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            return true;
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function checkPropertyType($propertyName,$typeString)
    {
        $data = json_decode($this->_response->getBody(true));

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            // check our type
            switch (strtolower($typeString)) {
                case 'string':
                    if (!is_string($data->$propertyName)) {
                        return false;
                    }
                    break;
            }
            return true;
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function checkResponseCodeStatus($httpStatus)
    {
        if ((string)$this->_response->getStatusCode() !== $httpStatus) {
            throw new \Exception('HTTP code does not match '.$httpStatus.
                ' (actual: '.$this->_response->getStatusCode().')');
        }
    }

    public function getResponseCodeStatus()
    {
        return (string)$this->_response->getStatusCode();
    }

    public function echoLastResponse()
    {
        $this->printDebug(
            $this->_requestUrl."\n\n".
            $this->_response
        );
    }
}