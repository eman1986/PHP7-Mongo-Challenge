<?php
namespace App\Entities;

use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONDocument;

/**
 * Class User
 * @package App\Entities
 */
class User implements Serializable
{
    /**
     * @var string
     */
    public $guid;

    /**
     * @var \DateTime
     */
    public $createdOn;

    /**
     * @var \DateTime
     */
    public $updatedOn;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var array
     */
    public $userGroups = [];

    /**
     * @var array
     */
    public $roles = [];

    /**
     * @param string $guid
     */
    public function addUserToUserGroups(string $guid): void
    {
        $this->userGroups[] = $guid;
    }

    /**
     * @param string $guid
     * @throws \OutOfRangeException
     */
    public function removeUserFromUserGroups(string $guid): void
    {
        $i = in_array($guid, $this->userGroups, true);

        if ($i === false)
        {
            throw new \OutOfRangeException('User was not found in user group.');
        }

        $this->userGroups = array_diff($this->userGroups, [$guid]);
    }

    /**
     * @param string $guid
     */
    public function addRoleToUserGroup(string $guid): void
    {
        $this->roles[] = $guid;
    }

    /**
     * @param string $guid
     * @throws \OutOfRangeException
     */
    public function removeRoleFromUserGroups(string $guid): void
    {
        $i = in_array($guid, $this->roles, true);

        if ($i === false)
        {
            throw new \OutOfRangeException('Role was not found in user group.');
        }

        $this->roles = array_diff($this->roles, [$guid]);
    }

    /**
     * @return array
     */
    public function bsonSerialize(): array
    {
        return [
            'CreatedOn' => new UTCDateTime($this->createdOn),
            'UpdatedOn' => new UTCDateTime($this->updatedOn),
            'Guid' => $this->guid,
            'Email' => $this->email,
            'UserGroups' => $this->userGroups,
            'Roles' => $this->roles
        ];
    }

    /**
     * Maps Mongo document to Model Object
     * @param array|BSONDocument $document
     */
    public function map(BSONDocument $document): void
    {
        $this->createdOn = $document['CreatedOn']->toDateTime();
        $this->updatedOn = $document['UpdatedOn']->toDateTime();
        $this->guid = $document['Guid'];
        $this->email = $document['Email'];
        $this->userGroups = $document['UserGroups']->getArrayCopy();
        $this->roles = $document['Roles']->getArrayCopy();
    }

    /**
     * Converts object to array
     * @return array
     */
    public function toArray(): array
    {
        return [
            'CreatedOn' => $this->createdOn,
            'UpdatedOn' => $this->updatedOn,
            'Guid' => $this->guid,
            'Email' => $this->email,
            'UserGroups' => $this->userGroups,
            'Roles' => $this->roles
        ];
    }
}