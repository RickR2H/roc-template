<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!$list)
{
	return;
}

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

$modId = 'mod-articlescategory' . $module->id;
$bsSize = $params->get('bootstrap_size', 4) == 0 ? 4 : $params->get('bootstrap_size', 4);

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->addInlineStyle('
#' . $modId . ' img.card-layout-img {
	aspect-ratio: 4/4;
	object-fit: cover;
	width: 100%;
	height: auto;
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
#' . $modId . ' img.card-layout-img:is(:hover, :focus) {
	scale: 1.05;
}', ['name' => $modId]);
?>
<div id="<?php echo $modId; ?>" class="mod-articlescategory category-module mod-list">
	<?php if ($grouped) : ?>
		<?php foreach ($list as $groupName => $items) : ?>
		<div class="grid">
			<div class="mod-articles-category-group g-col-12">
                <?php echo Text::_($groupName); ?>
            </div>
			<?php require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'blogCard') . '_items'); ?>
		</div>
		<?php endforeach; ?>
	<?php else : ?>
        <div class="grid">
            <?php $items = $list; ?>
            <?php require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'blogCard') . '_items'); ?>
        </div>
	<?php endif; ?>
</div>
