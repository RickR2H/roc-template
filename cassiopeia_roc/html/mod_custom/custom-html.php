<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

$modId  = 'mod-custom' . $module->id;

$html   = $params->get('customHtml', '');
$css    = $params->get('customCss', '');
$js     = $params->get('customJavascript', '');

if ($params->get('backgroundimage') || $css || $js) {
    /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
    $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

    if ($css) {
        $wa->addInlineStyle($css, ['name' => 'css-' . $modId]);
    }

    if ($js) {
        $wa->addInlineScript($js, ['name' => 'js-' . $modId]);
    }
}

if ($params->get('backgroundimage')) {
    $wa->addInlineStyle('
#' . $modId . '{background-image: url("' . Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url . '");}
', ['name' => $modId]);
}
?>

<div id="<?php echo $modId; ?>" class="mod-custom custom">
    <?php echo $module->content; ?>
    <?php if ($html) : ?>
        <?php echo $html; ?>
    <?php endif; ?>
</div>

