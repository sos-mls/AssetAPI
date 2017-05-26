<?php

/**
 * Contains the CreateController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * CreateController_Test class. A PHPUnit Test case class.
 *
 * Tests image creation functions inside of the Create controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class CreateController_Test extends CDbTestCase
{
    /**
     *
     *
     *
     * Test
     *
     *
     *
     */

    /**
     * Tests the actionIndex method.
     */
    public function test_actionIndexUnproper()
    {
        $this->expectOutputString(
            "HTTP/1.1 424 \n" .
            "Content-type: application/json\n" .
            '{"errors":{"general":["Not a proper http method type, please send a FILE"]}}'
        );

        $createController = new CreateController(rand(0,1000));
        Reflection::setProperty('generateHeader', 'CreateController', $createController, false);
        $createController->actionIndex();
    }
}