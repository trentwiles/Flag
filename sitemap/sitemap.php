<?php

require "../vendor/autoload.php";

use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

$sitemap = new Sitemap('../sitemap.xml');


$base_url = "https://flag.riverside.rocks";

$sitemap->addItem($base_url . "/");
$sitemap->addItem($base_url . "/new", time(), Sitemap::HOURLY);
$sitemap->addItem($base_url . "/top", time(), Sitemap::HOURLY);

$sitemap->addItem('http://example.com/mylink2', time());
$sitemap->addItem('http://example.com/mylink3', time(), Sitemap::HOURLY);
$sitemap->addItem('http://example.com/mylink4', time(), Sitemap::DAILY, 0.3);

// write it
$sitemap->write();