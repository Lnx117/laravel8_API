<?php
namespace App\Interfaces;

interface AuthServiceInterface
{
    public function register($request);

    public function registerManager($request);

    public function token($request);
}