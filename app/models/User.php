<?php

namespace app\models;

use app\core\Model;
use app\lib\Config;
use app\lib\Hash;
use app\lib\Session;
use app\lib\DB;
use Exception;

class User extends Model
{

    // Object properties
    private $_data,
        $_attributes,
        $_sessionName,
        $_isLoggedIn;
    public $_db;


    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating account.');
        }
    }

    public function saveAttributes($fields = array())
    {
        if (!$this->_db->insert('attributes', $fields)) {
            throw new Exception('There was a problem saving attributes.');
        }
    }

    public function deleteAttributes()
    {
        if (!$this->_db->delete('attributes', ['user_id', '=', $this->_data->id])) {
            throw new Exception('There was a problem deleting attributes.');
        }
    }

    public function saveValidFormAttributes($user, $post)
    {
        $id = '';
        $tempname = '';
        $user->deleteAttributes();
        foreach ($post as $key => $value) {
            if (!empty($value) && strlen($value) > 0) {
                if (str_replace('attribute-value', '', $key) == $id) {

                    $fields = array(
                        'user_id' => $user->data()->id,
                        'name' => $tempname,
                        'value' => $value,
                    );
                    $user->saveAttributes($fields);
                } else {
                    $id = str_replace('attribute-name', '', $key);
                    $tempname = $value;
                }
            }
        }
    }

    public function findAttributes()
    {
        return $this->_attributes = $this->_db->get('attributes', array('user_id', '=', $this->_data->id))->results();
    }

    public function getAttributesJSON()
    {
        $json = "[";
        $index = 0;
        $attributes = $this->findAttributes();
        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                $json .= "{ \"id\" : \"" . $index . "\", \"name\" : \"" . $attribute->name . "\", \"value\" : \"" . $attribute->value . "\" },";
                $index++;
            }
            $json[strlen($json) - 1] = ']';
        } else {
            $json = "[]";
        }

        return $json;
    }

    public function updateUser($id, $fields)
    {
        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem saving attributes.');
        }
    }

    public function deleteUser($id)
    {
        if (!$this->_db->delete('users', ['id', '=', $id])) {
            throw new Exception('There was a problem deleting account.');
        }
        $this->logout();
    }

    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->_db->get('users', array($field, '=', $user));
            if ($data->count()) {
                $this->_data = $data->first();
                $this->findAttributes();
                return true;
            }
        }
        return false;
    }

    public function login($email = null, $password = null)
    {
        $user = $this->find($email);

        if ($user) {
            if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
        $this->_isLoggedIn = false;
        $this->_data = null;
        $this->_attributes = null;
    }

    public function data()
    {
        $this->find($this->_data->id);
        return $this->_data;
    }

    public function attributes()
    {
        return $this->_attributes;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}
