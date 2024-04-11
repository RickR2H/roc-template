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
use Joomla\CMS\Factory;

// Load the BS 5.3 Carousel script
HTMLHelper::_('bootstrap.carousel');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

/* Styling for carousel */
$style = <<<CSS
#carousel{$module->id} .carousel-item:after {
	content: "";
	display: block;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	background: var(--primary);
	opacity: 0.5;
	z-index: 1;
}
#carousel{$module->id}  .carousel-caption {
	top: 2rem;
	bottom:2rem;
	display: flex;
    align-items: center;
	z-index: 2;
}
#carousel{$module->id} .carousel-item-img {
	aspect-ratio: 1/1;
	object-fit:cover;
	width: 100%;
}
@media (min-width: 768px) {
	#carousel{$module->id} .carousel-item-img {
		aspect-ratio: 2/1;
	}
}
#carousel{$module->id} .carousel-item .carousel-caption-inner {
	opacity: 0;
	max-width: 60ch;
	transform: translateY(-200px);
	transition: all 3s ease;
}
#carousel{$module->id} .carousel-item.active .carousel-caption-inner {
	opacity: 1;
	transform: translateY(0);
}
CSS;

$wa->addInlineStyle($style, ['name' => 'module' . $module->id]);
?>

<div id="carousel<?php echo $module->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000000">
	<div class="carousel-indicators">
		<?php foreach ($items as $counter => $item) : ?>
		<button type="button" data-bs-target="#carousel<?php echo $module->id; ?>" data-bs-slide-to="<?php echo $counter; ?>"
			<?php echo $counter == 0 ? 'class="active" aria-current="true"' : ''; ?>
			aria-label="Slide <?php echo $counter + 1; ?>"></button>
		<?php endforeach; ?>
	</div>
	<div class="carousel-inner position-relative">
		<?php foreach ($items as $counter => $item) : ?>
			<div class="carousel-item<?php echo $counter == 0 ? ' active' : ''; ?>">
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
						$item->imageSrc = 'https://picsum.photos/1200/600?random=' . $counter;
						$item->imageAlt = '';
					}

					$img = HTMLHelper::_('cleanImageURL', $item->imageSrc);

					$image_size = getimagesize($img->url);

					echo LayoutHelper::render(
						'joomla.html.image',
						[
							'src' 		=> $item->imageSrc,
							'alt' 		=> $item->imageAlt,
							'width'		=> $image_size[0],
							'height'	=> $image_size[1],
							'loading'	=> 'lazy',
							'class' 	=> 'carousel-item-img'
						]
					);
				?>
				<div class="carousel-caption text-start">
					<?php echo $item->imageCaption; ?>
					<div class="carousel-caption-inner">
						<?php if ($params->get('link_titles') == 1) : ?>
						<?php $attributes = ['class' => 'mod-articles-category-title link-light text-uppercase text-decoration-none' . $item->active]; ?>
						<?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
						<?php $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false); ?>
						<p class="display-3">
							<?php echo HTMLHelper::_('link', $link, $title, $attributes); ?>
						</p>
						<?php else : ?>
						<p class="text-danger"><?php echo $item->title; ?></p>
						<?php endif; ?>

						<?php if ($item->displayHits) : ?>
						<span class="mod-articles-category-hits">
							(<?php echo $item->displayHits; ?>)
						</span>
						<?php endif; ?>

						<?php if ($params->get('show_author')) : ?>
						<span class="mod-articles-category-writtenby">
							<?php echo $item->displayAuthorName; ?>
						</span>
						<?php endif; ?>

						<?php if ($item->displayCategoryTitle) : ?>
						<span class="mod-articles-category-category">
							(<?php echo $item->displayCategoryTitle; ?>)
						</span>
						<?php endif; ?>

						<?php if ($item->displayDate) : ?>
						<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
						<?php endif; ?>

						<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
						<div class="mod-articles-category-tags">
							<?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
						</div>
						<?php endif; ?>

						<?php if ($params->get('show_introtext')) : ?>
						<?php
							$db = Factory::getDbo();
							$query = $db
								->getQuery(true)
								->select('introtext')
								->from($db->quoteName('#__content'))
								->where($db->quoteName('id') . " = " . $db->quote($item->id));
							$db->setQuery($query);
							echo $db->loadResult();
						?>
						<?php endif; ?>
						<?php if ($params->get('show_readmore')) : ?>
						<div class="mod-articles-category-readmore">
							<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
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
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $module->id; ?>"
			data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $module->id; ?>"
			data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>
