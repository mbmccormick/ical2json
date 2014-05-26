#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
from flask import Flask, abort, request
from icalendar import Calendar
from PyRSS2Gen import PyRSS2Gen
from urllib import urlopen

app = Flask(__name__)

@app.route('/')
def index():
    return u'Please use like <code>http://<script>document.write(location.host);</script><noscript>ical2json.pb.io</noscript>/http://www.myserver.com/path/to/file.ics</code><br>Source code and instructions at <a href="http://github.com/philippbosch/ical2json">http://github.com/philippbosch/ical2json</a>.'

@app.route('/<path:url>')
def convert_from_url(url):
    if url == 'favicon.ico':
        abort(404)
    if not url.startswith('http'):
        url = 'http://%s' % url
    uh = urlopen(url)
    if uh.getcode() != 200:
        abort(404)
    ics = uh.read()
    uh.close()
    cal = Calendar.from_string(ics)
    data = {}
    data[cal.name] = dict(cal.items())

    for component in cal.subcomponents:
        if not data[cal.name].has_key(component.name):
            data[cal.name][component.name] = []

        comp_obj = {}
        for item in component.items():
            comp_obj[item[0]] = unicode(item[1])

        data[cal.name][component.name].append(comp_obj)

    resp = PyRSS2Gen.RSS2(
        title = "Andrew's PyRSSGen feed",
        link = "http://www.dalk2escientific.com/Python/PyRSS2Gen.html",
        description = "The latest news about PyRSS2Gen, a "
                  "Python library for generating RSS2 feeds",

        lastBuildDate = datetime.datetime.now(),

        items = [
            PyRSS2Gen.RSSItem(
                title = "PyRSS2Gen-0.0 released",
                link = "http://www.dalkescientific.com/news/030906-PyRSS2Gen.html",
                description = "Dalke Scientific today announced PyRSS2Gen-0.0, "
                       "a library for generating RSS feeds for Python.  ",
                guid = PyRSS2Gen.Guid("http://www.dalkescientific.com/news/"
                          "030906-PyRSS2Gen.html"),
                pubDate = datetime.datetime(2003, 9, 6, 21, 31)),
            PyRSS2Gen.RSSItem(
                title = "Thoughts on RSS feeds for bioinformatics",
                link = "http://www.dalkescientific.com/writings/diary/"
                "archive/2003/09/06/RSS.html",
                description = "One of the reasons I wrote PyRSS2Gen was to "
                       "experiment with RSS for data collection in "
                       "bioinformatics.  Last year I came across...",
                guid = PyRSS2Gen.Guid("http://www.dalkescientific.com/writings/"
                               "diary/archive/2003/09/06/RSS.html"),
                pubDate = datetime.datetime(2003, 9, 6, 21, 49)),
            ]
        )

    return resp.to_xml()

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port, debug=True)
