# langs
Simple Language Manager

Demo:
http://langs.jonijnm.es/

Require:

* https://github.com/JoniJnm/JNMFW
* PHP 5.4+
* MySQL 5.5+

Deploy web:

1. Run gulp default task
2. Deploy proyect to the public_html folder
3. Copy Config.example.php to Config.php and configure the BD settings
4. Import the file install/structure.sql to the DB
5. Create a project from GUI
6. Add some languages to the table langs_langs


Usage in projects:

* cd /path/to/project
* npm install --save-dev gulp jlangs-processor
* Create gulpfile.js, example:

```js
var gulp = require('gulp');
var jlangs_processor = require('jlangs-processor');

gulp.task('langs', function(cb) {
   //more settings in:
   //https://github.com/JoniJnm/jlangs-processor/blob/master/src/parse.js

   jlangs_processor.all({
      id_project: 1, //id project in BBDD
      folders: ['.'], //folder for search langs
      output_method: 'json', //file lang format, more: https://github.com/JoniJnm/jlangs/blob/master/controllers/ExportController.php#L24
      exts_included: ['js', 'tpl'], //file to parse
      output_folder: './langs', //where save files
      funcs_names: ['translate'], //file search function
      attrs_names: ['data-translate'], //search this attribute in html tags
      url: 'http://langs.navenda.com', //url to your langs site
      Authorization: 'Basic YOUR_KEY' //Authorization header (optional)
   }, cb);
});
```

* In your files, you can code like:

```js
var myStr = langs.translate('Hello!');
console.alert(myStr);
```

```html
<div>
    <span data-translate="Hello world"></span>
</div>
```

* Run gulp task

```shell
gulp langs
```

* See files stored in output_folder
