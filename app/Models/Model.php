<?php

namespace Extendify\MetaGallery\Models;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

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
    protected $wantedAttributes = [];
    protected $dbKey = '';

    abstract public function getPostType();

    public function query()
    {
        // TODO: probably this should be raw DB queries eventually
        return $this->actualQuery();
    }

    private function actualQuery()
    {
        $posts = \get_posts(array_merge([
            'post_type' => $this->getPostType(),
            'post_status' => ['publish'],
            'orderby' => $this->orderBy,
            'posts_per_page' => $this->postsPerPage
        ], $this->extraParameters));

        $posts = array_map(function ($post) {
            $meta = [];
            foreach ($this->getExtraAttributes() as $key) {
                $meta[$key] = \get_post_meta($post->ID, $this->dbKey.'-'.$key, true);
            }
            $post->meta = $meta;
            return $post;
        }, $posts);

        if (!$this->toPluck) {
            return $posts;
        }

        return array_map(function ($post) {
            return array_intersect_key($post->to_array(), array_flip($this->toPluck));
        }, $posts);
    }
    private function getExtraAttributes()
    {
        if ($this->wantedAttributes) {
            return $this->wantedAttributes;
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

    public function pluck(array $fields = [])
    {
        $this->toPluck = $fields;
        return $this;
    }

    public static function get()
    {
        $class = new static;
        $class->dbKey = App::$slug;
        return $class;
    }

    public static function getWith(array $fields)
    {
        $class = new static;
        $class->dbKey = App::$slug;
        $class->wantedAttributes = $fields;
        return $class;
    }
}
