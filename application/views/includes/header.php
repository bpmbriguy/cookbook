<!DOCTYPE html>
<html lang="en">
<head>
    <title>McCormick Cookbook</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/layout.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/gui_icons.css" type="text/css" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Adamina" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.6.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/cufon-yui.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/cufon-replace.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/Lobster_13_400.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/NewsGoth_BT_400.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/FF-cash.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/script.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/bgSlider.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/tms-0.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/tms_presets.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/tinybox.js"></script>

	<!--[if lt IE 7]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
        	<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
	<![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="<?php echo base_url();?>js/html5.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>css/ie.css" type="text/css" media="screen">
	<![endif]-->
</head>
<body id="<?php echo isset($pageid) ? $pageid : 'page5'; ?>">
	<div id="bgSlider"></div>
    <div class="bg_spinner"></div>
	<div class="extra">
        <!--==============================header=================================-->
        <header>
        	<div class="top-row">
            	<div class="main">
                	<div class="wrapper">
                        <h1><a href="index.html">GoodCook</a></h1>
                        <ul class="bg_pagination">
                            <li class="current"><a href="<?php echo base_url();?>img/bg-img1.jpg">1</a></li>
                            <li><a href="<?php echo base_url();?>img/bg-img2.jpg">2</a></li>
                            <li><a href="<?php echo base_url();?>img/bg-img3.jpg">3</a></li>
                        </ul>
                    </div>
                    <div class="login">
                        <?php if( $this->tank_auth->is_logged_in() ) {
                            echo anchor('auth/logout', 'Log Out');
                        } else {
                            echo '<a href="'.$this->tank_auth_social->facebookLoginURL( site_url().'auth_social/fblogin' ).'">Login With Facebook</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="menu-row">
            	<div class="menu-border">
                	<div class="main">
                        <nav>
                            <ul class="menu">
                                <li><a href="<?php echo base_url();?>">Main</a></li>
                                <li><?php echo anchor('category', 'Categories');?></li>
                                <li><?php echo anchor('recipe', 'New Recipes');?></li>
                                <li><?php echo anchor('search', 'Search');?></li>
                                <?php if($this->tank_auth->is_logged_in()): ?>
                                <li><?php echo anchor('admin', 'My Cookbook');?></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!--==============================content================================-->
        <div class="inner">
            <div class="main">
                <section id="content">
                <?php if($main_content != 'home') :?>
                <div id="breadcrumbs"><?php echo set_breadcrumb(); ?></div>
                <?php endif; ?>