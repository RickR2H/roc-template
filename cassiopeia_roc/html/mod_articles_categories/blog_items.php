<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\CMS\Layout\LayoutHelper;

$input  = $app->getInput();
$option = $input->getCmd('option');
$view   = $input->getCmd('view');
$id     = $input->getInt('id');

foreach ($list as $index => $item) : ?>
    <?php $image = json_decode($item->get('params')); ?>
    <?php
    	// Grab the intro image
        if (!empty($image->image)) {
            $item->imageSrc = htmlspecialchars($image->image, ENT_COMPAT, 'UTF-8');
            $item->imageAlt = htmlspecialchars($image->image_alt, ENT_COMPAT, 'UTF-8');
        } else {
            $item->imageSrc = 'https://picsum.photos/1200/600?random=' . $index;
            $item->imageAlt = '';
        }

        $img = HTMLHelper::_('cleanImageURL', $item->imageSrc);
        $image_size = getimagesize($img->url);
        //dump($item);
    ?>
    <div<?php
        if ($id == $item->id && in_array($view, ['category', 'categories']) && $option == 'com_content') {
        echo ' class="g-col-12 g-col-lg-4 active"';
       } else {
        echo ' class="g-col-12 g-col-lg-4"';
       }
       ?>> <?php $levelup = $item->level - $startLevel - 1; ?>
        <?php $attributes = ['class' => 'mod-categories-title' . $item->id]; ?>
        <?php $link = Route::_(RouteHelper::getCategoryRoute($item->id, $item->language)); ?>
        <?php echo HTMLHelper::_('link',
            $link,
            LayoutHelper::render(
                'joomla.html.image',
                [
                    'src' => $item->imageSrc,
                    'alt' => $item->imageAlt,
                    'class' => 'blog-layout-img mb-3',
                    'width'		=> $image_size[0],
                    'height'	=> $image_size[1],
                    'loading'	=> 'lazy',
                    'style' => 'aspect-ratio: 2/1; object-fit:cover; width: 100%;'
                ]),
            $attributes);
        ?>
        <h3>
        <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($item->id, $item->language)); ?>">
        <?php echo $item->title; ?>
            <?php if ($params->get('numitems')) : ?>
                (<?php echo $item->numitems; ?>)
            <?php endif; ?>
        </a>
        </h3>
        <?php if ($params->get('show_description', 0)) : ?>
            <?php echo HTMLHelper::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content'); ?>
        <?php endif; ?>
        <?php
        if (
            $params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0)
            || ($params->get('maxlevel') >= ($item->level - $startLevel)))
            && count($item->getChildren())
        ) : ?>
            <?php echo '<div>'; ?>
            <?php $temp = $list; ?>
            <?php $list = $item->getChildren(); ?>
            <?php require ModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default') . '_items'); ?>
            <?php $list = $temp; ?>
            <?php echo '</div>'; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
