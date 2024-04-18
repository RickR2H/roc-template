<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!$params->get('backgroundimage')) {
    echo 'Set background image in module to use the parallax effect!';
    return;
}

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

$modId      = 'mod-custom' . $module->id;
$bgImage    = Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();

$script = <<<SCRIPT
window.addEventListener('DOMContentLoaded', () => {
    var images = document.querySelectorAll('.parallax-image');
    new simpleParallax(images, {
        orientation: 'up left', // up, right, down, left, up left, up right, down left, left right
        scale: 1.5
    });
})
SCRIPT;

$style = <<<CSS
#{$modId} {
    position: relative;
}
#{$modId} .overlay {
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(var(--light-rgb),.8);
}
#{$modId} .overlay-inner {
    max-width: 80ch;
}
#{$modId} .parallax-image {
    height: 600px;
}
@media screen and (height <= 740px) {
    #{$modId} .parallax-image {
        height: 100vh;
        height: 100svh;
    }
}
CSS;

// https://simpleparallax.com/
$wa->registerAndUseScript('simpleParallax', 'https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js')
    ->addInlineScript($script, ['name' => 'simpleParallaxActive'])
    ->addInlineStyle($style, ['name' => 'module' . $module->id]);
?>
<div
    class="mod-custom custom simple-parallax"
    id="<?php echo $modId; ?>">
    <img class="parallax-image object-fit-cover w-100" src="<?php echo $bgImage; ?>" alt="" style="height: 600px;" loading="lazy">
    <div class="overlay d-flex align-items-center justify-content-center">
        <div class="overlay-inner">
            <?php echo $module->content; ?>
        </div>
    </div>
</div>
