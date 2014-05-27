<?php

	require "class.iCalReader.php";

	$ical = new ical($_GET["path"]);

	$data = $ical->events();
	
	header("Content-Type: application/rss+xml");

	print("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
	print("<rss version=\"2.0\">\n");
	print("<channel>\n");

	print("<title>ical2rss feed</title>\n");
	print("<description>An ical feed converted to RSS.</description>\n");
	print("<link>" . $_GET["path"] . "</link>\n");
	print("<lastBuildDate>" . date(DATE_RSS) . "</lastBuildDate>\n");
	print("<pubDate>" . $ical->iCalDateToUnixTimestamp($events[0]["DTSTART"]) . "</pubDate>\n");
	print("<ttl>1800</ttl>\n");
	
	if ($_GET["showAll"] != "true")
		$data = $ical->eventsFromRange(new DateTime('1970/01/01'), new DateTime());
	
	foreach ($data as $event)
	{
		print("<item>\n");
		print("<title>" . $event["SUMMARY"] . "</title>\n");
		print("<description>" . $event["DESCRIPTION"] . "</description>\n");
		print("<link>" . $event["UID"] . "</link>\n");
		print("<guid>" . $event["UID"] . "</guid>\n");
		print("<pubDate>" . date(DATE_RSS, $ical->iCalDateToUnixTimestamp($event["DTSTART"])) . "</pubDate>\n");
		print("</item>\n");
	}

	print("</channel>\n");
	print("</rss>\n");

?>
