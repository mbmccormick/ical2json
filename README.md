ical2rss
=========

This is a super simple webservice that consumes iCal data (.ics file) that is publicly available at an HTTP URL and returns an RSS feed.


Installation (on Heroku)
----------------------

```
$ heroku create
Creating ical2rss... done, stack is cedar
http://ical2rss.herokuapp.com/ | git@heroku.com:ical2rss.git
Git remote heroku added

$ git push heroku master
Initializing repository, done.
Counting objects: 59, done.
Delta compression using up to 8 threads.
Compressing objects: 100% (52/52), done.
Writing objects: 100% (59/59), 7.95 KiB | 0 bytes/s, done.
Total 59 (delta 21), reused 0 (delta 0)

-----> PHP app detected
 !     WARNING:        No composer.json found.
       Using index.php to declare PHP applications is considered legacy
       functionality and may lead to unexpected behavior.
       See https://devcenter.heroku.com/categories/php
-----> Setting up runtime environment...
       - PHP 5.5.12
       - Apache 2.4.9
       - Nginx 1.4.6
-----> Installing PHP extensions:
       - opcache (automatic; bundled, using 'ext-opcache.ini')
-----> Installing dependencies...
       Composer version 7131607ad1d251c790ce566119d647e008972aa5 2014-05-27 14:26:24
       Loading composer repositories with package information
       Installing dependencies
       Nothing to install or update
       Generating optimized autoload files
-----> Building runtime environment...
       NOTICE: No Procfile, defaulting to 'web: vendor/bin/heroku-php-apache2'
-----> Discovering process types
       Procfile declares types -> web
-----> Compressing... done, 57.3MB
-----> Launching... done, v16
       http://ical2rss.herokuapp.com/ deployed to Heroku

To git@heroku.com:ical2rss.git
 * [new branch]      master -> master
```

Done.


Usage
-----

Simply construct an URL like this:

    http://0.0.0.0:5000/http://hostname.com/path/to/file.ics

E.g., let's say we want to get the iCal data available at http://ws.audioscrobbler.com/1.0/artist/Shout+Out+Louds/events.ics in JSON format, the URL would look like this:

    http://0.0.0.0:5000/http://ws.audioscrobbler.com/1.0/artist/Shout+Out+Louds/events.ics

The response would look something like this:

```json
{
  "VCALENDAR": {
    "VEVENT": [
      {
        "DTSTAMP": "20110328T203000",
        "UID": "LFMEVENT-1748422",
        "URL": "http://www.last.fm/event/1748422+Shout+Out+Louds+at+La+Machine+du+Moulin+Rouge+on+28+March+2011",
        "SUMMARY": "Shout Out Louds at La Machine du Moulin Rouge",
        "LOCATION": "La Machine du Moulin Rouge, Paris, France",
        "DTEND": "20110328T235900",
        "DTSTART": "20110328T203000",
        "GEO": "2.332258;48.884008",
        "DESCRIPTION": "Shout Out Louds\n\nhttp://www.last.fm/event/1748422+Shout+Out+Louds+at+La+Machine+du+Moulin+Rouge+on+28+March+2011"
      },
      {
        "DTSTAMP": "20110329T203000",
        "UID": "LFMEVENT-1755031",
        "URL": "http://www.last.fm/event/1755031+Shout+Out+Louds+at+La+Nef+on+29+March+2011",
        "SUMMARY": "Shout Out Louds + Hello Bye Bye at La Nef",
        "LOCATION": "La Nef, Angoul\u00eame, France",
        "DTEND": "20110329T235900",
        "DTSTART": "20110329T203000",
        "GEO": "0.130579;45.640423",
        "DESCRIPTION": "Shout Out Louds, Hello Bye Bye\n\nhttp://www.last.fm/event/1755031+Shout+Out+Louds+at+La+Nef+on+29+March+2011"
      }
      # …
    ],
    "VERSION": "2.0",
    "X-WR-CALNAME": "Last.fm Events",
    "PRODID": "-//Last.fm Limited Event Feeds//NONSGML//EN",
    "X-WR-CALDESC": "Event listing - supplied by http://www.Last.fm"
  }
}
```


Status
------

I wrote this thing in less than an hour. For me it does what I want it to do. But I have not tested a whole lot of different URLs. And it probably does not cover everything that is part of the iCal spec. So if you find something that does not work feel free to fork and send a pull request.
