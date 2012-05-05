<?PHP

/**
 * Load country list from iso.org and insert into mysql-table "Countries"
 * 
 * @link http://www.iso.org/iso/list-en1-semic-3.txt
 * @see http://www.iso.org/iso/country_codes/iso_3166_code_lists.htm
 * @author adlerweb
 **/

require('../../../config.php');    //Set this to a configuration containing valid
                                //MySQL credentials
                                
require('../mysql.php');

$list = file("http://www.iso.org/iso/list-en1-semic-3.txt");
unset($list[0]);
if(!$list || !is_array($list) || count($list) < 10 ) die('Could not load list');

//Clear current table
$GLOBALS['adlerweb']['sql']->query('TRUNCATE TABLE  `Countries`');

$stmt = $GLOBALS['adlerweb']['sql']->prepare("INSERT INTO `Countries` (`Alpha2` ,`Name`) VALUES (?, ?);");

foreach($list as $line) {
    if(preg_match('|([^;]+);(..)\s|', utf8_encode($line), $match)) {
        $stmt->bind_param("ss", $match[2], $match[1]);
        $stmt->execute();
        echo $match[2].' -> '.$match[1]."\n";
    }
}

?>