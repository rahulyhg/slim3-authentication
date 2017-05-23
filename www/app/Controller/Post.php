<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model ;

/**
 * 
 */
class Post extends Controller {

    /**
     * 
     */
    public function getPost($request, $response, $args) {
        if (!$post = Model\Post::find($args["post_id"])) {
            return($response->withRedirect($this->router->pathFor("index")));
        }
        return($this->container->view->render($response, "post/index.twig", ["post" => $post]));
    }

    /**
     * 
     */
    public function getCreatePost($request, $response) {
        return($this->container->view->render($response, "post/create.twig"));
    }

    /**
     * 
     */
    public function postCreatePost($request, $response){
        $post = Model\Post::create([
            "title" => $request->getParam("title"),
            "content" => $request->getParam("content")
        ]);
        if(!$post) {
            return($response->withRedirect($this->router->pathFor("post.create")));
        }
        return($response->withRedirect($this->router->pathFor("post.index", ["post_id" => $post->id])));
    }

}
