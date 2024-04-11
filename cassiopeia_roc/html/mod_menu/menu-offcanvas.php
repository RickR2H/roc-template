<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Source: https://gist.github.com/drmenzelit/152a1954d73bcbe126194965e43c97f4

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

// Activate Bootstrap Offcanvas script
HTMLHelper::_('bootstrap.offcanvas');
?>
<nav class="navbar navbar-expand-lg navbar-offcanvas mt-0">
    <?php
    // Load module with ID 114 in this place
    // echo Joomla\CMS\HTML\HTMLHelper::_('content.prepare', '{loadmoduleid 114}');

    // Load module position with name block1 in this place
    // echo Joomla\CMS\HTML\HTMLHelper::_('content.prepare', '{loadposition block1}');
    ?>
    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#navbar<?php echo $module->id; ?>"
        aria-controls="navbar<?php echo $module->id; ?>"
        aria-expanded="false"
        aria-label="<?php echo Text::_('MOD_MENU_TOGGLE'); ?>">
        <span class="icon-menu" aria-hidden="true"></span>
    </button>
    <div class="offcanvas offcanvas-start" id="navbar<?php echo $module->id; ?>" data-bs-scroll="false" data-bs-backdrop="true">
        <div class="offcanvas-header pb-0">
            <button
                type="button"
                class="btn-close text-reset ms-auto"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <?php
                // Layout with collapsible sub menu items
                require Joomla\CMS\Helper\ModuleHelper::getLayoutPath('mod_menu', 'dropdown-metismenu');

                // Layout with expanded sub menu items
                //require Joomla\CMS\Helper\ModuleHelper::getLayoutPath('mod_menu', 'default');
            ?>
        </div>
    </div>
</nav>
