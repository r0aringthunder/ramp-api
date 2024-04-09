<?php
namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

abstract class Base
{
    protected $ramp;

    public function __construct(Ramp $ramp) {
        $this->ramp = $ramp;
    }
}