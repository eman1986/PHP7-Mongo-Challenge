<?php
namespace App\Entities;

use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONDocument;

/**
 * Class BlogPost
 * @package App\Entities
 */
class BlogPost implements Serializable
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
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var array
     */
    public $comments = [];

    /**
     * @param string $guid
     */
    public function addCommentToBlogPost(string $guid): void
    {
        $this->comments[] = $guid;
    }

    /**
     * @param string $guid
     * @throws \OutOfRangeException
     */
    public function removeCommentFromBlogPost(string $guid): void
    {
        $i = \in_array($guid, $this->comments, true);

        if ($i === false)
        {
            throw new \OutOfRangeException('Comment was not found in blog post.');
        }

        $this->comments = array_diff($this->comments, [$guid]);
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
            'Title' => $this->title,
            'Content' => $this->content,
            'Comments' => $this->comments
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
        $this->title = $document['Title'];
        $this->content = $document['Content'];
        $this->comments = $document['Comments']->getArrayCopy();
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
            'Title' => $this->title,
            'Content' => $this->content,
            'Comments' => $this->comments
        ];
    }
}