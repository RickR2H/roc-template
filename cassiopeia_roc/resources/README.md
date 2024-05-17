### Voorbereiding

- Installeer Joomla
- Verwijder algemene meldingen en melding over delen statistieken
- Installeer de template
- Activeer template_roc en zet als default
- Download en installeer de Font Awesome plugin: https://github.com/RickR2H/plg-system-fontawesome-isons/archive/refs/heads/master.zip
- Ga naar System -> Plugins om deze te activeren

#### Template cassiopeia_roc

- Logo Title: ROC Tilburg
- Tag line: Web development
- Sticky header: on
- Scroll to top: on

#### Module: Main Menu Blog | Type: Menu

- Layout: menu-offcanvas

### Font awesome toevoegen

- Open het Menu "Main Menu Blog" en open het menu item "Blog". Ga naar "Link Type" en voeg icon class "fa-solid fa-book ps-0 pe-3" toe.<br>
  Referentie:<br> Joomla 3: icon-\* https://docs.joomla.org/J3.x:Joomla_Standard_Icomoon_Fonts/nl<br>Joomla 5 Font Awesome Free: https://fontawesome.com/search?o=r&m=free

#### Module: Main Menu | Type: Menu

- Module positie: footer

#### Module: Image | Type: Custom

- Layout: custom-banner
- Image: hero-bg.jpg

#### Module: Latest Posts | Type: Articles - Newsflash

- module class suffix: usp-blocks mb-5
- Header class: text-primary text-center mt-3 mb-5 text-uppercase
- Title: Show
- Show Article Images: no
- Show Intro/Full Image: no
- Trigger Plugin Events: no
- 'Read more …' Link: no
- Number of Articles: 4

#### Module: Search | Type: Smart Search

- Layout: modal

#### Module: Syndication | Type: Syndication Feeds

- Menu Assignment: Alleen aan Blog menu item

#### Module: Login Form | Type: Login

- Menu Assignment: Alleen aan Blog menu item

#### Menu item Home installen:

- 3 naast elkaar (Geen intro item / 3 kolommen / Multi Column Direction naast elkaar)
- Article Info Title: Hide
- Category: Hide
- Publish Date: Hide
- Read More with Title: Hide
- Hits: Hide

#### Artikel dupliceren

- Dupliceer een artikel in de categorie Joomla.
- Verander de titel en de alias zodat er 4 blokken aan de bovenkant komen.- Stel de module in op 4 artikelen

#### Artikelen inkorten

- Kort alle speciale artikelen in of voeg een lees meer in om beter te tonen in de featured articles blog op de homepage.
- About your home page artikel heeft een custom field. Maak in het custom field deze informatie leeg.

- In de module posities (container-top-a, container-top-b,
  .container-bottom-a, container-bottom-b) hebben we CSS-grid toegepast welke we uit de Bootstrap CSS hebben gekopieerd. Hierdoor kunnen we grid classes gebruiken om de breedte van modules te organiseren. ook de default .grid class werkt. Dit kan handig zijn bij het maken van overrides.

#### Module: Older Posts | Articles - Category

- Style: noCard
- Module class: g-col-lg-8 g-start-lg-3
- Header Class: my-4
- Layout: accordion
- Experimenteer de verschillende layouts overrides:
  - blog
  - blogCard
  - carousel
  - swiper

#### Module: Popular Tags | Type: Tags - Popular

- Verplaats module naar positie: bottom-a
- Module class: g-col-lg-8 g-start-lg-3
- Header class: bg-info text-white
- Menu Assignment -> Module Assignment: Only on selected
- Menu Selection -> Only home is checked

#### Module: Footer | Copyright

- Maak een moduke aan type: footer
- Title: Copyright
- Naam: Copyright
- Positie: footer

#### Menu: Contact menu

- Maak een menu aan: Contact menu
- Maak 2 menu items aan met iconen.
  - Title: myemailaddress@r2h.nl<br>
    Link Icon Class: fa-regular fa-lg fa-envelope ps-0<br>
    Menu Item Type: URL / mailto:myemailaddress@r2h.nl<br>
  - Title: +31 6 123 456 789
    Link Icon Class: fa-solid fa-lg fa-mobile-screen-button ps-0<br>
    Menu Item Type: URL / tel:+316123456789<br>

#### Module: Menu | Contact menu

- Maak module aan: Contact menu | Type menu
- Title: Contact menu
- Position: topbar
- Select menu: Contact menu
- Menu Class: d-flex flex-row gap-3
- Layout: Default

#### Menu: Social media icons

- Maak een menu aan: Social media icons
- Maak 4 menu items aan met iconen.
  - Title: Facebook<br>
    Link Icon Class: fa-brands fa-lg fa-square-facebook ps-0<br>
    Display Menu Item Title: No<br>
    Menu Item Type: URL / #<br>
  - Title: X
    Link Icon Class: fa-brands fa-lg fa-square-x-twitter ps-0<br>
    Display Menu Item Title: No<br>
    Menu Item Type: URL / #<br>
  - Title: LinkedIn
    Link Icon Class: fa-brands fa-lg fa-linkedin ps-0<br>
    Display Menu Item Title: No<br>
    Menu Item Type: URL / #<br>
  - Title: Instagram
    Link Icon Class: fa-brands fa-lg fa-square-instagram ps-0<br>
    Display Menu Item Title: No<br>
    Menu Item Type: URL / #<br>

#### Module: Menu | Social media icons

- Maak module aan: Social media icons | Type menu
- Title: Social media icons
- Position: topbar
- Select menu: Social media icons
- Menu Class: d-flex flex-row gap-2
- Layout: Default

#### Module: Custom | 3 modules in top-b

- Module 1:

  - Title: zelf in te vullen
  - Title: show
  - Content: zelf in te vullen (center the text in de editor)
  - Header Class: text-center mt-5 mb-4
  - Module Style: noCard
  - Menu Assignment: Home

- Module 2:

  - Title: zelf in te vullen
  - Title: hidden
  - Content: zelf in te vullen
  - Module Class: g-col-lg-6 pe-lg-4
  - Module Style: noCard
  - Menu Assignment: Home

- Module 3:
  - Title: zelf in te vullen
  - Title: hidden
  - Content: image met class: aspect-ratio-2-1
  - Module Style: noCard
  - Menu Assignment: Home

#### Module: Custom | met params.xml opties

- Title: zelf in te vullen
- Title: show
- Content: zelf in te vullen
- Header Class: text-center mt-5 mb-4
- Module Style: noCard
- Menu Assignment: Home
- Layout: grid

#### Utility classes

- Menu item class: **center-blog-title** (Centreer blog titel h1)
- Menu item class: **center-article-title** (Centreer artikel titel h1)
- Menu item class: **center-blog-title center-article-title** (Bij category/featured blog layout centreer de blog titel h1 en na doorklikken ook de artikel h1)
- aspect-ratio-1-1
- aspect-ratio-2-1
- aspect-ratio-4-3

## Module Breakout to full body width

Breakout of the site-grid to make module full body width (using CSS container queries)

- Module class: **breakout** (Module gets spanned full body width)
- Module class: **keep-content-width** (center content block and make same width as site grid. Combine with breakout)
- Example module class suffix for single module: **breakout keep-content-width bg-light**

#### Article blog & featured blog column classes

Reference: https://issues.joomla.org/tracker/joomla-cms/18319<br>
Columns classes: (default is 1 column)

- columns-2
- columns-3
- columns-4
- masonry-2
- masonry-3
- masonry-4

Blue line on top and a box shadow class:

- boxed

Image position: (default is image-left)

- image-left
- image-right
- image-bottom
- image-left image-alternate
- image-right image-alternate

## Compiling CSS with VScode

1. Create a folder .vscode in the root of the site
2. Install the SCSS compiler for VScode: https://marketplace.visualstudio.com/items?itemName=glenn2223.live-sass
3. Create a file called setting.json in the .vscode folder and add the code below

For the template.css use:

```
{
    "liveSassCompile.settings.formats":[
        {
            "format": "compressed",
            "extensionName": ".min.css",
            "savePath": "/media/templates/site/cassiopeia_roc/css"
        },
        {
            "format": "expanded",
            "extensionName": ".css",
            "savePath": "/media/templates/site/cassiopeia_roc/css"
        }
    ],
    "liveSassCompile.settings.generateMap": true,
    "liveSassCompile.settings.includeItems": [
        "/media/templates/site/cassiopeia_roc/scss/template.scss",
        "/media/templates/site/cassiopeia_roc/scss/template-rtl.scss"
    ]
}
```

For the user.css use:<br>

Note:

- create a user.scss in the media/scss folder
- Make sure all styling from the current user.css is copied as this will replace the user.css

```
{
    "liveSassCompile.settings.formats":[
        {
            "format": "compressed",
            "extensionName": ".min.css",
            "savePath": "/media/templates/site/cassiopeia_roc/css"
        },
        {
            "format": "expanded",
            "extensionName": ".css",
            "savePath": "/media/templates/site/cassiopeia_roc/css"
        }
    ],
    "liveSassCompile.settings.generateMap": true,
    "liveSassCompile.settings.includeItems": [
        "/media/templates/site/cassiopeia_roc/scss/user.scss"
    ]
}
```

4. Run the compiler to create the following files (the non minified versions are used when debug mode is enabled):

Template SCSS

- template.min.css
- template.css
- template-rtl.min.css
- template-rtl.css

User SCSS

- user.css
- user.min.css

## Add Bootstrap 5 scripts

https://gist.github.com/RickR2H/5fd309c32412c4a1be2d78f306c58951<br>
'.selector' : can be used to point to a certain element<br>
[] : Array of arguments like interval, pause, display etc.<br>

```
// Add HTMLHelper (Or use full tag like below)
use Joomla\CMS\HTML\HTMLHelper;

\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.alert');

\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.alert', '.selector');
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.button', '.selector');
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.carousel', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.collapse', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.dropdown', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.modal', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.offcanvas', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.popover', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.scrollspy', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tabs', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip', '.selector', []);
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.toast', '.selector', []);
```

## Use local Google fonts

Create folder: **media/templates/site/cassiopeia_THEMENAME/fonts**<br>
Create a file **customfont.css** in: **media/templates/site/cassiopeia_THEMENAME/css**<br>
Create local google font: https://gwfh.mranftl.com/fonts<br>
Download the font family and extract in the **/fonts** folder<br>
Copy the CSS and add this to the: **customfont.css**<br>
Add to the font-family to the end of the **customfont.css**:

```
:root {
    --cassiopeia-font-family-headings: 'Poppins', sans-serif;
    --cassiopeia-font-weight-headings: 400;
    --cassiopeia-font-family-body: 'Open Sans', sans-serif;
    --cassiopeia-font-weight-normal: 400;
}
```

Add the following line to the templateDetails.xml to load the local font

```
<option value="media/templates/site/cassiopeia_THEMENAME/css/customfont.css">Custom Font (local)</option>
```

## Custom color theme

- create CSS file in: media/templates/site/cassiopeia/css/global/custom_mystyles.css
- Copy the content of media/templates/site/cassiopeia/css/global/colors_standard.css
- Change the colors ond/or add your own CSS variables
- Select the style in the template "Color Theme" settings
- Note: user.css will override styling this file

## External resources to create a template / overrides

- https://magazine.joomla.org/all-issues/february-2022/joomla-4-cassiopeia-template-a-bunch-of-tips-tricks
- https://coolcat-creations.com/en/blog/customize-your-cassiopeia-template

### Snippets / Designs

- https://bootdey.com/bootstrap-snippets (Bootstrap code snippets)
- https://freefrontend.dev/code/bootstrap (Bootstrap code snippets)
- https://bootstrapmade.com (Bootstrap template examples)
- https://mobirise.com (Design builder based on Bootstrap)

### Generators HTML / CSS

- https://animista.net
- https://webcode.tools
  https://www.toptal.com/developers/css3maker

### Images / Graphics

- https://undraw.co/ (SVG)
- https://lottiefiles.com (animation)

### Libraries

-https://michalsnik.github.io/aos
