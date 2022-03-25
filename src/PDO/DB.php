<?php

namespace Addequatte\Newspaper\PDO;

class DB
{
    private \PDO $PDO;

    private static $self;

    private function __construct()
    {
        $this->PDO = new \PDO(
            getenv('DATABASE_DSN'),
            getenv('DATABASE_USER'),
            getenv('DATABASE_PASSWORD')
        );
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * @return array
     */
    public function posts(): array
    {
        $stm = $this->PDO->prepare('select * from post');

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function post(int $id): ?array
    {
        $stm = $this->PDO->prepare('select * from post where id=:id');

        $stm->execute([':id' => $id]);

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $post
     * @return bool
     */
    public function createPost(array $post):bool
    {
        $stm = $this->PDO->prepare('insert into post (title,content) values (:title,:content)');

        return $stm->execute([':title' => $post['title'], ':content' => $post['content']]);
    }

    /**
     * @param $id
     * @param array $post
     * @return bool
     */
    public function savePost($id, array $post):bool
    {
        $stm = $this->PDO->prepare('update post set title=:title, content=:content where id=:id');

        return $stm->execute([':id' => $id, ':title' => $post['title'], ':content' => $post['content']]);
    }

    public function deletePost($id):bool
    {
        $stm = $this->PDO->prepare('delete from post where id=:id');

        return $stm->execute([':id' => $id]);
    }
}