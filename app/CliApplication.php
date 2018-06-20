<?php

namespace Application;


class CliApplication
{
    private $_data;
    private $_fileName;

    public function __construct()
    {
        $this->_fileName = 'data.json';
        $jsonData = file_get_contents($this->_fileName);
        if (empty($jsonData)) {
            $this->_data = [];
        } else {
            $this->_data = json_decode($jsonData, true);
        }

    }

    private function _getInput()
    {
        return trim(fgets(STDIN, 250));

    }

    public function entryPoint()
    {
        fwrite(STDOUT, "Welcome to Simple User Registration System. \n");

        while (true) {
            fwrite(STDOUT, "* Add user:add * Edit user:edit * Remove user:delete * Exit:exit * \n");
            $method = $this->_getInput();

            switch ($method) {
                case 'add':
                    $this->addUser();
                    break;
                case 'edit':
                    $this->editUser();
                    break;
                case 'delete':
                    $this->removeUser();
                    break;
                case 'exit':
                    $this->exitApp();
            }

            fwrite(STDOUT, "Do you want to continue?[y/n] \n");
            $answer = $this->_getInput();
            if ($answer === 'n') {
                $this->exitApp();
            }
        }

    }

    public function addUser()
    {

        fwrite(STDOUT, "Type in your first name: ");
        $firstName = $this->_getInput();

        fwrite(STDOUT, "Type in your last name: ");
        $lastName = $this->_getInput();

        fwrite(STDOUT, "Type in your email address: ");
        $email = filter_var($this->_getInput(), FILTER_VALIDATE_EMAIL);

        if ($email === false || strlen($email) === 0) {
            do {
                fwrite(STDOUT, "! Incorrect email format. Please enter valid email. \n");
                fwrite(STDOUT, "Type in valid email address: ");
                $email = filter_var($this->_getInput(), FILTER_VALIDATE_EMAIL);
            } while ($email === "$email");
        }

        fwrite(STDOUT, "Type in your main phone number: ");
        $phoneNumber1 = filter_var($this->_getInput(), FILTER_VALIDATE_INT);

        if ($phoneNumber1 === false) {
            do {
                fwrite(STDOUT, "! Incorrect phone number format. Please enter valid phone number \n");
                fwrite(STDOUT, "Type in valid phone number: ");
                $phoneNumber1 = filter_var($this->_getInput(), FILTER_VALIDATE_INT);
            } while ($phoneNumber1 === "$phoneNumber1");
        }

        fwrite(STDOUT, "Type in your additional phone number: ");
        $phoneNumber2 = filter_var($this->_getInput(), FILTER_VALIDATE_INT);

        if ($phoneNumber2 === false) {
            do {
                fwrite(STDOUT, "! Incorrect phone number format. Please enter valid phone number \n");
                fwrite(STDOUT, "Type in valid phone number: ");
                $phoneNumber2 = filter_var($this->_getInput(), FILTER_VALIDATE_INT);
            } while ($phoneNumber2 === "$phoneNumber2");
        }

        fwrite(STDOUT, "Type in any comments: ");
        $comments = $this->_getInput();

        fwrite(STDOUT, "Congratulation! You were successfully registered! \n");

        $userData = [
          'First Name' => $firstName,
          'Last Name' => $lastName,
          'Email' => $email,
          'Main phone number' => $phoneNumber1,
          'Additional number' => $phoneNumber2,
          'Comments' => $comments,
        ];

        array_push($this->_data, $userData);
        file_put_contents($this->_fileName, json_encode($this->_data, JSON_PRETTY_PRINT));

    }

    public function editUser()
    {


    }

    public function removeUser()
    {


    }

    public function exitApp()
    {
        fwrite(STDOUT, "Are you sure you want to exit application?[y/n] ");
        $method = $this->_getInput();

        if ($method === 'y') {
            exit(0);
        } else {
            $this->entryPoint();
        }


    }

}