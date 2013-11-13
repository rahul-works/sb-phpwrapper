<?php
namespace SupportBee {
  
  class Client {

    public $auth_token, $sub_domain, $curl = ''; 
    const PROTOCOL    = 'https://';
    const API_DOMAIN  = 'supportbee.com/';
    const API_FORMAT  = 'json';

    function __construct($params) {
      // Validate dependencies 
      if (!function_exists('curl_init')) {
        throw new \Exception('Curl library missing'); 
      }
      
      $this->validateParams($params);
      
      $this->auth_token = $params['auth_token'];
      $this->sub_domain = $params['sub_domain'];
	   
    }

    private function validateParams($params) {
      if (empty($params['sub_domain'])) {
        throw new \Exception("sub_domain is required");
      }

      if (empty($params['auth_token'])) {
        throw new \Exception("auth_token is required");
      }
      return true;
    }

    public function fetch($type, $filters = array()) { 
      if (empty($this->curl)) {
        $this->curl = new Curl;
      }
      $url = $this->buildURL($type); 
	  
	  $response = $this->curl->get($url, $filters);
	  if($response){
      	return json_decode($response->body, true);
	  } else {
	  	return FALSE; 
	  }
    }
	
	/*
	 * Request a POST type HTTP request
	 * @Parameter : type -> support bee module request
	 * 				vars -> POST data
	 * @return 	: POST Request :  response.
	 */
	public function post($type, $vars = array()){
		if (empty($this->curl)) {
        	$this->curl = new Curl;
      	}
      	$url = $this->buildURL($type);
	  	 //var_dump($url); die;
	  	$response = $this->curl->post($url, $vars);
	  	if($response){
      		return json_decode($response->body, true);
	  	} else {
	  		return FALSE;
	  	}
	}
	
	/*
	 * Request a DELETE type HTTP request
	 * @Parameter : type -> support bee module request
	 * 				vars -> POST data
	 * @return 	: DELETE Request :  response.
	 */
	public function delete($type, $vars = array()){
		if (empty($this->curl)) {
        	$this->curl = new Curl;
      	}
      	$url = $this->buildURL($type);
	  	 //var_dump($url); die;
	  	$response = $this->curl->delete($url, $vars);
	  	if($response){
      		return json_decode($response->body, true);
	  	} else {
	  		return FALSE; 
	  	}
	}

    public function buildURL($ext) {
      return self::PROTOCOL.$this->sub_domain.'.'.self::API_DOMAIN.$ext.'.'.self::API_FORMAT.'?auth_token='.$this->auth_token;
    }

  }


  class Curl {
    
    public $cookie_file; 
    public $follow_redirects = true;
    public $headers = array();
    public $options = array();
    public $referer;
    public $user_agent;
    protected $error = '';
    protected $request;
    
    function __construct() {
        $this->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'SupportBee API Client library';
    }
    
    
    
    function error() {
        return $this->error;
    }
    
    function get($url, $vars = array()) {
        if (!empty($vars)) {
            $url .= (stripos($url, '?') !== false) ? '&' : '?';
            $url .= (is_string($vars)) ? $vars : http_build_query($vars, '', '&');
        }
        return $this->request('GET', $url);
    }
    
	function delete($url, $vars = array()) {
        return $this->request('DELETE', $url, $vars);
    }

    function head($url, $vars = array()) {
        return $this->request('HEAD', $url, $vars);
    }
    
    function post($url, $vars = array()) {
        return $this->request('POST', $url, $vars);
    }
    
    function put($url, $vars = array()) {
        return $this->request('PUT', $url, $vars);
    }
	
    function request($method, $url, $vars = array()) {
        $this->error = '';
        $this->request = curl_init();
        if (is_array($vars)) $vars = http_build_query($vars, '', '&');
        
        $this->set_request_method($method);
        $this->set_request_options($url, $vars);
        $this->set_request_headers();
        
        $response = curl_exec($this->request);
        
        if ($response) {
            $response = new CurlResponse($response);
        } else {
            $this->error = curl_errno($this->request).' - '.curl_error($this->request);
        }
        curl_close($this->request);
        
        return $response;
    }
    
    protected function set_request_headers() {
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key.': '.$value;
        }
        curl_setopt($this->request, CURLOPT_HTTPHEADER, $headers);
    }
    
    protected function set_request_method($method) {
        switch (strtoupper($method)) {
            case 'HEAD':
                curl_setopt($this->request, CURLOPT_NOBODY, true);
                break;
            case 'GET':
                curl_setopt($this->request, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($this->request, CURLOPT_POST, true);
                break;
            default:
                curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
        }
    }
    
    protected function set_request_options($url, $vars) {
        curl_setopt($this->request, CURLOPT_URL, $url);
		if (!empty($vars)) curl_setopt($this->request, CURLOPT_POSTFIELDS, $vars);
        
        # Set some default CURL options
        curl_setopt($this->request, CURLOPT_HEADER, true);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->request, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookie_file) {
            curl_setopt($this->request, CURLOPT_COOKIEFILE, $this->cookie_file);
            curl_setopt($this->request, CURLOPT_COOKIEJAR, $this->cookie_file);
        }
		curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, false);
		if ($this->follow_redirects) curl_setopt($this->request, CURLOPT_FOLLOWLOCATION, true);
        if ($this->referer) curl_setopt($this->request, CURLOPT_REFERER, $this->referer);
        
        # Set any custom CURL options
        foreach ($this->options as $option => $value) {
            curl_setopt($this->request, constant('CURLOPT_'.str_replace('CURLOPT_', '', strtoupper($option))), $value);
        }
    }

  }

  class CurlResponse {
    
    public $body = '';  
    public $headers = array();
    
    function __construct($response) {
        # Headers regex
        $pattern = '#HTTP/\d\.\d.*?$.*?\r\n\r\n#ims';
        
        # Extract headers from response
        preg_match_all($pattern, $response, $matches);
        $headers_string = array_pop($matches[0]);
        $headers = explode("\r\n", str_replace("\r\n\r\n", '', $headers_string));
        
        # Remove headers from the response body
        $this->body = str_replace($headers_string, '', $response);
        
        # Extract the version and status from the first header
        $version_and_status = array_shift($headers);
        preg_match('#HTTP/(\d\.\d)\s(\d\d\d)\s(.*)#', $version_and_status, $matches);
        $this->headers['Http-Version'] = $matches[1];
        $this->headers['Status-Code'] = $matches[2];
        $this->headers['Status'] = $matches[2].' '.$matches[3];
        
        # Convert headers into an associative array
        foreach ($headers as $header) {
            preg_match('#(.*?)\:\s(.*)#', $header, $matches);
            $this->headers[$matches[1]] = $matches[2];
        }
    }
    
    function __toString() {
        return $this->body;
    }
    
  }

}
?>