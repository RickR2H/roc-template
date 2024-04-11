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
    echo 'Select a background image to use this layout override!';
    return;
}

use Joomla\CMS\HTML\HTMLHelper;

$modId = 'mod-custom' . $module->id;
$style = '';

$bgImage = HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();

/**
 * Add custom styling for this module
 * ---------------------------------------------
 */
$style .= <<<CSS
.bgimage{$modId} {
    width: 100%;
    object-fit: cover;
    height: 75vh;
    height: 75svh;
}
.child-inner {
    background-color: rgba(255, 255, 255, .6);
}

@media (max-width: 992px) {
    .bgimage{$modId} {
        height: 60vh;
        height: 60svh;
    }
}
CSS;

$wa->addInlineStyle($style, ['name' => $modId]);

/**
 * Add aos.js animation script
 * ---------------------------------------------
 * https://michalsnik.github.io/aos/
 *
 * Basis parameters
 * data-aos="fade-up"
 * data-aos-duration="3000"
 * data-aos-offset="500"
 *
 */
$wa->registerAndUseStyle('aos.css', 'https://unpkg.com/aos@next/dist/aos.css');
$wa->registerAndUseScript('aos.js', 'https://unpkg.com/aos@next/dist/aos.js', [], ['defer' => true]);

$script = <<<SCRIPT
document.addEventListener("DOMContentLoaded", function(){
    AOS.init();
});
SCRIPT;

$wa->addInlineScript($script, ['name' => 'activateAOS']);
?>
<div class="mod-custom custom position-relative overflow-hidden" id="<?php echo $modId; ?>">
    <?php if (isset($bgImage)) : ?>
        <img class="bgimage<?php echo $modId; ?>" src="<?php echo $bgImage; ?>" alt="">
    <?php endif; ?>
    <div class="overlay-content position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center w-100">
        <div class="container-fluid container-xl">
            <div class="child-inner d-inline-block p-4 rounded" data-aos="fade-up" data-aos-duration="2000" >
            <?php echo $module->content; ?>
            </div>
        </div>
    </div>
</div>
