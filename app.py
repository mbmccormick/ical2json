#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
from flask import Flask, abort, request
from urllib import urlopen
from calendar_parser import CalendarParser
from dateutil.parser import *
from dateutil.tz import *
from datetime import *
import PyRSS2Gen

app = Flask(__name__)

@app.route('/')
def index():
    return u'Please use like <code>http://<script>document.write(location.host);</script><noscript>ical2rss.herokuapp.com</noscript>/http://www.myserver.com/path/to/file.ics</code><br>Source code and instructions at <a href="http://github.com/mbmccormick/ical2rss">http://github.com/mbmccormick/ical2rss</a>.'

@app.route('/<path:url>')
def convert_from_url(url):
    if url == 'favicon.ico':
        abort(404)
    if not url.startswith('http'):
        url = 'http://%s' % url
    
    cal = CalendarParser(ics_url = url)
    
    events = []
    
    for event in cal.parse_calendar():
        item = PyRSS2Gen.RSSItem(
            title = event["name"],
            link = event["url"],
            description = event["description"],
            guid = PyRSS2Gen.Guid(event["url"]),
            pubDate = parse(event["start_time"])
        )
        
        events.append(item)

    resp = PyRSS2Gen.RSS2(
        title = cal["title"],
        link = cal["url"],
        description = cal["subtitle"],
        lastBuildDate = datetime.now(),
        items = events
    )

    return resp.to_xml()

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port, debug=True)
