<?php
namespace Src\Controller;

use Src\TableGateways\ContactsGateway;

class ContactController {

    private $db;
    private $requestMethod;
    private $userId;

    private $contactsGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->contactsGateway = new ContactsGateway($db);
    }


    /*
     * Process the incoming request and get a response from it 
     */
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getContact($this->userId);
                } else {
                    $response = $this->getAllContacts();
                };
                break;
            case 'POST':
                $response = $this->createContactFromRequest();
                break;
            case 'PUT':
                $response = $this->updateContactFromRequest($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }


    /*
     * Get all contacts. 
     */
    private function getAllContacts()
    {
        $result = $this->contactsGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    /*
     * Get contact by id. 
     */
    private function getContact($id)
    {
        $result = $this->contactsGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    /*
     * Create contact 
     */
    private function createContactFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateContact($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->contactsGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }


    /*
     * Update contact by id. 
     */
    private function updateContactFromRequest($id)
    {
        $result = $this->contactsGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateContactEmail($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->contactsGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }


    /*
     * Validate contact details. 
     */
    private function validateContact($input)
    {
        if (! isset($input['name'])) {
            return false;
        }
        if (! isset($input['email']) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (! isset($input['phone'])) {
            return false;
        }
        if (! isset($input['address'])) {
            return false;
        }
        return true;
    }

    /*
     * Validate the contact email. 
     */
    private function validateContactEmail($input)
    {
        if (! isset($input['email']) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /*
     * Return 422 error code. 
     */
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input!'
        ]);
        return $response;
    }


    /*
     * Return 404 error code. 
     */
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}