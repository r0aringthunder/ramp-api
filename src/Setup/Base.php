<?php
namespace R0aringthunder\RampApi\Setup;

use R0aringthunder\RampApi\Ramp;

abstract class Base
{
    /**
     * @var Ramp The Ramp service instance to handle API requests.
     */
    protected $ramp;

    /**
     * Initializes a new instance of the Accounting service.
     *
     * @param Ramp $ramp The Ramp service instance.
     */
    public function __construct(Ramp $ramp) {
        $this->ramp = $ramp;
    }
}