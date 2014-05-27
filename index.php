<?php

	require "class.iCalReader.php";

	$ical = new ical($_GET["path"]);

	$endDate = new DateTime();
	// if (isset($_GET["lookAhead"]) == true)
	// {
	// 	$endDate->add(new DateInterval("P" . $_GET["lookAhead"] . "D"));
	// }
	
	$events = $ical->sortEventsWithOrder($ical->events(), SORT_ASC);
	
	if (isset($_GET["showAll"]) == true)
	{
		$events = $ical->eventsFromRange(new DateTime("1970/01/01"), $endDate);
	}
	
	$lastBuildDate = date(DATE_RSS, $ical->iCalDateToUnixTimestamp($events[sizeof($events) - 1]["DTSTART"]));
	$pubDate = date(DATE_RSS, $ical->iCalDateToUnixTimestamp($events[0]["DTSTART"]));
	
	header("Content-Type: application/rss+xml");

	print("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
	print("<rss version=\"2.0\">\n");
	print("<channel>\n");

	print("<title>ical2rss feed</title>\n");
	print("<description>An ical feed converted to RSS.</description>\n");
	print("<link>" . $_GET["path"] . "</link>\n");
	print("<lastBuildDate>" . $lastBuildDate . "</lastBuildDate>\n");
	print("<pubDate>" . $pubDate . "</pubDate>\n");
	print("<ttl>1800</ttl>\n");
	
	foreach ($events as $event)
	{
		print("<item>\n");
		print("<title>" . htmlspecialchars($event["SUMMARY"]) . "</title>\n");
		print("<description>" . htmlspecialchars($event["DESCRIPTION"]) . "</description>\n");
		print("<link>" . $event["UID"] . "</link>\n");
		print("<guid>" . $event["UID"] . "</guid>\n");
		print("<pubDate>" . date(DATE_RSS, $ical->iCalDateToUnixTimestamp($event["DTSTART"])) . "</pubDate>\n");
		print("</item>\n");
	}

	print("</channel>\n");
	print("</rss>\n");

?>
