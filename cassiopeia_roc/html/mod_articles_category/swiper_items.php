<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
?>

<div class="swiper mySwiper<?php echo $module->id; ?>">
    <div class="swiper-wrapper pb-4">
        <?php foreach ($items as $index => $item) : ?>
			<?php
				$images             = json_decode($item->images);
				$item->imageSrc     = '';
				$item->imageAlt     = '';
				$item->imageCaption = '';

				// Grab the intro image
				if (!empty($images->image_intro)) {
					$item->imageSrc = htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8');
					$item->imageAlt = htmlspecialchars($images->image_intro_alt, ENT_COMPAT, 'UTF-8');

					if ($images->image_intro_caption) {
						$item->imageCaption = htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8');
					}
				// Grab the full text image if ther is no intro image
				} elseif (!empty($images->image_fulltext)) {
					$item->imageSrc = htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8');
					$item->imageAlt = htmlspecialchars($images->image_fulltext_alt, ENT_COMPAT, 'UTF-8');

					if ($images->image_intro_caption) {
						$item->imageCaption = htmlspecialchars($images->image_fulltext_caption, ENT_COMPAT, 'UTF-8');
					}
				} else {
					$item->imageSrc = 'https://picsum.photos/1200/600?random=' . $index;
					$item->imageAlt = '';
				}

				$img = HTMLHelper::_('cleanImageURL', $item->imageSrc);

				$image_size = getimagesize($img->url);
			?>
			<div class="swiper-slide position-relative">
				<div class="image-wrapper">
					<?php
						echo LayoutHelper::render(
							'joomla.html.image',
							[
								'src' 		=> $item->imageSrc,
								'alt' 		=> $item->imageAlt,
								'class' 	=> 'swiper-layout-img mb-3',
								'width'		=> $image_size[0],
								'height'	=> $image_size[1],
								'loading'	=> 'lazy',
								'style' 	=> 'aspect-ratio: 1.75/2; object-fit:cover; width: 100%;'
							]
						);
					?>
					<?php if($item->imageCaption) : ?>
						<?php echo $item->imageCaption; ?>
					<?php endif; ?>
					<div class="swiper-lazy-preloader"></div>
				</div>
				<?php if ($params->get('link_titles') == 1) : ?>
					<?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
					<?php $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false); ?>
					<a href="<?php echo $link; ?>" class="h5 stretched-link text-decoration-none text-primary"><?php echo $title; ?></a>
				<?php endif; ?>

				<?php if ($item->displayHits) : ?>
				<div class="mod-articles-category-hits">
					(<?php echo $item->displayHits; ?>)
				</div>
				<?php endif; ?>

				<?php if ($params->get('show_author')) : ?>
				<div class="mod-articles-category-writtenby">
					<?php echo $item->displayAuthorName; ?>
				</div>
				<?php endif; ?>

				<?php if ($item->displayCategoryTitle) : ?>
				<div class="mod-articles-category-category">
					(<?php echo $item->displayCategoryTitle; ?>)
				</div>
				<?php endif; ?>

				<?php if ($item->displayDate) : ?>
				<div class="mod-articles-category-date"><?php echo $item->displayDate; ?></div>
				<?php endif; ?>

				<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
				<div class="mod-articles-category-tags">
					<?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
				</div>
				<?php endif; ?>

				<?php if ($params->get('show_introtext')) : ?>
				<p class="mod-articles-category-introtext">
					<?php echo $item->displayIntrotext; ?>
				</p>
				<?php endif; ?>

				<?php if ($params->get('show_readmore')) : ?>
				<p class="mod-articles-category-readmore mt-auto">
					<a class="btn btn-sm btn-primary mod-articles-category-title <?php echo $item->active; ?>"
						href="<?php echo $item->link; ?>">
						<?php if ($item->params->get('access-view') == false) : ?>
						<?php echo Text::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
						<?php elseif ($item->alternative_readmore) : ?>
						<?php echo $item->alternative_readmore; ?>
						<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
						<?php if ($params->get('show_readmore_title', 0)) : ?>
						<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
						<?php endif; ?>
						<?php elseif ($params->get('show_readmore_title', 0)) : ?>
						<?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
						<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
						<?php else : ?>
						<?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
						<?php endif; ?>
					</a>
				</p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
    </div>
    <div class="swiper-button swiper-button-next" style="--swiper-navigation-color: var(--primary);"></div>
    <div class="swiper-button swiper-button-prev" style="--swiper-navigation-color: var(--primary);"></div>
    <div class="swiper-pagination"></div>
</div>
