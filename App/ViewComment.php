<?php
use App\Entities\BlogPost;
use App\Entities\Comment;
use MongoDB\Client;

require __DIR__ . '/../vendor/autoload.php';

$mongo = new Client('mongodb://dev-server.local.com:27017');
$collection = $mongo->selectCollection('demo', 'BlogPosts');

$query = [
    'Guid' => "0b5b5b28-65f6-4ba4-872b-ca023847d56d"
];

$document = $collection->findOne($query);
$blogPost = new BlogPost();
$comment = new Comment();
$reply = new Comment();

if (null === $document)
{
    echo 'Nothing Found';
}
else
{
    $blogPost->map($document);
    $key = array_search('283145ce-648a-443e-83e1-e01c6071fc9f', array_column($blogPost->comments, 'Guid'), true);

//    print_r($blogPost->comments[$key]);

    $comment->map($blogPost->comments[$key]);
    $replyKey = array_search('574b349d-0f1f-48a3-9e65-71694ab5fb27', array_column($comment->replies, 'Guid'), true);

    $reply->map($comment->replies[$replyKey]);

    print_r($reply);
}