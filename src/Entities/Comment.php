<?php
namespace App\Entities;

use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONDocument;

/**
 * Class Comment
 * @package App\Entities
 */
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
     * @var array
     */
    public $replies = [];

    /**
     * @param Comment $comment
     */
    public function addReplyToComment(Comment $comment): void
    {
        $this->replies[] = $comment->toArray();
    }

    /**
     * @param Comment $comment
     */
    public function removeReplyFromComment(Comment $comment): void
    {
        foreach ($this->replies as $key => $val)
        {
            if ($val === $comment)
            {
                unset($this->replies[$key]);
            }
        }
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
            'Content' => $this->content,
            'Replies' => $this->replies
        ];
    }

    /**
     * Maps Mongo document to Model Object
     * @param array|BSONDocument $document
     */
    public function map(BSONDocument $document): void
    {
        $this->createdOn = $document['CreatedOn'] instanceof BSONDocument ?
            new \DateTime($document['CreatedOn']['date']) :
            $document['CreatedOn']->toDateTime();
        $this->updatedOn = $document['UpdatedOn'] instanceof BSONDocument ?
            new \DateTime($document['UpdatedOn']['date']) :
            $document['UpdatedOn']->toDateTime();
        $this->guid = $document['Guid'];
        $this->content = $document['Content'];
        $this->replies = $document['Replies']->getArrayCopy();
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
            'Content' => $this->content,
            'Replies' => $this->replies
        ];
    }
}