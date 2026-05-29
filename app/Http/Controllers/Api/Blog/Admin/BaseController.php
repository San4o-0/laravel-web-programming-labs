<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Api\Blog\BaseController as GuestBaseController;

abstract class BaseController extends GuestBaseController
{
    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        // Ініціалізація загальних елементів адмінки.
    }
}
