<?php
class CContent {
    private $db;
    private $id;
    private $output;
    private $res;
    private $title;
    private $slug;
    private $url;
    private $data;
    private $type;
    private $published;
    public $types;
    //private $filter;

public function __construct($db){
    $this->db=$db;
    $this->filter=new CTextFilter;
    $this->output=null;
}

/**
 * Create a link to the content, based on its type.
 *
 * @param object $content to link to.
 * @return string with url to display content.
 */
public function getUrlToContent($content) {
  switch($content->TYPE) {
    case 'page': return "page.php?url={$content->url}"; break;
    case 'post': return "blog.php?slug={$content->slug}"; break;
    default: return null; break;
  }
}

// Get all content
public function getAllContent(){
$admin = isset($_SESSION['admin']) ? $_SESSION['admin']->acronym : null;
$types    = isset($_GET['type']) ? $_GET['type'] : null;
$params = array();
$sql2 = null;
$sql1 = '
  SELECT *, (published <= NOW())
  FROM Pcontent';
if($types){
  $sql2= ' WHERE TYPE = ?';
  $params[] = $types;
}
$sql3= ' ORDER BY published DESC;';
$sql= $sql1 . $sql2 . $sql3;
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
// Put results into a list
//dump($sql);
$items = null;

foreach($res AS $key => $val) {
  $items .= "<div class='blogpost'><a href='blog.php?slug={$val->slug}'><h3>{$val->title}</h3></a>";
  $items .= strstr("<p>{$val->DATA}", '.', true);
  $items .= "... <a href='blog.php?slug={$val->slug}'>Läs vidare</a></p>";
  $items .= "<p class='published'>Publicerad: {$val->published} Kategori: <a href='?type={$val->TYPE}'>{$val->TYPE}</a></p></div>";
  if ($admin) {
    $items .= "<p><a class='edit' href='edit.php?id={$val->id}'>Editera: {$val->title} </a> <a class='edit' href='?delete={$val->id}'>Radera</a><a class='edit' href='create.php'>Skapa nytt innehåll</a></p>";
  }
  //$items .= "<p>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " (<a href='edit.php?id={$val->id}'>editera</a> <a href='?delete={$val->id}'>Radera</a> <a href='blog.php?slug={$val->slug}'>visa</a>)</p>\n";
}
return $items;
}

public function setParams($id,$title,$slug,$data,$type,$filter,$published){
        $this->id=$id;
        $this->title=$title;
        $this->slug=$slug;
        //$this->url=$url;
        $this->DATA=$data;
        $this->TYPE=$type;
        $this->filter=$filter;
        $this->published=$published;
}

//Gets row from chosen id. Creates form for updating.
public function makeEditPage(){
// Select all from database
$sql = 'SELECT * FROM Pcontent WHERE id = ?';
$this->res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($this->id));

if(isset($this->res[0])) {
  $c = $this->res[0];
}
else {
  die('Misslyckades: det finns inget innehåll med sådant id.');
}

// Sanitize content before using it.
$this->title  = htmlentities($c->title, null, 'UTF-8');
$this->slug   = htmlentities($c->slug, null, 'UTF-8');
//$this->url    = htmlentities($c->url, null, 'UTF-8');
$this->DATA   = htmlentities($c->DATA, null, 'UTF-8');
$this->TYPE   = htmlentities($c->TYPE, null, 'UTF-8');
$this->filter = htmlentities($c->FILTER, null, 'UTF-8');
$this->published = htmlentities($c->published, null, 'UTF-8');

$html="<form method=post>
  <input type='hidden' name='id' value='{$this->id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$this->title}'/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value='{$this->slug}'/></label></p>
  <p><label>Text:<br/><textarea name='data'>{$this->DATA}</textarea></label></p>
  <p><label>Kategori:<br/><input type='text' name='type' value='{$this->TYPE}'/></label></p>
  <p><label>Filter:<br/><input type='text' name='filter' value='{$this->filter}'/></label></p>
  <p><label>Publiceringsdatum:<br/><input type='text' name='published' value='{$this->published}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='view.php'>Visa alla</a></p>
  <output>{$this->output}</output>
</form>";
return $html;
}

//Saves updated versions.
public function saveEdit(){
  $sql = '
    UPDATE Pcontent SET
      title   = ?,
      slug    = ?,
      data    = ?,
      type    = ?,
      filter  = ?,
      published = ?,
      updated = NOW()
    WHERE 
      id = ?
  ';
  $params = array($this->title, $this->slug, $this->DATA, $this->TYPE, $this->filter, $this->published, $this->id);
  $res = $this->db->ExecuteQuery($sql, $params);
  if($res) {
    $this->output = 'Informationen sparades.';
  }
  else {
    $this->output = 'Informationen sparades EJ.<br><pre>' . print_r($this->db->ErrorInfo(), 1) . '</pre>';
  }
}

//Resets the database.
public function fillTable(){
  $admin = isset($_SESSION['admin']) ? $_SESSION['admin']->acronym : null;
  $sql= "
  DROP TABLE IF EXISTS Content;";
$sql .="CREATE TABLE Content
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  slug CHAR(80) UNIQUE,
  url CHAR(80) UNIQUE,
 
  TYPE CHAR(80),
  title VARCHAR(80),
  DATA TEXT,
  FILTER CHAR(80),
 
  published DATETIME,
  created DATETIME,
  updated DATETIME,
  deleted DATETIME
 
) ENGINE INNODB CHARACTER SET utf8;";

$sql .=<<<EOD
 INSERT INTO Content (slug, url, type, title, data, filter, published, created) VALUES
            ('hem', 'hem', 'page', 'Hem', "Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", 'bbcode,nl2br', NOW(), NOW()),
            ('om', 'om', 'page', 'Om', "Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", 'markdown', NOW(), NOW()),
            ('blogpost-1', NULL, 'post', 'Välkommen till min blogg!', "Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", 'clickable,nl2br', NOW(), NOW()),
            ('blogpost-2', NULL, 'post', 'Nu har sommaren kommit', "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.", 'nl2br', NOW(), NOW()),
            ('blogpost-3', NULL, 'post', 'Nu har hösten kommit', "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost", 'nl2br', NOW(), NOW())
EOD;

isset($admin) or die('Check: You must login to reset.');
$this->db->ExecuteQuery($sql);
}

//Allows for creation of posts in table Content.
public function makeCreatePage(){
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $data = $_POST['data'];
        $type = $_POST['type'];
        $filter = $_POST['filter'];
        //$published = $_POST['published'];
        //Clean inputs
        $title = strip_tags($title);
        $type = in_array($type, array('Filmtips', 'Fun facts', 'Nyheter', 'Erbjudande')) ? $type : null; 
        $sql = 'INSERT INTO Pcontent (title, slug, DATA, TYPE, FILTER, published, created) VALUES(?, ?, ?, ?, ?, NOW(), NOW())'; 
        $params = array($title, $slug, $data, $type, $filter); 
        $res = $this->db->ExecuteQuery($sql, $params);
        
return $res;

}

//Deletes content from table based on id.
public function deleteContent($id){
        $admin = isset($_SESSION['admin']) ? $_SESSION['admin']->acronym : null;
        $sql = "DELETE FROM Pcontent WHERE id = ?;";
        $params = array($id);
        isset($admin) or die('Check: You must login to delete.');
        $res = $this->db->ExecuteQuery($sql, $params);
        return $res;
    } 

public function getNewestBlog(){
  $sql = 'SELECT *, (published <= NOW())
  FROM Pcontent ORDER BY published DESC LIMIT 3;';
  $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
  $html="<div class='miniblogpost'>";
  foreach ($res as $key => $val) {
    $html .="<a href='blog.php?slug={$val->slug}'><h4>{$val->title}</h4></a>";
    $html .= strstr("<p>{$val->DATA}", '.', true);
    $html .= "... <a href='blog.php?slug={$val->slug}'>Läs vidare</a></p><hr>";
  }
  $html .= "<a href='view.php'>Se alla bloggposter</a><p></p>";
  $html .= "</div>";
  return $html;
}


}