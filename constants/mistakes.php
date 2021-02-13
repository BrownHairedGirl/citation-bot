<?php
declare(strict_types=1);

const COMMON_MISTAKES = array ( // Common mistakes that aren't picked up by the levenshtein approach
  "ASIN"            =>  "asin",
  "EISSN"           =>  "eissn",
  "HDL"             =>  "hdl",
  "ISBN13"          =>  "isbn",
  "isbn13"          =>  "isbn",
  "ISMN"            =>  "ismn",
  "ISSN"            =>  "issn",
  "JFM"             =>  "jfm",
  "JSTOR"           =>  "jstor",
  "LCCN"            =>  "lccn",
  "MR"              =>  "mr",
  "OCLC"            =>  "oclc",
  "OL"              =>  "ol",
  "OSTI"            =>  "osti",
  "PMC"             =>  "pmc",
  "PMID"            =>  "pmid",
  "RFC"             =>  "rfc",
  "S2CID"           =>  "s2cid",
  "SBN"             =>  "sbn",
  "SSRN"            =>  "ssrn",
  "ZBL"             =>  "zbl",
  "embargo"         =>  "pmc-embargo-date",
  "albumlink"       =>  "title-link",
  "titlelink"       =>  "title-link",
  "artist"          =>  "others",
  "authorurl"       =>  "author-link",
  "bioRxiv"         =>  "biorxiv",
  "co-author"       =>  "coauthor",
  "co-authors"      =>  "coauthors",
  "dio"             =>  "doi",
  "director"        =>  "others",
  "display_authors" =>  "display-authors",
  "displayauthors"  =>  "display-authors",
  "displayeditors"  =>  "display-editors",
  "doi_brokendate"  =>  "doi-broken-date",
  "doi_inactivedate"=>  "doi-broken-date",
  "doi-inactive-date" =>  "doi-broken-date",
  "doi-broken"      =>  "doi-broken-date",
  "ed"              =>  "editor",
  "ed2"             =>  "editor2",
  "ed3"             =>  "editor3",
  "ed4"             =>  "editor4",
  "ed5"             =>  "editor5",
  "ed6"             =>  "editor6",
  "ed7"             =>  "editor7",
  "ed8"             =>  "editor8",
  "ed9"             =>  "editor9",
  "ed10"            =>  "editor10",
  "editorlink1"     =>  "editor1-link",
  "editorlink2"     =>  "editor2-link",
  "editorlink3"     =>  "editor3-link",
  "editorlink4"     =>  "editor4-link",
  "editorlink5"     =>  "editor5-link",
  "editorlink6"     =>  "editor6-link",
  "editorlink7"     =>  "editor7-link",
  "editorlink8"     =>  "editor8-link",
  "editorlink9"     =>  "editor9-link",
  "editorlink10"    =>  "editor10-link",
  "editorlink11"    =>  "editor11-link",
  "editorlink12"    =>  "editor12-link",
  "editorlink13"    =>  "editor13-link",
  "editorlink14"    =>  "editor14-link",
  "editorlink15"    =>  "editor15-link",
  "editorlink16"    =>  "editor16-link",
  "editorlink17"    =>  "editor17-link",
  "editorlink18"    =>  "editor18-link",
  "editorlink19"    =>  "editor19-link",
  "editorlink20"    =>  "editor20-link",
  "editorlink21"    =>  "editor21-link",
  "editorlink22"    =>  "editor22-link",
  "editorlink23"    =>  "editor23-link",
  "editorlink24"    =>  "editor24-link",
  "editorlink25"    =>  "editor25-link",
  "editorlink26"    =>  "editor26-link",
  "editorlink27"    =>  "editor27-link",
  "editorlink28"    =>  "editor28-link",
  "editorlink29"    =>  "editor29-link",
  "editorlink30"    =>  "editor30-link",
  "editor1link"     =>  "editor1-link",
  "editor2link"     =>  "editor2-link",
  "editor3link"     =>  "editor3-link",
  "editor4link"     =>  "editor4-link",
  "editor5link"     =>  "editor5-link",
  "editor6link"     =>  "editor6-link",
  "editor7link"     =>  "editor7-link",
  "editor8link"     =>  "editor8-link",
  "editor9link"     =>  "editor9-link",
  "editor10link"    =>  "editor10-link",
  "editor11link"    =>  "editor11-link",
  "editor12link"    =>  "editor12-link",
  "editor13link"    =>  "editor13-link",
  "editor14link"    =>  "editor14-link",
  "editor15link"    =>  "editor15-link",
  "editor16link"    =>  "editor16-link",
  "editor17link"    =>  "editor17-link",
  "editor18link"    =>  "editor18-link",
  "editor19link"    =>  "editor19-link",
  "editor20link"    =>  "editor20-link",
  "editor21link"    =>  "editor21-link",
  "editor22link"    =>  "editor22-link",
  "editor23link"    =>  "editor23-link",
  "editor24link"    =>  "editor24-link",
  "editor25link"    =>  "editor25-link",
  "editor26link"    =>  "editor26-link",
  "editor27link"    =>  "editor27-link",
  "editor28link"    =>  "editor28-link",
  "editor29link"    =>  "editor29-link",
  "editor30link"    =>  "editor30-link",
  "editor-first1"   =>  "editor1-first",
  "editor-first2"   =>  "editor2-first",
  "editor-first3"   =>  "editor3-first",
  "editor-first4"   =>  "editor4-first",
  "editor-first5"   =>  "editor5-first",
  "editor-first6"   =>  "editor6-first",
  "editor-first7"   =>  "editor7-first",
  "editor-first8"   =>  "editor8-first",
  "editor-first9"   =>  "editor9-first",
  "editor-first10"  =>  "editor10-first",
  "editor-first11"  =>  "editor11-first",
  "editor-first12"  =>  "editor12-first",
  "editor-first13"  =>  "editor13-first",
  "editor-first14"  =>  "editor14-first",
  "editor-first15"  =>  "editor15-first",
  "editor-first16"  =>  "editor16-first",
  "editor-first17"  =>  "editor17-first",
  "editor-first18"  =>  "editor18-first",
  "editor-first19"  =>  "editor19-first",
  "editor-first20"  =>  "editor20-first",
  "editor-first21"  =>  "editor21-first",
  "editor-first22"  =>  "editor22-first",
  "editor-first23"  =>  "editor23-first",
  "editor-first24"  =>  "editor24-first",
  "editor-first25"  =>  "editor25-first",
  "editor-first26"  =>  "editor26-first",
  "editor-first27"  =>  "editor27-first",
  "editor-first28"  =>  "editor28-first",
  "editor-first29"  =>  "editor29-first",
  "editor-first30"  =>  "editor30-first",
  "editor-last1"    =>  "editor1-last",
  "editor-last2"    =>  "editor2-last",
  "editor-last3"    =>  "editor3-last",
  "editor-last4"    =>  "editor4-last",
  "editor-last5"    =>  "editor5-last",
  "editor-last6"    =>  "editor6-last",
  "editor-last7"    =>  "editor7-last",
  "editor-last8"    =>  "editor8-last",
  "editor-last9"    =>  "editor9-last",
  "editor-last10"   =>  "editor10-last",
  "editor-last11"   =>  "editor11-last",
  "editor-last12"   =>  "editor12-last",
  "editor-last13"   =>  "editor13-last",
  "editor-last14"   =>  "editor14-last",
  "editor-last15"   =>  "editor15-last",
  "editor-last16"   =>  "editor16-last",
  "editor-last17"   =>  "editor17-last",
  "editor-last18"   =>  "editor18-last",
  "editor-last19"   =>  "editor19-last",
  "editor-last20"   =>  "editor20-last",
  "editor-last21"   =>  "editor21-last",
  "editor-last22"   =>  "editor22-last",
  "editor-last23"   =>  "editor23-last",
  "editor-last24"   =>  "editor24-last",
  "editor-last25"   =>  "editor25-last",
  "editor-last26"   =>  "editor26-last",
  "editor-last27"   =>  "editor27-last",
  "editor-last28"   =>  "editor28-last",
  "editor-last29"   =>  "editor29-last",
  "editor-last30"   =>  "editor30-last",
  "editorn"         =>  "editor2",
  "editorn-link"    =>  "editor2-link",
  "editorn-last"    =>  "editor2-last",
  "editorn-first"   =>  "editor2-first",
  "interviewerlink" =>  "interviewer-link",
  "interviewermask" =>  "interviewer-mask",
  "firstn"          =>  "first2",
  "nocat"           =>  "no-tracking",
  "no-cat"          =>  "no-tracking",
  "notracking"      =>  "no-tracking",
  "ISBN"            =>  "isbn",
  "ibsn"            =>  "isbn",
  "ibsn2"           =>  "isbn",
  "lastn"           =>  "last2",
  "local"           =>  "location",
  "part"            =>  "issue",
  "no"              =>  "issue",
  "No"              =>  "issue",
  "No."             =>  "issue",
  "notestitle"      =>  "chapter",
  "nurl"            =>  "url",
  "origmonth"       =>  "month",
  "p"               =>  "page",
  "p."              =>  "page",
  "pmpmid"          =>  "pmid",
  "pp"              =>  "pages",
  "pp."             =>  "pages",
  "publisherid"     =>  "id",
  "titleyear"       =>  "orig-year",
  "origyear"        =>  "orig-year",
  "translators"     =>  "translator",
  "URL"             =>  "url",
  "vol"             =>  "volume",
  "Vol"             =>  "volume",
  "Vol."            =>  "volume",
  "ARXIV"           =>  "arxiv",
  "cointerviewers"  =>  "others",
  "trans_chapter"   =>  "trans-chapter",
  "trans_title"     =>  "trans-title",
  "DOI"             =>  "doi",
  "publication"     =>  "work", 
  "publicationplace"  =>  "publication-place", 
  "publicationdate"   =>  "publication-date", 
  "chapterurl"      =>  "chapter-url",
  "booktitle"       =>  "book-title",
 // "accessdate"      =>  "access-date",
 // "archivedate"     =>  "archive-date",
 // "archiveurl"      =>  "archive-url",
  "conferenceurl"   =>  "conference-url",
  "timecaption"     =>  "time-caption",
  "contributionurl" =>  "contribution-url",
  "laydate"         =>  "lay-date",
  "laysource"       =>  "lay-source",
  "layurl"          =>  "lay-url",
  "sectionurl"      =>  "section-url",
  "seriesno"        =>  "series-no",
  "nopp"            =>  "no-pp",
);
