<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\ErrorDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
$wa->registerAndUseStyle($assetColorName, 'global/' . $paramsColorName . '.css');

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);
$fontStyles       = '';

if ($paramsFontScheme) {
    if (stripos($paramsFontScheme, 'https://') === 0) {
        $this->getPreloadManager()->preconnect('https://fonts.googleapis.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preconnect('https://fonts.gstatic.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preload($paramsFontScheme, ['as' => 'style', 'crossorigin' => 'anonymous']);
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, [], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'', 'crossorigin' => 'anonymous']);

        if (preg_match_all('/family=([^?:]*):/i', $paramsFontScheme, $matches) > 0) {
            $fontStyles = '--cassiopeia-font-family-body: "' . str_replace('+', ' ', $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-family-headings: "' . str_replace('+', ' ', $matches[1][1] ?? $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-weight-normal: 400;
			--cassiopeia-font-weight-headings: 700;';
        }
    } else {
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, ['version' => 'auto'], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'']);
        $this->getPreloadManager()->preload($wa->getAsset('style', 'fontscheme.current')->getUri() . '?' . $this->getMediaVersion(), ['as' => 'style']);
    }
}

// Enable assets
$wa->usePreset('template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.active.language')
    ->useStyle('template.user')
    ->useScript('template.user')
    ->addInlineStyle(":root {
		--hue: 214;
		--template-bg-light: #f0f4fb;
		--template-text-dark: #495057;
		--template-text-light: #ffffff;
		--link-color: var(--link-color);
		--template-special-color: #001B4C;
		$fontStyles
	}");

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Logo file or site title param
if ($this->params->get('logoFile')) {
    $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif ($this->params->get('siteTitle')) {
    $logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
} else {
    $logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block', 'loading' => 'eager', 'decoding' => 'async'], true, 0);
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer font awesome
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');

// Get the error code
$errorCode = $this->error->getCode();
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>

<body class="site error_site <?php echo $option
    . ' ' . $wrapper
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ' ' . $pageclass;
    echo ($this->direction == 'rtl' ? ' rtl' : '');
?>">
    <?php if ($this->countModules('topbar')) : ?>
        <div class="container-topbar bg-primary text-white"><!-- Added: bg-primary text-white -->
            <div class="container-fluid container-xxl d-flex flex-wrap justify-content-md-between py-2"><!-- Removed: grid-child / container-fluid container-xxl d-flex flex-wrap justify-content-md-between py-2 -->
                <jdoc:include type="modules" name="topbar" style="none" />
            </div>
        </div>
    <?php endif; ?>

    <header class="header container-header full-width d-flex align-items-center<?php echo $stickyHeader ? ' ' . $stickyHeader : ''; ?>"><!-- Added: d-flex align-items-center -->

        <!-- previous position topbar. Moved above header -->

        <?php if ($this->countModules('below-top')) : ?>
            <div class="grid-child container-below-top">
                <jdoc:include type="modules" name="below-top" style="none" />
            </div>
        <?php endif; ?>

        <!-- previous position brand. Moved inside container-nav -->

        <?php if ($this->countModules('menu', true) || $this->countModules('search', true)) : ?>
            <div class="grid-row container-nav d-flex flex-nowrap"><!-- Changed: grid-child to grid-row / Added: d-flex flex-nowrap -->

                <?php if ($this->params->get('brand', 1)) : ?>
                    <!-- <div class="grid-child"> --><!-- Disabled div -->
                        <div class="navbar-brand">
                            <a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
                                <?php echo $logo; ?>
                            </a>
                            <?php if ($this->params->get('siteDescription')) : ?>
                                <div class="site-description"><?php echo htmlspecialchars($this->params->get('siteDescription')); ?></div>
                            <?php endif; ?>
                        </div>
                    <!-- </div> --><!-- Disabled div -->
                <?php endif; ?>

                <?php if ($this->countModules('menu', true)) : ?>
                    <jdoc:include type="modules" name="menu" style="none" />
                <?php endif; ?>
                <?php if ($this->countModules('search', true)) : ?>
                    <div class="container-search d-flex align-items-center mt-0"><!-- Added: d-flex align-items-center mt-0 -->
                        <jdoc:include type="modules" name="search" style="none" />
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </header>

    <div class="site-grid">
        <div class="grid-child container-component">
            <?php if ($this->countModules('error-' . $errorCode)) : ?>
                <div class="container">
                    <jdoc:include type="message" />
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <h1 class="display-1"><?php echo $this->error->getCode(); ?></h1>
                        <p class="display-4"><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>

                        <jdoc:include type="modules" name="error-<?php echo $errorCode; ?>" style="none" />

                        <p><strong><?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
                        <p><?php echo Text::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
                    <ul>
                        <li><?php echo Text::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                    </ul>
                    <p><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
                    <p><a href="<?php echo $this->baseurl; ?>/index.php" class="btn btn-secondary"><span class="icon-home" aria-hidden="true"></span> <?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
                    <hr>
                    <p><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
                    </div>
                </div>
            <?php else : ?>
                <div class="container">
                    <jdoc:include type="message" />
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <h1 class="display-1"><?php echo $this->error->getCode(); ?></h1>
                        <p class="display-4"><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
                        <jdoc:include type="modules" name="error-<?php echo $errorCode; ?>" style="none" />
                        <p><strong><?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
                    <p><?php echo Text::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
                    <ul>
                        <li><?php echo Text::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                        <li><?php echo Text::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                    </ul>
                    <p><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
                    <p><a href="<?php echo $this->baseurl; ?>/index.php" class="btn btn-secondary"><span class="icon-home" aria-hidden="true"></span> <?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
                    <hr>
                    <p><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->debug) : ?>
                <div>
                    <?php echo $this->renderBacktrace(); ?>
                    <?php // Check if there are more Exceptions and render their data as well ?>
                    <?php if ($this->error->getPrevious()) : ?>
                        <?php $loop = true; ?>
                        <?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
                        <?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
                        <?php $this->setError($this->_error->getPrevious()); ?>
                        <?php while ($loop === true) : ?>
                            <p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                            <p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php echo $this->renderBacktrace(); ?>
                            <?php $loop = $this->setError($this->_error->getPrevious()); ?>
                        <?php endwhile; ?>
                        <?php // Reset the main error object to the base error ?>
                        <?php $this->setError($this->error); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($this->countModules('footer')) : ?>
    <footer class="container-footer footer full-width">
        <div class="grid-child">
            <jdoc:include type="modules" name="footer" style="none" />
        </div>
    </footer>
    <?php endif; ?>

    <jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
