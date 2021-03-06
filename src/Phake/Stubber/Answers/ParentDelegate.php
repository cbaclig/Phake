<?php
/* 
 * Phake - Mocking Framework
 * 
 * Copyright (c) 2010-2011, Mike Lively <m@digitalsandwich.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 * 
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

require_once 'Phake/Stubber/Answers/IDelegator.php';
require_once 'Phake/Stubber/IAnswerDelegate.php';

/**
 * An answer delegate that allows mocked methods to call their parent methods.
 *
 * This class is both the delegator and the delegate.
 */
class Phake_Stubber_Answers_ParentDelegate implements Phake_Stubber_Answers_IDelegator, Phake_Stubber_IAnswerDelegate
{
	private $capturedReturn;

	public function __construct(&$captor = null)
	{
		$this->capturedReturn =& $captor;
	}

	/**
	 * Returns the answer delegate (itself)
	 * @return Phake_Stubber_Answers_ParentDelegate
	 */
	public function getAnswer()
	{
		return $this;
	}

	/**
	 * Provides the callback to the parent
	 * @param object $calledObject
	 * @param string $calledMethod
	 * @param array $calledParameters
	 */
	public function getCallBack($calledObject, $calledMethod, array $calledParameters)
	{
		return array($calledObject, "parent::{$calledMethod}");
	}

	/**
	 * Passes through the given arguments.
	 * @param string $calledMethod
	 * @param array $calledParameters
	 */
	public function getArguments($calledMethod, array $calledParameters)
	{
		return $calledParameters;
	}

	public function processAnswer($answer)
	{
		$this->capturedReturn = $answer;
	}
}

?>
