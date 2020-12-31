<?php
use Tackk\Cartographer\Sitemap;
use Tackk\Cartographer\ChangeFrequency;

$sitemap = new Tackk\Cartographer\Sitemap();
$time = date("Y-m-d", time());
$sitemap->add('https://flag.riverside.rocks', $time, ChangeFrequency::WEEKLY, 1.0);
$sitemap->add('https://flag.riverside.rocks/top', $time);
$sitemap->add('https://flag.riverside.rocks/new', $time);


header ('Content-Type:text/xml');
echo $sitemap->toString();