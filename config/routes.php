<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Hinban Registration
$route['registration'] 						= 'registration/index';
$route['registration/upload'] 				= 'registration/upload';
$route['registration/(:any)'] 				= 'registration/index/$1';