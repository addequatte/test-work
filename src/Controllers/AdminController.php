<?php

namespace Addequatte\Newspaper\Controllers;

use Addequatte\Newspaper\PDO\DB;

class AdminController extends AbstractController
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

        echo $this->twig()->render('admin.twig',
            [
                'posts' => $posts
            ]);
    }

    /**
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function new()
    {
        echo $this->twig()->render('admin_new.twig');
    }

    /**
     * @return void
     */
    public function create()
    {
        if(DB::instance()->createPost($this->request()->request())) {
            header('Location: /admin');
        }else{
            throw new \Exception('Упс что-то пошло не так...');
        }
    }

    /**
     * @param $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit($id)
    {
        $post = DB::instance()->post($id);

        echo $this->twig()->render('admin_edit.twig',
            [
                'post' => $post
            ]);
    }

    /**
     * @param $id
     * @return void
     */
    public function save($id)
    {
        if(DB::instance()->savePost($id, $this->request()->request())) {
            header('Location: /admin');
        }else{
            throw new \Exception('Упс что-то пошло не так...');
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        if(DB::instance()->deletePost($id)) {
            header('Location: /admin');
        }else{
            throw new \Exception('Упс что-то пошло не так...');
        }
    }
}