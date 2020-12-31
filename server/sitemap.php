<?php declare(strict_types=1);

use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;

$loc = date("Y-m-d H:i:s", time());

$url = new Url($loc);
$url->setLastMod($lastMod);
$url->setChangeFreq($changeFreq);
$url->setPriority($priority);

$urlset = new Urlset();
$urlset->add($url);

$driver = new XmlWriterDriver();
$urlset->accept($driver);

echo $driver->output();