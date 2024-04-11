<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

if (!$list) {
    return;
}

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa =$app->getDocument()->getWebAssetManager();

// Swiper documentation: https://swiperjs.com/ | https://swiperjs.com/demos
$wa->registerAndUseStyle('swiper.css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], []);
$wa->registerAndUseScript('swiper.js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], ['defer' => true]);

$script = <<<SCRIPT
// Wait until window is loaded
window.addEventListener('DOMContentLoaded', () => {
	new Swiper(".mySwiper{$module->id}", {
		lazy: true,
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		  dynamicBullets: true, // Add just 3 bullits not all (Comment out to disable)
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
		autoplay: {
			delay: 3000,
			pauseOnMouseEnter: true,
		},
		//freeMode: true, // Swipe freely
		grabCursor: true, // Add grap hand to swipe
		//rewind: true, // Rewind to the first (User rewind or Loop)
		loop: true, // Loop al the images (User rewind or Loop)
		//slidesPerView: "auto",
		// Use decimal to show a part of the last image (When using slidesPerView: 3,2 make sure you have at least 5 images)
		breakpoints: {
		  0: {
			  slidesPerView: 1.2
		  },
		  480: {
			  slidesPerView: 2.2,
			  spaceBetween: 32
		  },
		  768: {
			  slidesPerView: 3,
			  spaceBetween: 32
		  },
		  1024:{
			  slidesPerView: 3,
			  spaceBetween: 32
		  }
		}
	});
})
SCRIPT;

$style = <<<CSS
.mySwiper{$module->id} .swiper-button {
	width: 50px;
	height: 60px;
	background-color: rgba(var(--light-rgb), .8);
}
CSS;

$wa->addInlineStyle($style, ['name' => 'module' . $module->id]);
$wa->addInlineScript($script, ['name' => 'module' . $module->id], [], ['swiper.js']);
?>

<ul class="mod-articlescategory category-module mod-list">
    <?php if ($grouped) : ?>
        <?php foreach ($list as $groupName => $items) : ?>
        <div>
            <div class="mod-articles-category-group"><?php echo Text::_($groupName); ?></div>
            <div>
                <?php require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'default') . '_items'); ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <?php $items = $list; ?>
        <?php require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'default') . '_items'); ?>
    <?php endif; ?>
</ul>
