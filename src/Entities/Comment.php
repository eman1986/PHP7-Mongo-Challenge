<?php
namespace App\Entities;

use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONDocument;

class Comment implements Serializable
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
    public $author;

    /**
     * @var string
     */
    public $content;

    /**
     * @return array
     */
    public function bsonSerialize(): array
    {
        return [
            'CreatedOn' => new UTCDateTime($this->createdOn),
            'UpdatedOn' => new UTCDateTime($this->updatedOn),
            'Guid' => $this->guid,
            'Content' => $this->content
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
        $this->content = $document['Content'];
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
            'Content' => $this->content
        ];
    }
}