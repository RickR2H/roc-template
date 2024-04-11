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
?>

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
<div class="mod-articlescategory mb-3 d-flex flex-column g-col-lg-4">
	<div class="card mb-3 overflow-hidden h-100">
		<?php if ($params->get('link_titles') == 1) : ?>
		<?php $attributes = ['class' => 'mod-articles-category-title ' . $item->active]; ?>
		<?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
		<?php $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false); ?>
		<div class="image-wrapper overflow-hidden">
			<?php echo HTMLHelper::_('link',
				$link,
				LayoutHelper::render(
					'joomla.html.image',
					[
						'src' => $item->imageSrc,
						'alt' => $item->imageAlt,
						'class' => 'card-layout-img',
						'width'		=> $image_size[0],
						'height'	=> $image_size[1],
						'loading'	=> 'lazy',
						//'style' => 'aspect-ratio: 2/1; object-fit:cover; width: 100%;'
					]),
				$attributes); ?>
			<?php else : ?>
				<?php echo LayoutHelper::render(
					'joomla.html.image',
					[
						'src' => $item->imageSrc,
						'alt' => $item->imageAlt,
						'class' => 'card-layout-img',
						'width'		=> $image_size[0],
						'height'	=> $image_size[1],
						'loading'	=> 'lazy',
						//'style' => 'aspect-ratio: 2/1; object-fit:cover; width: 100%;'
					]);
				?>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<?php if ($params->get('link_titles') == 1) : ?>
				<h3 class="text-danger"><?php echo HTMLHelper::_('link', $link, $title, $attributes); ?></h3>
			<?php else : ?>
				<h3 class="h4 text-danger"><?php echo $item->title; ?></h3>
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
				<p class="mod-articles-category-readmore">
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
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endforeach; ?>
