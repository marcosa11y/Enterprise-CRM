<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Asset URLs (CDN)
|--------------------------------------------------------------------------
*/
$config['assets']['css']['bootstrap'] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css';
$config['assets']['css']['fontawesome'] = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';

$config['assets']['js']['bootstrap'] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
$config['assets']['js']['jquery'] = 'https://code.jquery.com/jquery-3.6.0.min.js';

/*
|--------------------------------------------------------------------------
| Local Asset Paths
|--------------------------------------------------------------------------
*/
$config['assets']['local']['css'] = 'assets/css/';
$config['assets']['local']['js'] = 'assets/js/';

/*
|--------------------------------------------------------------------------
| Asset Versioning (Cache Busting)
|--------------------------------------------------------------------------
*/
$config['assets']['version'] = '1.0.0';