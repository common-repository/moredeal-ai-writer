<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Step constant
 *
 * @author MoredealAiWriter
 */
class StepConstant extends PhpEnum {

    /**
     * native
     */
    const SOURCE_NATIVE = [ 'native' ];

    /**
     * extend
     */
    const SOURCE_EXTEND = [ 'extend' ];

    protected $value;

    protected function construct( $value ) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

}


class StepTypeConstant extends PhpEnum {

	/**
	 * native
	 */
	const TYPE_ADAPTER = [ 'adapter' ];


	protected $value;

	protected function construct( $value ) {
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

}