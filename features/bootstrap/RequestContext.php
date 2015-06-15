<?php

use Guzzle\Http\Exception\BadResponseException;

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
        $this->_pathUrl = "";
        switch(mb_strtoupper($provider_name)) {
            case 'FACEBOOK':
                $this->_pathUrl = $this->getParameter('facebook_provider_url');
                break;
            case 'FOURSQUARE':
                $this->_pathUrl = $this->getParameter('foursquare_provider_url');
                break;
            case 'SONAR': {
                $this->getAnEntityByName("");
                $this->_pathUrl = $this->getParameter('sonar_uuid_url');
                break;
            }
            default:
                $this->_pathUrl = "/".$provider_name."/";
        }
    }

    public function addPropertyToObject($propertyName, $propertyValue)
    {
        $this->_restObject->$propertyName = $propertyValue;
    }

    public function executeProviderRequest($providerPlaceId)
    {
        $this->executeRequest($this->_pathUrl.$providerPlaceId);
    }

    public function executeUuidRequest($sonarPlaceId)
    {
        $this->executeRequest($this->_pathUrl.$sonarPlaceId);
    }

    public function executeRequest($path_url)
    {
        $baseUrl = $this->getParameter('base_url');
        $basePath = $this->getParameter('base_path');
        $this->_requestUrl = $baseUrl.$basePath.$path_url;
        $response = null;
        try
        {
            switch (strtoupper($this->_restObjectMethod)) {
                case 'GET':
                    $response = $this->_client
                        ->get($this->_requestUrl . '?' . http_build_query((array)$this->_restObject))
                        ->send();
                    break;
                case 'PUT':
                    $postFields = (array)$this->_restObject;
                    $response = $this->_client
                        ->put($this->_requestUrl, null, $postFields)
                        ->send();
                    break;
                case 'DELETE':
                    $response = $this->_client
                        ->delete($this->_requestUrl . '?' . http_build_query((array)$this->_restObject))
                        ->send();
                    break;
            }
            $this->_response = $response;
        }catch(BadResponseException $e){
                $this->_response = $e->getResponse();
        }
    }

    public function isTheResponseAJsonObject()
    {
        $data = json_decode($this->_response->getBody(true));

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->_response);
        }
        return true;
    }

    public function getPropertyValueByPropertyName($propertyName)
    {
        $data = json_decode($this->_response->getBody(true), true);

        if (!empty($data)) {
            if(array_key_exists($propertyName, $data['data'])) {
                return $data['data'][$propertyName];
            }
            throw new Exception("Property '".$propertyName."' is not set!\n");
        }
        else
        {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function getUuidFromResponse()
    {
        $data = json_decode($this->_response->getBody(true), true);

        if(!empty($data)) {
            if(array_key_exists('id', $data['data']['source'])) {
                return $data['data']['source']['id'];
            }
            throw new Exception("Property 'id' is not set!\n");
        }
        throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
    }

    public function isPropertyNameInResponse($propertyName)
    {
        $data = json_decode($this->_response->getBody(true), true);

        if (!empty($data)) {
            if (array_key_exists($propertyName, $data['data'])) {
                return true;
            }
            else {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
        }
        else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }

    public function checkPropertyTypeInData($propertyName,$type)
    {
        $data = json_decode($this->_response->getBody(true), true);

        if (!empty($data)) {
            if (!array_key_exists($propertyName, $data['data'])) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            // check our type
            switch (strtolower($type)) {
                case 'string':
                    if (!is_string($data['data'][$propertyName])) {
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

    public function getResponseCodeStatusAndReason()
    {
        return (string)$this->_response->getStatusCode().' '.$this->_response->getReasonPhrase();
    }

    public function getResponseErrorMessage()
    {
        $data = json_decode($this->_response->getBody(true), true);
        if(!empty($data))
        {
            if(array_key_exists('error_message', $data['meta']))
            {
                return $data['meta']['error_message'];
            }
        }
        else
        {
            throw new Exception("Response was not JSON\n");
        }
    }

    public function echoLastResponse()
    {
        $this->printDebug(
            $this->_requestUrl."\n\n".
            $this->_response
        );
    }
}