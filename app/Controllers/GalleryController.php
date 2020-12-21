<?php
/**
 * Controls Galleries
 */

namespace Extendify\MetaGallery\Controllers;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

use Extendify\MetaGallery\View;
use Extendify\MetaGallery\Models\Gallery;

/**
 * The controller for galleries
 */
class GalleryController
{

    /**
     * Display the onboarding page.
     *
     * @return Extendify\MetaGallery\View
     */
    public function start()
    {
        return View::queue('start', 'landing');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Extendify\MetaGallery\View
     */
    public function index()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['gallery'])) {
            // Remove the gallery param if it's set.
            \wp_safe_redirect(
                \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=archive')
            );
            exit;
        }

        $galleries = Gallery::get()->all();
        if (!$galleries) {
            \wp_safe_redirect(
                // For now, re-route users with no galleries to the start page.
                \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=start')
            );
            exit;
        }

        return View::queue('archive', 'main', ['galleries' => $galleries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['gallery'])) {
            // Remove the gallery param if it's set.
            \wp_safe_redirect(
                \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=create')
            );
            exit;
        }

        return View::queue('create');
    }

    /**
     * Store a newly created resource in storage.
     * Note: Users without Auth and capability cannot reach this method.
     *
     * @param WP_REST_Request $request - The request.
     *
     * @return void
     */
    public function store($request)
    {
        // Do not pass in a default config or the like as MS does,
        // since that will tie the config to a version. Just check...
        // every setting on the way out (when rendering the UI)...
        // or pass in config from the front to the back!
        $gallery = new Gallery();
        $gallery->title = \sanitize_text_field($request->get_param('title'));
        $gallery->images = [];
        $gallery->settings = [];
        $id = $gallery->save();

        \wp_safe_redirect(
            \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=single&gallery=' . \esc_attr($id))
        );
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (!isset($_GET['gallery'])) {
            // TODO: Flash message if they tried to access a gallery that wasnt set.
            \wp_safe_redirect(
                \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=archive')
            );
            exit;
        }

        $gallery = Gallery::get()->where(
            [
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                'p' => (string) sanitize_text_field(wp_unslash($_GET['gallery'])),
            ]
        )->query();

        if (!$gallery) {
            // TODO: Flash message if they tried to access a gallery doesnt exist.
            \wp_safe_redirect(
                \admin_url('admin.php?page=' . \esc_attr(METAGALLERY_PAGE_NAME) . '&route=archive')
            );
            exit;
        }

        return View::queue('single', 'main', ['gallery' => $gallery]);
    }

    // phpcs:disable
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    // public function edit($id)
    // {
    //     //
    // }
    // phpcs:enable

    // phpcs:disable
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    // public function update($id)
    // {
    //     //
    // }
    // phpcs:enable

    // phpcs:disable
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    // public function destroy($id)
    // {
    // }
    // phpcs:enable
}
