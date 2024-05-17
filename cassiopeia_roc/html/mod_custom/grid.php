<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

$modId              = 'mod-custom' . $module->id;
$modWrapperId       = 'mod-custom__wrapper' . $module->id;

// Get all the parameters from the xml file
$gridcolumns        = $params->get('gridcolumns', '12');
$gridcolumnsProp    = '--columns:' . $gridcolumns . ';';
$gridrows           = $params->get('gridrows', '1');
$gridrowsProp       = '--rows:' . $gridrows . ';';
$gridgap            = $params->get('gridgap', '');
$gridwrapperclass   = $params->get('gridwrapperclass', 'grid');
$columnwrapperclass = $params->get('individualcolumnwrapperclass', '');
$animation          = $params->get('animation', false);
$columns            = $params->get('columns', '');

$bannerClass        = 'banner-container';

$htmlbefore         = $params->get('htmlbefore', '');
$htmlafter          = $params->get('htmlafter', '');
$styling            = $params->get('styling', '');
$totalStyling       = '';

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();

// Add grid gap property if gap parameter is set
if ($gridgap) {
    $gridgapProp = '--gap:' . $gridgap . ';';
} else {
    $gridgapProp = '';
}

// Add the default background image to the mod_custom default code
if ($params->get('backgroundimage')) {
    $totalStyling .= '#' . $modId . '{background: url("' . Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url . '") no-repeat center right;
    min-height: 70vh;
    min-height: 70svh;
    background-size: cover;
    /*background-attachment: fixed;*/
    }
    @media (pointer: coarse) {
        #' . $modId . '{background-attachment: scroll;}
    }';
}

/* Add the inline CSS from the module parameters */
if ($styling) {
    $totalStyling .= $styling;
}

if ($totalStyling) {
    $style = <<<CSS
    $totalStyling
    CSS;
    $wa->addInlineStyle($style, ['name' => 'module' . $module->id]);
}

// Add the animation when activated in the settings
if ($animation) {
    $wa->registerAndUseStyle('aos.css', 'https://unpkg.com/aos@next/dist/aos.css');
    $wa->registerAndUseScript('aos.js', 'https://unpkg.com/aos@next/dist/aos.js', [], ['defer' => true]);

    $script = <<<SCRIPT
    document.addEventListener("DOMContentLoaded", function(){
        AOS.init();
    });
    SCRIPT;
    $wa->addInlineScript($script, ['name' => 'activateAOS']);
}
?>
<div id="<?php echo $modWrapperId; ?>" class="module-wrapper">

    <?php if ($htmlbefore) : ?>
        <!-- HTML before field -->
        <?php echo $htmlbefore; ?>
    <?php endif; ?>

    <?php if ($module->content) : ?>
        <!-- Default custom HTML block -->
        <div class="mod-custom custom <?php echo $bannerClass; ?> d-flex align-items-center justify-content-center" id="<?php echo $modId; ?>">
            <div class="<?php echo $bannerClass; ?>__inner">
                <?php echo $module->content; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($columns) : ?>
        <!-- Grid column blocks -->
        <div
            class="<?php echo $gridwrapperclass; ?> mod-custom grid-wrapper"
            style="<?php echo $gridcolumnsProp . $gridrowsProp . $gridgapProp; ?>">
            <?php foreach ($columns as $index => $column) : ?>

                <?php $column->columnclasses = $column->columnclasses ? ' ' . $column->columnclasses : ''; ?>
                <div class="<?php echo $index . ' ' . $columnwrapperclass . $column->columnclasses; ?>" <?php if ($animation) : ?>
                    <?php echo $column->animationtype ? ' data-aos="' . $column->animationtype . '"' : ''; ?>
                    <?php echo $column->animationdelay && $column->animationtype ? ' data-aos-delay="' . $column->animationdelay . '"' : ''; ?>
                    <?php endif; ?> <?php echo $column->columnattrib ? $column->columnattrib : ''; ?>>
                    <div class="grid-wrapper__content<?php echo $column->columncontentclass ? ' ' . $column->columncontentclass : ''; ?>">
                        <?php if ($params->get('prepare_content', 1)) : ?>
                            <?php echo $column->text ? HTMLHelper::_('content.prepare', $column->text) : ''; ?>
                        <?php else : ?>
                            <?php echo $column->text ? $column->text : ''; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($htmlafter) : ?>
        <!-- HTML after field -->
        <?php echo $htmlafter; ?>
    <?php endif; ?>
</div>
