<?php

	require "class.iCalReader.php";

	$ical = new ical($_GET["path"]);

	print("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
	print("<rss version=\"2.0\">\n");
	print("<channel>\n");

	print("<title>ical2rss feed</title>\n");
	print("<description>An ical feed converted to RSS.</description>\n");
	print("<link>" . $_GET["path"] . "</link>\n");
	print("<lastBuildDate>" . date(DATE_RSS) . "</lastBuildDate>\n");
	print("<pubDate>" . date(DATE_RSS) . "</pubDate>\n");
	print("<ttl>1800</ttl>\n");

	foreach ($ical->events() as $event)
	{
		print("<item>\n");
		print("<title>" . $event["SUMMARY"] . "</title>\n");
		print("<description>" . $event["DESCRIPTION"] . "</description>\n");
		print("<link>" . $event["UID"] . "</link>\n");
		print("<guid>" . $event["UID"] . "</guid>\n");
		print("<pubDate>" . $event["DTSTART"] . "</pubDate>\n");
		print("</item>\n");
	}

	print("</channel>\n");
	print("</rss>\n");

?>