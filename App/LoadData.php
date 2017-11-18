<?php
/**
 * This is to just load up some dummy data, nothing else.
 */

use App\Entities\BlogPost;
use App\Entities\Comment;
use Carbon\Carbon;
use MongoDB\Client;
use Ramsey\Uuid\Uuid;

require __DIR__ . '/../vendor/autoload.php';

$mongo = new Client(getenv('MONGO_CS'));
$collection = $mongo->selectCollection('demo', 'BlogPosts');

$firstComment = new Comment();
$firstReply = new Comment();
$secondComment = new Comment();
$secondReply = new Comment();
$first = new BlogPost();
$first->createdOn = Carbon::now();
$first->updatedOn = Carbon::now();
$first->guid = Uuid::uuid4()->toString();
$first->author = 'Admin';
$first->title = 'Blog Post #1';
$first->content = 'This is my first blog post.';

//
// First comment to post
//
$firstComment->createdOn = Carbon::now();
$firstComment->updatedOn = Carbon::now();
$firstComment->guid = Uuid::uuid4()->toString();
$firstComment->author = 'AwesomeBob';
$firstComment->content = 'First to comment on this first blog post! woot!';

//
// First reply to first comment
//
$firstReply->createdOn = Carbon::now();
$firstReply->updatedOn = Carbon::now();
$firstReply->guid = Uuid::uuid4()->toString();
$firstReply->author = 'DrCheddar';
$firstReply->content = 'Drat! I failed to be the first to comment, curse you AwesomeBob!!';

$firstComment->addReplyToComment($firstReply);

//
// Second comment to post
//
$secondReply->createdOn = Carbon::now();
$secondReply->updatedOn = Carbon::now();
$secondReply->guid = Uuid::uuid4()->toString();
$secondReply->author = 'AwesomeBob';
$secondReply->content = 'Sorry DrCheddar, you just was too slow :P';

$firstComment->addReplyToComment($secondReply);

$first->addCommentToBlogPost($firstComment);

//
// Second comment to post
//
$secondComment->createdOn = Carbon::now();
$secondComment->updatedOn = Carbon::now();
$secondComment->guid = Uuid::uuid4()->toString();
$secondComment->author = 'MrsPacMan';
$secondComment->content = 'I like this post, very engaging compared to those ghosts I keep dealing with.';

$first->addCommentToBlogPost($secondComment);

$collection->insertOne($first);