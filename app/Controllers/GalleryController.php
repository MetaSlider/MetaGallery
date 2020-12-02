<?php

namespace Extendify\MetaGallery\Controllers;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

use Extendify\MetaGallery\View;
use Extendify\MetaGallery\Models\Gallery;

class GalleryController
{

    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
    public function index()
    {
        if (isset($_GET['gallery'])) {
            // Remove the gallery param if it's set
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=archive'));
            exit;
        }
        $galleries = Gallery::get()->all();
        if (!$galleries) {
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=start'));
            exit;
        }
        return View::queue('archive', ['galleries' => $galleries]);
    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        if (isset($_GET['gallery'])) {
            // Remove the gallery param if it's set
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=create'));
            exit;
        }
        return View::queue('create');
    }

    /**
        * Store a newly created resource in storage.
        *
        * @return Response
        */
    public function store()
    {
        // TODO: Validate gallery
        $gallery = new Gallery;
        $gallery->title = 'Title';
        $gallery->images = [];
        $gallery->settings = [];
        $gallery->save();
    }

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show()
    {
        if (!isset($_GET['gallery'])) {
            // TODO: Flash message if they tried to access a gallery that wasnt set
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=archive'));
            exit;
        }
        $gallery = Gallery::get()->where(['p' => (string) $_GET['gallery']])->query();
        if (!$gallery) {
            // TODO: Flash message if they tried to access a gallery doesnt exist
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=archive'));
            exit;
        }
        return View::queue('single', ['gallery' => $gallery]);
    }

    /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function edit($id)
    {
        //
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function update($id)
    {
        //
    }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function destroy($id)
    {
        //
    }
}
