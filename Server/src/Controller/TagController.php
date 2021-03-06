<?php
namespace App\Controller;
use App\Delegate\TagDelegate;
use App\Models\User;
use App\Models\Tag;

class TagController{
    private $request;
    private $login;
    private $body;
    private $headers;
    private $arguments;
    private $logger;
    private $tag;

    public function __construct($request, $arguments, $logger){
        $this->logger     = $logger;
        $this->request    = $request;
        $this->body       = $request->getParsedBody();
        $this->headers    = $request->getHeaders();
        $this->arguments  = $arguments;
        $this->tag        = new TagDelegate();
    
    }

    public function addTag(){
        
        $userID = $this->arguments['userId'];
        $token  = $this->headers['HTTP_AUTHORIZATION'][0];
        
        $user   = new User();
        $user->setUserId($userID);
        $user->setToken($token);

        $newTag = new Tag();
        $newTag->setName($this->body['name']);

        $response = $this->tag->addTag($user,$newTag);

        if($response['response']==0){
            $logMessage='Error in adding a  Tag: '.$newTag->getName().' Error: ' . $response['message'] . '.';
            
            $this->logger->info($logMessage);
        }
        
        return $response;
    }

    public function getTags(){

        $userID = $this->arguments['userId'];
        $token  = $this->headers['HTTP_AUTHORIZATION'][0];
        $user   = new User();
        $user->setUserId($userID);
        $user->setToken($token);

        $response = $this->tag->getTags($user);
        return $response;
    }

    public function removeTag(){

        $userID    = $this->arguments['userId'];
        $token     = $this->headers['HTTP_AUTHORIZATION'][0];
        $tagName  = $this->arguments['name'];
        $user      = new User();
        $user->setUserId($userID);
        $user->setToken($token);

        $response = $this->tag->removetag($user,$tagName);
        return $response;
    }

}
?>