## Chancrapper

go away, nothing to see here

## [`HACKING`][hacking]

most files from the laravel framework. a lot of crap that can be ignored.

read their [docs][]

### installation

local installation for development if you want to test instead of
yolopullrequesting:

* get a php installation with the requirements in laravel's [installation][]
  page (no web server required)
    * alternatively, use [homestead][], a prepackaged VM for the lazy
* get [composer][]
* `composer install` to install dependencies
* copy `.env.example` to `.env`, fill in relevant values
* steal the database from the production server
* `php artisan serve` to start a local development server

### interesting files

* `app/Scrape.php` - model for the 'scrape' table
    * mostly just accessors methods to provide new attributes that make more
      sense than what's in the db
* `app/Http/routes.php` - main URL handling
    * the current equivalent to a controller. it just grabs stuff from the
      model and throws it at the views
* `resources/views/*.twig` - [twig][] templates (see [twigbridge][] docs for
  laravel integration details).
    * `app.twig` is the main template, the others extend it
    * `{% block navbar %}` and `{% block head %}` can be used to embed stuff
      from child templates into the main one
    * `row.thumbnail_url` == `$row->thumbnailUrl` (actually implemented as
      `Scrape::getThumbnailUrlAttribute()`)
* `resources/assets/less/app.less` - LESS stylesheet
    * this one came with laravel 5, see the [elixir][] docs on how to compile
      to css.
    * alternatively just add `<style>` blocks to individual pages like i've
      been doing

[hacking]: https://www.youtube.com/watch?v=5CoaTHGZ6bo
[docs]: http://laravel.com/docs/5.0
[installation]: http://laravel.com/docs/5.0/installation
[homestead]: http://laravel.com/docs/5.0/homestead
[composer]: https://getcomposer.org/
[elixir]: http://laravel.com/docs/5.0/elixir
[twig]: http://twig.sensiolabs.org/
[twigbridge]: https://github.com/rcrowe/TwigBridge
