<?php
# Send correct headers      
header("Content-type: text/x-vcalendar; charset=utf-8"); 
# Alternatively: application/octet-stream
# Depending on the desired browser behaviour
# Be sure to test thoroughly cross-browser

header("Content-Disposition: attachment; filename=\"cbesse.ics\";");

echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "BEGIN:VEVENT\n";
echo "SUMMARY:Click attached contact below to save to your contacts\n";
$dtstart = date("Ymd")."T".date("Hi")."00";
echo "DTSTART;TZID=Europe/London:".$dtstart."\n";
$dtend = date("Ymd")."T".date("Hi")."01";
echo "DTEND;TZID=Europe/London:".$dtend."\n";
echo "DTSTAMP:".$dtstart."Z\n";
echo "ATTACH;VALUE=BINARY;ENCODING=BASE64;FMTTYPE=text/directory;\n";
echo " X-APPLE-FILENAME=cbesse.vcf:\n";
$vcard = file_get_contents("cbesse.vcf");        # read the file into memory
$b64vcard = base64_encode($vcard);                      # base64 encode it so that it can be used as an attachemnt to the "dummy" calendar appointment
$b64mline = chunk_split($b64vcard,74,"\n");             # chunk the single long line of b64 text in accordance with RFC2045 (and the exact line length determined from the original .ics file exported from Apple calendar
$b64final = preg_replace('/(.+)/', ' $1', $b64mline);   # need to indent all the lines by 1 space for the iphone (yes really?!!)
echo $b64final;                                         # output the correctly formatted encoded text
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
?>