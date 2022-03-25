<?php

namespace Addequatte\Newspaper\Controllers;

use Addequatte\Newspaper\PDO\DB;

class MainController extends AbstractController
{
    /**
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $posts = DB::instance()->posts();

        echo $this->twig()->render('index.twig',
            [
                'posts' => $posts
            ]);
    }

    public function post($id)
    {
        $post = DB::instance()->post($id);

        echo $this->twig()->render('post.twig',
            [
                'post' => $post
            ]);
    }
}