When we add new modules to Divi Pixel, there are the following steps to take:

1. Create a new Folder in /includes/modules/ or copy an existing module folder
2. Create a new php and jsx file inside the module folder with the same name as the folder
3. Create a new style.css file inside the module folder 
4. Add the module to the index.js inside the modules folder (makes sure to follow the naming conventions below and import the right file)
5. If not done already, add a new switch and toggle in settings.php for the new module
6. Add a check in loader.php in the includes folder to check whether or not the module has to be loaded, only then load the php file 
7. If the module required custom JS code, place the module related code in /public/js/public.js
8. If the module required third party JS code, place the third party js in /public/js

The naming convention of the module is PascalCasing and the module should have a meaningful name. Normally that name is derived from Asana.
There are additional naming conventions to follow inside the modules source code:
- The class name of the module (in php and jsx) is the filename prefixed with "DIPI_" to prevent name conflicts with other third party modules
- The slug of the module is equal to the filename but in snake casing (e. g. DIPI_MasonryGallery becomes dipi_masonry_gallery)
- The name of the module (in php init function) is normally equal to the file name but with spaces (e. g. MasonryGallery becomes Masonry Gallery). It should always be meaningful and normally can be derived from Asanas module name
- In php, non-divi functions get prefixed with "dipi_" to prevent naming conflicts in case that Divi core introduces new core functions (e.g instead of $this->do_something() we would use $this->dipi_do_something())
- In jsx, non-divi functions and non-react functions get prefixed with "_" (e. g. instead of this.do_something() we would use this._do_something())
- The module credits should be filled in. As author we use "Divi Pixel". As author_uri we use https://divi-pixel.com. As module_uri we use https://divi-pixel.com/modules/ plus the module name but with - instead of spaces. (e. g. for the "Masonry Gallery" module we would use https://divi-pixel.com/modules/masonry-gallery)

Besides that, make sure never to use hard coded string. Instead, always use translatable strings with: 
- esc_html__('the string', 'dipi-divi-pixel') whenever not using a string inside a html attribute
- esc_attr__('the string', 'dipi-divi-pixel') whenever using a string inside a html attribute