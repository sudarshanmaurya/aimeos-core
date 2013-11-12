<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://www.arcavias.com/en/license
 */


class Controller_Jobs_Admin_Job_FactoryTest extends MW_Unittest_Testcase
{
	public function testCreateController()
	{
		$context = TestHelper::getContext();
		$arcavias = TestHelper::getArcavias();

		$obj = Controller_Jobs_Admin_Job_Factory::createController( $context, $arcavias );
		$this->assertInstanceOf( 'Controller_Jobs_Interface', $obj);
	}


	public function testFactoryExceptionWrongName()
	{
		$context = TestHelper::getContext();
		$arcavias = TestHelper::getArcavias();

		$this->setExpectedException( 'Controller_Jobs_Exception' );
		$object = Controller_Jobs_Admin_Job_Factory::createController( $context, $arcavias, 'Wrong$$$Name' );
	}


	public function testFactoryExceptionWrongClass()
	{
		$context = TestHelper::getContext();
		$arcavias = TestHelper::getArcavias();

		$this->setExpectedException( 'Controller_Jobs_Exception' );
		$object = Controller_Jobs_Admin_Job_Factory::createController( $context, $arcavias, 'WrongClass' );
	}


	public function testFactoryExceptionWrongInterface()
	{
		$context = TestHelper::getContext();
		$arcavias = TestHelper::getArcavias();

		$this->setExpectedException( 'Controller_Jobs_Exception' );
		$object = Controller_Jobs_Admin_Job_Factory::createController( $context, $arcavias, 'Factory' );
	}

}
