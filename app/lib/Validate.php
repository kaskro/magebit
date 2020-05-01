<?php

namespace app\lib;

use app\lib\DB;

class Validate
{
    private $_passed = false,
        $_errors = array(),
        $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item]);
                $item = $this->escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError($item, "{$item} is required.");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError($item, "{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError($item, "{$item} must be a maximum of {$rule_value} characters.");
                            }

                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError($item, "{$rule_value} must match {$item}.");
                            }

                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError($item, "'{$value}' already exists.");
                            }
                            break;
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError($item, "'{$item}' must be a valid email: 'example@example.com'.");
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($field, $error)
    {
        $this->_errors[$field] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }

    public function escape($string)
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
}
