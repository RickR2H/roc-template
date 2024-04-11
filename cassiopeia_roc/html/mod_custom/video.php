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

$modId = 'mod-custom' . $module->id;

$bgImage = HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url
    ? Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url
    : 'https://cdn.coverr.co/videos/coverr-misty-mountain-road-journey/thumbnail?width=1920';

/* INLINE SCRIPT */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();

$script = <<<SCRIPT
window.addEventListener('load', () => {
    const videoBanner   = document.getElementById('video-banner{$module->id}');
    const staticImage   = document.getElementById('static-image{$module->id}');
    const toggleButton  = document.getElementById('toggle-button{$module->id}');

    // Check if the user is on a mobile device
    const isMobile      = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    toggleVideo = () => {

        videoBanner.classList.remove('d-none');
        staticImage.classList.remove('d-block');

        if (videoBanner.paused) {
            videoBanner.play();
            toggleButton.innerHTML = ('<i class="fa-solid fa-fw fa-lg fa-pause"></i>');

        } else {
            videoBanner.pause();
            toggleButton.innerHTML = ('<i class="fa-solid fa-fw fa-lg fa-play"></i>');
        }
    }

    // Toggle video on button click
    toggleButton.addEventListener('click', toggleVideo);

    if (isMobile || window.innerWidth < 1000) {
        // Hide video on mobile and display static image
        videoBanner.classList.add('d-none');
        staticImage.classList.add('d-block');
        toggleButton.innerHTML = ('<i class="fa-solid fa-play"></i>');

        // Add click event to the static image to play the video
        // staticImage.addEventListener('click', function () {
        //     videoBanner.style.display = 'block';
        //     staticImage.style.display = 'none';
        //     videoBanner.play();
        // });
    }
});
SCRIPT;

$wa->addInlineScript($script, ['name' => 'module' . $module->id]);
?>
<div id="video-container<?php echo $module->id; ?>" class="position-relative w-100 overflow-hidden" style="height: 500px">
    <video id="video-banner<?php echo $module->id; ?>" class="w-100 h-100 object-fit-cover" autoplay loop muted>
        <source src="https://cdn.coverr.co/videos/coverr-misty-mountain-road-journey/1080p.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <img id="static-image<?php echo $module->id; ?>" class="w-100 h-100 object-fit-cover" src="<?php echo $bgImage; ?>" alt="">
    <div class="overlay position-absolute top-0 w-100 h-100 d-flex align-items-center justify-content-center overflow-hidden text-white" style="background-color: rgba(var(--info-rgb),.6)">
        <div class="text">
            <?php echo $module->content; ?>
        </div>
    </div>
    <button id="toggle-button<?php echo $module->id; ?>" class="rounded-circle position-absolute top-0 end-0 m-3 btn btn-danger d-flex align-items-center justify-content-center" style="width: 50px;height: 50px;"><i class="fa-solid fa-fw fa-lg fa-pause"></i></button>
</div>
