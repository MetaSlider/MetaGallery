<?php

namespace Extendify\MetaGallery\Models;

use Extendify\MetaGallery\App;

/**
 * Simple Model query type builder
 *
 * @since 0.1.0
 */
abstract class Model
{
    protected $orderBy = 'modified';
    protected $postsPerPage = -1;
    protected $extraParameters = [];
    protected $toPluck = [];
    protected $dbKey = '';

    abstract public function getPostType();

    public function query()
    {
        // TODO: probably this should be raw DB queries eventually
        return $this->actualQuery();
    }

    private function actualQuery()
    {
        $posts = get_posts(array_merge([
            'post_type' => $this->getPostType(),
            'post_status' => ['publish'],
            'orderby' => $this->orderBy,
            'posts_per_page' => $this->postsPerPage
        ], $this->extraParameters));

        return array_map(function ($post) {
            $meta = [];
            foreach ($this->getWantedProperties() as $key) {
                $meta[$key] = get_post_meta($post->ID, $this->dbKey.'-'.$key, true);
            }
            $post->meta = $meta;
            return $post;
        }, $posts);
    }
    private function getWantedProperties()
    {
        if ($this->toPluck) {
            return $this->toPluck;
        }
        $class = new \ReflectionClass($this);
        return array_map(function ($prop) {
            return $prop->name;
        }, $class->getProperties(\ReflectionProperty::IS_PUBLIC));
    }

    public function first()
    {
        $this->postsPerPage = 1;
        return $this->query();
    }

    public function all()
    {
        $this->postsPerPage = -1;
        return $this->query();
    }

    public function where($extraParameters)
    {
        $this->extraParameters = $extraParameters;
        return $this;
    }

    public function save()
    {
        $class = new \ReflectionClass($this);
        $properties = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $properties[$prop->name] = $class->getProperty($prop->name)->getValue($this);
        }
        $id = \wp_insert_post(['post_status' => 'publish', 'post_type' => $this->getPostType()]);
        foreach ($properties as $key => $value) {
            update_post_meta($id, $this->dbKey.'-'.$key, $value);
        }
    }

    public static function get(array $fields = [])
    {
        $class = new static;
        $class->dbKey = App::$slug;
        $class->toPluck = $fields;
        return $class;
    }
}
