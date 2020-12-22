<?php

namespace Util;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBFIeldNameType
 *
 * @author giavr
 */
class DBFieldNameType {

    /**
     *
     * @var string 
     */
    protected $name;

    /**
     *
     * @var int
     */
    protected $type;

    /**
     *
     * @var bool 
     */
    protected $needsEscaping;

    /**
     * 
     * @param string $name
     * @param int $type
     */
    public function __construct(string $name, int $type) {
        $this->name = $name;
        $this->type = $type;
        $this->needsEscaping = $this->checkType();
    }

    /**
     * 
     * @return bool
     */
    private function checkType(): bool {
        if ($this->type == 253 || $this->type == 254) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * 
     * @return bool
     */
    public function getNeedsEscaping(): bool {
        return $this->needsEscaping;
    }

}
