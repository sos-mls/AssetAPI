<?php
/**
 * ApiController 
 */
class ApiController extends CController
{

    /**
     * Renders a json object from the array and disables all routing that would 
     * occur 
     * 
     * @access protected
     * @param  array    $data   The data to be echoed.
     * @param  integer  $status The HTTP status.
     */
    protected function renderJSON($data, $status = 200) {
        $this->generateHeader($status);

        if ($status == 200) {
            echo CJSON::encode($data);

            foreach (Yii::app()->log->routes as $route) {
                if($route instanceof CWebLogRoute) {
                    $route->enabled = false; // disable any weblogroutes
                }
            }
            Yii::app()->end();
        } else {
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Returns a link to get more information about the object.
     * 
     * @access private
     * @param  string  $hash_id     The hash_id
     * @return string/boolean       Url to get more information about the
     *                              object.
     */
    private function getReadLink($controller_name, $hash_id) {
        return $_SERVER['HTTP_HOST'] . '/' . $controller_name . '/' . $hash_id;
    }

    /**
     * Returns the hash id if it exists in the url, otherwise it returns a 
     * false boolean.
     * 
     * @access private
     * @param  string   $controller_name The name of the controller.
     * @return string/boolean            The hash_id or a repsonse that
     *                                   states the url does not have a
     *                                   hash_id              
     */
    private function getHashID($controller_name) {

        $append_redirect = str_replace('/' . $controller_name, '', $_SERVER['REDIRECT_URL']);
        if (strpos($append_redirect, '/') !== false
            && empty($_GET)) {
            return str_replace('/', '', $append_redirect);
        } else {
            return false;
        }
    }

    /**
     * Generates the header for the api response.
     * 
     * @access private
     * @param  integer $status      The HTTP status.
     * @param  string  $contentType The content of the api response.
     */
    private function generateHeader($status = 200, $contentType = 'application/json') {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        // set the status
        header($status_header);
        header('Content-type: application/json');
    }


    /**
     * Gets the message for a status code
     * 
     * @param mixed $status 
     * @access private
     * @return string
     */
    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * Checks if a request is authorized
     * 
     * @access private
     * @return void
     */
    private function _checkAuth()
    {
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if(!(isset($_SERVER['HTTP_X_'.self::APPLICATION_ID.'_USERNAME']) and isset($_SERVER['HTTP_X_'.self::APPLICATION_ID.'_PASSWORD']))) {
            // Error: Unauthorized
            $this->_sendResponse(401);
        }
        $username = $_SERVER['HTTP_X_'.self::APPLICATION_ID.'_USERNAME'];
        $password = $_SERVER['HTTP_X_'.self::APPLICATION_ID.'_PASSWORD'];
        // Find the user
        $user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
        if($user===null) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Name is invalid');
        } else if(!$user->validatePassword($password)) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Password is invalid');
        }
    }

    /**
     * Returns the json or xml encoded array
     * 
     * @param mixed $model 
     * @param mixed $array Data to be encoded
     * @access private
     * @return void
     */
    private function _getObjectEncoded($model, $array)
    {
        if(isset($_GET['format']))
            $this->format = $_GET['format'];

        if($this->format=='json')
        {
            return CJSON::encode($array);
        }
        elseif($this->format=='xml')
        {
            $result = '<?xml version="1.0">';
            $result .= "\n<$model>\n";
            foreach($array as $key=>$value)
                $result .= "    <$key>".utf8_encode($value)."</$key>\n"; 
            $result .= '</'.$model.'>';
            return $result;
        }
        else
        {
            return;
        }
    } 
}
