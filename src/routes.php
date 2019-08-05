<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response, array $args) use($app){
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/chat', function (Request $request, Response $response, array $args) use($app){
    echo $request->getAttribute('ip_address');
    $data = $this->get('db')->table('eititan_feed')->get();
    return $this->renderer->render($response, 'chat.phtml', ['data'=>$data]);
});

//posting to chat from post.phtml
$app->post('/chat', function (Request $request, Response $response, array $args) use($app){
    $data = $request->getParsedBody();
    $newArray = array('username' =>  $data['user'], 'post_message' => $data['post'], \Carbon\Carbon::now());

    if($_SESSION["hasPosted"] == false){
        $_SESSION["hasPosted"] = true;
    }

    $post = new Posts;
    $post->fill($newArray);
    $post->save();

    $this->logger->info("Post IP", ['IP' => $request->getServerParam('REMOTE_ADDR')]);
    $this->logger->info("User",  ['User' => $data['user']]);
    $this->logger->info("Message", ['Post' => $data['post']]);
    $this->logger->info("Posted", ['PostedBefore' => $_SESSION["hasPosted"]]);

    $data = $this->get('db')->table('eititan_feed')->get();
    return $this->renderer->render($response, 'chat.phtml', ['data'=>$data]);
})->setName("post-chat");

$app->get('/post', function (Request $request, Response $response, array $args) use($app){
    return $this->renderer->render($response, 'post.phtml', $args);
})->setName("post");

$app->post('/ajaxGet', function (Request $request, Response $response, array $args) use($app){
    $data = $this->get('db')->table('eititan_feed')->get();
    return $this->renderer->render($response, 'ajaxGet.php', ['data'=>$data]);
});
