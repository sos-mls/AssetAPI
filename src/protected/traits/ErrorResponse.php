<?php

/**
 * A General ErrorResponse for restful Controllers.
 */
trait ErrorResponse 
{
    /**
     * Returns a json response in a proper error format to let the 
     * front notify the user a solution to the problem.
     * 
     * @param  array|string $errors The errors that occured.
     * @param  integer      $http_code The code to send to the user.
     */
    private function error_response($errors, $http_code = 424) 
    {
        if (is_array($errors)) 
        {
            $this->renderJSON([
                'errors' => $errors
            ], $http_code);
        }
        else 
        {
            $this->renderJSON([
                'errors' => [
                    'general' => [$errors]
                ]
            ], $http_code);
        }
    }
}