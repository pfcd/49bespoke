// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from './modules';
import fields from './fields';

$(window).on('et_builder_api_ready', (event, API) => {
  // FIXME: For some reasone ParallaxImages & ParallaxImagesItem not loaded automatically.
  API.registerModules([...modules]);
  API.registerModalFields(fields);
});
