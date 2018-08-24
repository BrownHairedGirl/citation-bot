<?php 
$constant_files = glob('constants/*.php');
foreach ($constant_files as $file) {
    require($file);   
}

define('HOME', dirname(__FILE__) . '/');

const PIPE_PLACEHOLDER = '# # # CITATION_BOT_PLACEHOLDER_PIPE # # #';
const TEMP_PLACEHOLDER = "# # # CITATION_BOT_PLACEHOLDER_TEMPORARY %s # # #";
const TO_EN_DASH = "--?|\&mdash;|\xe2\x80\x94|\?\?\?"; // regexp for replacing to ndashes using mb_ereg_replace
const EN_DASH = "\xe2\x80\x93"; // regexp for replacing to ndashes using mb_ereg_replace
const WIKI_ROOT = "https://en.wikipedia.org/w/index.php";
const API_ROOT = "https://en.wikipedia.org/w/api.php"; // wiki's API endpoint
const TEMPLATE_REGEXP = "~\{\{\s*([^\|\}]+)([^\{]|\{[^\{])*?\}\}~";
const BRACESPACE = "!BOTCODE-spaceBeforeTheBrace";
const BIBCODE_REGEXP = "~^(?:https?://(?:\w+.)?adsabs.harvard.edu|https?://ads\.ari\.uni-heidelberg\.de|https?://ads\.inasan\.ru|https?://ads\.mao\.kiev\.ua|https?://ads\.astro\.puc\.cl|https?://ads\.on\.br|https?://ads\.nao\.ac\.jp|https?://ads\.bao\.ac\.cn|https?://ads\.iucaa\.ernet\.in|https?://ads\.lipi\.go\.id|https?://cdsads\.u-strasbg\.fr|https?://esoads\.eso\.org|https?://ukads\.nottingham\.ac\.uk|https?://www\.ads\.lipi\.go\.id)/.*(?:abs/|bibcode=|query\?|full/)([12]\d{3}[\w\d\.&]{15})~";
const DOI_REGEXP = "~10\.\d{4,6}/\S+~";
const IN_PRESS_ALIASES = array("in press", "inpress", "pending", "published", 
                               "published online", "no-no", "n/a", "online ahead of print", 
                               "unpublished", "unknown", "tba", "forthcoming", "in the press", 
                               "na", "submitted", "tbd", "missing");
const BAD_ACCEPTED_MANUSCRIPT_TITLES = array("oup accepted manuscript", "placeholder for bad pdf file", 
                                             "placeholder", "symbolic placeholder", "[placeholder]", 
                                             "placeholder for arabic language transliteration");
const SICI_REGEXP = "~(\d{4}-\d{3}[\dxX])" . // ISSN
                    "\((\d{4})(\d{2})?/?(\d{2})?\)" . // Chronology, YY MM DD
                    "(\d+):?([\+\d]*)" . // Enumeration: Volume / issue
                    "[<\[]" . "(\d+)::?\w+" . "[>\]]" . "2\.0\.CO;2\-?[A-z0-9]?~";

//Common replacements
const HTML_DECODE = array("[", "]", "<", ">", " ");
const HTML_ENCODE = array("&#x5B;", "&#x5D;", "&#60;", "&#62;", "+");

const DOT_ENCODE = array(".2F", ".5B", ".7B", ".7D", ".5D", ".3C", ".3E", ".3B", ".28", ".29");
const DOT_DECODE = array("/", "[", "{", "}", "]", "<", ">", ";", "(", ")");

// Some data we get from outside sources is bad or at least mis-defined
// Use lower case for all of these, and then compare to a lower cased version
const BAD_AUTHORS = array("unknown", "missing");
const AUTHORS_ARE_PUBLISHERS = array(); // Things from google like "hearst magazines", "time inc", 
                                        // "nielsen business media, inc" that the catch alls do not detect
const AUTHORS_ARE_PUBLISHERS_ENDINGS = array("inc.", "inc", "magazines", "press", "publishing",
                                             "publishers", "books", "corporation");
const HAS_NO_VOLUME = array("zookeys");  // Some journals have issues only, no volume numbers
const BAD_TITLES = array("unknown", "missing", "arxiv e-prints");

// dontCap is am array of strings that should not be capitalized in their titlecase format; 
// unCapped is their correct capitalization. Remember to enclose any word in spaces.

const LC_SMALL_WORDS = array(' and then ', ' of ',' the ',' and ',' an ',' or ',' nor ',' but ',' is ',' if ',' its ',
                             ' then ',' else ',' when ', ' at ',' from ',' by ',' on ',' off ',' for ',' in ',' over ',
                             ' to ',' into ',' with ',' U S A ',' USA ',' y ', ' für ', ' de ', ' zur ', ' der ', ' und ',
                             ' du ', ' et ', ' la ', ' le ', ' DNA ', ' UK ', ' FASEB ', ' van ', ' von ', ' AJHG ',
                             ' BBA ', ' BMC ', ' BMJ ', ' EMBO ', ' FEBS ', ' FEMS ', ' JAMA ', ' MNRAS ', ' NEJM ', 
                             ' NYT ', ' PCR ', ' PNAS ', ' RNA ',  ' zu ' , ' des ', ' aus ', ' dem ', ' del ', ' dei ', 
                             ' di ', ' ed ', ' du ', ' de ', ' dans ', ' les ', ' e ', ' den ', ' die ', ' das ', ' ein ', 
                             ' eine ', ' einen ', ' NYC ', ' d\'une ', ' d\'un ', ' el ',  ' los ', ' las ', ' as ',
                             ' nor ',' at ', ' up ', ' NY ', ' N Y ', ' för ', ' da ', ' SSRN ', ' AI ', ' woor ', ' do ',
                             ' um ', ' von ', ' della ',
                             // After this line we list exceptions that need re-capitalizing after they've been decapitalized.
                             ' El Dorado ', ' Las Vegas ', ' Los Angeles ');
const UC_SMALL_WORDS = array(' and Then ', ' Of ',' The ',' And ',' An ',' Or ',' Nor ',' But ',' Is ',' If ',' Its ',
                             ' Then ',' Else ',' When ', ' At ',' From ',' By ',' On ',' Off ',' For ',' In ',' Over ',
                             ' To ',' Into ',' With ',' U S A ',' Usa ',' Y ', ' Für ', ' De ', ' Zur ', ' Der ', ' Und ',
                             ' Du ', ' Et ', ' La ', ' Le ', ' Dna ', ' Uk ', ' Faseb ', ' Van ', ' Von ', ' Ajhg ',
                             ' Bba ', ' Bmc ', ' Bmj ', ' Embo ', ' Febs ', ' Fems ', ' Jama ', ' Mnras ', ' Nejm ', 
                             ' Nyt ', ' Pcr ', ' Pnas ', ' Rna ',  ' Zu ' , ' Des ', ' Aus ', ' Dem ', ' Del ', ' Dei ', 
                             ' Di ', ' Ed ', ' Du ', ' De ', ' Dans ', ' Les ', ' E ', ' Den ', ' Die ', ' Das ', ' Ein ', 
                             ' Eine ', ' Einen ', ' Nyc ', ' D\'une ', ' D\'un ', ' El ',  ' Los ', ' Las ', ' As ',
                             ' Nor ',' At ', ' Up ', ' Ny ', ' N y ', ' För ', ' Da ', ' Ssrn ', ' Ai ', ' Woor ', ' Do ',
                             ' Um ', ' Von ', ' Della ',
                             // After this line we list exceptions that need re-capitalizing after they've been decapitalized.
                             ' el Dorado ', ' las Vegas ', ' los Angeles ');

const JOURNAL_ACRONYMS = array(
' ACM SIGPLAN Notices ', ' ASME AES ', ' ASME MTD ', ' BioEssays ', ' BMJ ',
' CBD Ubiquitin ', ' CFSK-DT ', ' e-Neuroforum ', 
' Early Modern Japan: an Interdisciplinary Journal ', ' eLife ', ' EMBO J ', ' EMBO J. ', ' EMBO Journal ',
' EMBO Rep ', ' EMBO Rep. ', ' EMBO Reports ', ' FASEB J ', ' FASEB J. ', ' FEBS J ', ' FEBS J. ', ' FEBS Journal ',
' HOAJ biology ', ' iConference ', ' IFAC-PapersOnLine ', ' ISRN Genetics ',
' JABS : Journal of Applied Biological Sciences ', ' JAMA Psychiatry ', ' Journal of Materials Chemistry A ',' Journal of the IEST ', 
' Molecular and Cellular Biology ', ' NASA Tech Briefs ', ' Ocean Science Journal : OSJ ', 
' PALAIOS ',  ' PLOS Biology ', ' PLOS Medicine ', ' PLOS Neglected Tropical Diseases ', ' PLOS ONE ', ' PNAS ',
' RNA ',
' S.A.P.I.EN.S ', ' Star Trek: The Official Monthly Magazine ',     ' Tellus A ', ' The EMBO Journal ', ' Time Out London ',
' z/Journal ', ' Zeitschrift für Geologische Wissenschaften ', ' Zeitschrift für Physik A Hadrons and Nuclei ', ' Zeitschrift für Physik A: Hadrons and Nuclei ',
' ZooKeys ');
const UCFIRST_JOURNAL_ACRONYMS = array(
' Acm Sigplan Notices ', ' Asme Aes ', ' Asme Mtd ', ' Bioessays ', ' Bmj ',
' Cbd Ubiquitin ', ' Cfsk-Dt ', ' E-Neuroforum ', 
' Early Modern Japan: An Interdisciplinary Journal ', ' Elife ', ' Embo J ', ' Embo J. ', ' Embo Journal ', 
' Embo Rep ', ' Embo Rep. ', ' Embo Reports ', ' Faseb J ', ' Faseb J. ', ' Febs J ', ' Febs J. ', ' Febs Journal ',
' Hoaj Biology ', ' Iconference ', ' Ifac-Papersonline ', ' Isrn Genetics ',
' Jabs : Journal Of Applied Biological Sciences ', ' Jama Psychiatry ', ' Journal Of Materials Chemistry A ', ' Journal Of The Iest ', 
' Molecular And Cellular Biology ', ' Nasa Tech Briefs ', ' Ocean Science Journal : Osj ', 
' Palaios ', ' Plos Biology ', ' Plos Medicine ', ' Plos Neglected Tropical Diseases ', ' Plos One ', ' Pnas ', 
' Rna ',
' S.a.p.i.en.s ', ' Star Trek: The Official Monthly Magazine ', ' Tellus A ', ' The Embo Journal ', ' Time Out London ',
' Z/journal ', ' Zeitschrift Für Geologische Wissenschaften ', ' Zeitschrift Für Physik A Hadrons And Nuclei ', ' Zeitschrift Für Physik A: Hadrons And Nuclei ',
' Zookeys '); 
