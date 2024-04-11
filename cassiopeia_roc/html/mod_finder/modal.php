<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_finder
 *
 * @copyright   (C) 2011 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Module\Finder\Site\Helper\FinderHelper;

HTMLHelper::_('bootstrap.modal');

// Load the smart search component language file.
$lang = $app->getLanguage();
$lang->load('com_finder', JPATH_SITE);

$input = '<input type="text" name="q" id="mod-finder-searchword' . $module->id . '" class="js-finder-search-query form-control" value="' . htmlspecialchars($app->getInput()->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"'
    . ' placeholder="' . Text::_('MOD_FINDER_SEARCH_VALUE') . '">';

$showLabel  = $params->get('show_label', 1);
$labelClass = (!$showLabel ? 'visually-hidden ' : '') . 'finder';
$label      = '<label for="mod-finder-searchword' . $module->id . '" class="' . $labelClass . '">' . $params->get('alt_label', Text::_('JSEARCH_FILTER_SUBMIT')) . '</label>';

$output = '';

if ($params->get('show_button', 0)) {
    $output .= $label;
    $output .= '<div class="mod-finder__search input-group">';
    $output .= $input;
    $output .= '<button class="btn btn-primary me-0" type="submit"><span class="icon-search icon-white" aria-hidden="true"></span> ' . Text::_('JSEARCH_FILTER_SUBMIT') . '</button>';
    $output .= '</div>';
} else {
    $output .= $label;
    $output .= $input;
}

Text::script('MOD_FINDER_SEARCH_VALUE');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_finder');

/*
 * This segment of code sets up the autocompleter.
 */
if ($params->get('show_autosuggest', 1)) {
    $wa->usePreset('awesomplete');
    $app->getDocument()->addScriptOptions('finder-search', ['url' => Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component', false)]);

    Text::script('JLIB_JS_AJAX_ERROR_OTHER');
    Text::script('JLIB_JS_AJAX_ERROR_PARSE');
}

$script = <<<SCRIPT
window.addEventListener('load', () => {
    const myModalEl = document.getElementById('modalPopup$module->id');
    const searchField = document.getElementById('mod-finder-searchword$module->id');

    // Move modal to end of the document so background color overlay works
    document.body.appendChild(myModalEl);

    myModalEl.addEventListener('shown.bs.modal', event => {
        searchField.focus();
    })
})
SCRIPT;

$wa->useScript('com_finder.finder')
   ->addInlineScript($script, ['name' => 'module' . $module->id]); // append inline script to webAssetManager
?>

<!-- Button trigger modal -->
<button
    type="button"
    class="btn btn-sm btn-outline-primary aspect-ratio-1-1 rounded-circle mx-2 border-2"
    data-bs-toggle="modal"
    data-bs-target="#modalPopup<?php echo $module->id; ?>">
    <i class="fas fa-search"></i>
</button>

<!-- Modal -->
<div
    class="modal fade"
    id="modalPopup<?php echo $module->id; ?>"
    tabindex="-1"
    aria-labelledby="modalPopup<?php echo $module->id; ?>Label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalPopup<?php echo $module->id; ?>Label"><?php echo $module->title; ?></h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form
                    class="mod-finder js-finder-searchform form-search"
                    action="<?php echo Route::_($route); ?>"
                    method="get"
                    role="search">
                    <?php echo $output; ?>
                    <?php $show_advanced = $params->get('show_advanced', 0); ?>
                    <?php if ($show_advanced == 2) : ?>
                    <br>
                    <a href="<?php echo Route::_($route); ?>" class="mod-finder__advanced-link"><?php echo Text::_('COM_FINDER_ADVANCED_SEARCH'); ?></a>
                    <?php elseif ($show_advanced == 1) : ?>
                    <div class="mod-finder__advanced js-finder-advanced">
                        <?php echo HTMLHelper::_('filter.select', $query, $params, ['class' => 'w-100']); ?>
                    </div>
                    <?php endif; ?>
                    <?php echo FinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>
                </form>
            </div>
        </div>
    </div>
</div>
