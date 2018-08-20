<?php
session_start();
if(!isset($_SESSION['user_session'])){
	header("Location: index.php");
}
include('header.php');
include_once("db_connect.php");
$sql = "SELECT uid, user, pass, email FROM users WHERE uid='".$_SESSION['user_session']."'";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
$row = mysqli_fetch_assoc($resultset);
//include('container.php');
?>
<div class="container">    
	<div id="navbar" class="navbar-collapse collapse">
	 <ul class="nav navbar-nav navbar-right">            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $row['user']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li> -->
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
	</div>	
	<!--
	<div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
		Hello, <br><br>Welcome to the members page.<br><br>
    </div>		
</div><?php //include('footer.php');?> -->

<?php
/**
 * Simple Bookmark Tool 1.0
 * Robert Gerlach 2018
 * https://github.com/combatwombat/sbt
 *
 * Install:
 * - Have PHP, MySQL and SSL
 * - Create database
 * - Edit your data in the config array or an external config.php
 * - Upload sbt.php
 * - Click on hamburger menu and add bookmarklet
 */

if (file_exists('config.php')) {
    include('config.php');
} else {
    $config = array(
        'auth' => array(),
        'db' => array(
            'name'          => '$dbname',
            'user'          => '$username',
            'password'      => '$password',
            'host'          => '$servername',
        ),
        'app' => array(
            'timezone' => 'Europe/Berlin'
        )
    );
}
$messages = array();
// Basic HTTP auth

$dbSchema = <<<EOD
CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text,
  `title` text,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
EOD;
$dsn = "mysql:host=".$config['db']['host'].";dbname=".$config['db']['name'].";charset=utf8mb4";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$db = new PDO($dsn, $config['db']['user'], $config['db']['password'], $opt);
/**
 * API
 */
if (isset($_GET['api'])) {
    $success = false;
    // Add URL
    if (isset($_GET['add'])) {
        if (addBookmarkFromGET()) {
            echo "alert('Added to Simple Bookmark Tool');";
        } else {
            echo "alert('Error adding to Simple Bookmark Tool');";
        }
    // Delete URL
    } else if (isset($_GET['del'])) {
        if (isset($_POST['id'])) {
            $stmt = $db->prepare("DELETE FROM bookmarks WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $deleted = $stmt->rowCount();
            echo $deleted == 1 ? "1" : "";
        }
    }
    die();
/*
 * Website
 */
} else {
    // added with fallback method for pages with Content Security Policy?
    if (isset($_GET['add'])) {
        addBookmarkFromGET();
        if (isset($_GET['goback'])) {
            header("Location: " . $_GET['url']);
            die();
        }
    }
    // import something?
    if (isset($_POST['import']) && $_POST['import'] == "1") {
        $success = true;
        if (isset($_FILES['netscape_html']) && !empty($_FILES['netscape_html'])) {
            $html = file_get_contents($_FILES['netscape_html']['tmp_name']);
            $dom = new DOMDocument;
            $dom->loadHTML($html, LIBXML_PARSEHUGE);
            $links = $dom->getElementsByTagName('a');
            $linksCount = 0;
            foreach ($links as $link) {
                $url = $link->getAttribute('href');
                $title = $link->nodeValue;
                $description = $link->getAttribute('tags');
                $createdAt = gmdate("Y-m-d H:i:s", $link->getAttribute('add_date'));
                if (!addBookmark($url, $title, $description, $createdAt)) {
                    $messages[] = array('type' => 'error', 'text' => 'Error importing ' . $url);
                    $success = false;
                }
                $linksCount++;
            }
        }
        if ($success) {
            $messages[] = array('type' => 'success', 'text' => 'Imported ' . $linksCount . ' bookmarks.');
        } else {
            $messages[] = array('type' => 'error', 'text' => 'Error importing all bookmarks.');
        }
    }
    // are our tables missing? create them
    $res = $db->query("SHOW TABLES");
    $tables = $res->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array("bookmarks", $tables)) {
        echo "table <b>bookmarks</b> missing. creating...<br>";
        $res = $db->exec($dbSchema);
        if ($res !== false) {
            header("Refresh: 0");
            die();
        } else {
            echo "error creating tables";
            die();
        }
    } else {
        routeIndex();
    }
}
function addBookmarkFromGET() {
    if (isset($_GET['url']) && strlen($_GET['url']) > 0 && filter_var($_GET['url'], FILTER_VALIDATE_URL))
    {
        $url = $_GET['url'];
        $title = isset($_GET['title']) && strlen($_GET['title']) > 0 ? $_GET['title'] : '';
        $description = isset($_GET['description']) && strlen($_GET['description']) > 0 ? $_GET['description'] : '';
        return addBookmark($url, $title, $description);
    }
    return false;
}
function addBookmark($url, $title, $description, $createdAt = null) {
    global $db;
    if (strlen($url) > 0 && filter_var($url, FILTER_VALIDATE_URL)) {
        if ($createdAt == null) {
            $createdAt = gmdate("Y-m-d H:i:s");
        }
        $stmt = $db->prepare("INSERT INTO bookmarks SET url = ?, title = ?, description = ?, created_at = ?");
        $stmt->execute([$url, $title, $description, $createdAt]);
        $inserted = $stmt->rowCount();
        return $inserted == 1;
    }
    return false;
}
function routeIndex() {
    global $scriptURL, $db, $messages;
    $res = $db->query('SELECT * FROM bookmarks ORDER BY created_at DESC');
    $items = array();
    if ($res) {
        foreach ($res as $item) {
            $items[] = $item;
        }
    }
    $itemCount = count($items);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>bMarkr - Niel's Bookmarker</title>
        <link rel="icon" type="image/png" href="https://niel.site/bmark/bmark.png" />
		<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">


        <style media="screen">
            body {
                font-family: sans-serif;
                font-size: 0.8em;
                color: #000;
                background: #fff;
            }
            .site {
                margin: 0 auto;
                padding: 0 10px;
                width: 100%;
                max-width: 800px;
                box-sizing: border-box;
            }
            h1 a {
                color: #000;
            }
            .items {
                list-style-type: none;
                padding-left: 0;
            }
            .items li {
                margin-bottom: 2em;
            }
            a {
                text-decoration: none;
                color: #004df9;
            }
            .items h2,
            .items .description,
            .items .url {
                margin: 0 0 5px 0;
                word-break: break-word;
            }
            .items .meta time {
                color: #bbb;
            }
            .items .url {
                display: block;
                color: #228822;
            }
            .items .meta .delete {
                color: #ca0000;
            }
            .bookmarklet {
                display: inline-block;
                color: #000;
                background: #ccc;
                padding: 5px 10px;
                border-radius: 3px;
            }
            .messages {
                padding-left: 0;
                list-style-type: none;
            }
            .messages .message {
                padding-bottom: 5px;
            }
            .messages .message.success {
                color: #00ca00;
            }
            .messages .message.error {
                color: #ca0000;
            }
            #extra {
                padding-bottom: 1em;
                margin-bottom: 2em;
                border-bottom: 1px solid #ccc;
            }
            @media (max-width: 340px) {
                h1 {
                    font-size: 1.9em;
                }
            }
        </style>

        <script type="text/javascript">
            function ready(fn) {
                if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
                    fn();
                } else {
                    document.addEventListener('DOMContentLoaded', fn);
                }
            }
            ready(function() {
                // delete items
                var elements = document.querySelectorAll('a.delete');
                Array.prototype.forEach.call(elements, function(el, i){
                    el.addEventListener('click', function(ev) {
                        var id = el.getAttribute('data-id');
                        if (id) {
                            if (confirm("Really?")) {  
								var request = new XMLHttpRequest();
                                request.open('POST', '<?php echo $scriptURL;?>?api&del', true);
                                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                request.onload = function() {
                                    if (request.status >= 200 && request.status < 400) {
                                        var res = request.responseText;
                                        if (res == "1") {
                                            // remove from html
                                            var item = document.querySelectorAll('.items li[data-id="'+id+'"]')[0];
                                            item.parentNode.removeChild(item);
                                            // all empty? show message
                                            var items = document.querySelectorAll('.items li');
                                            if (items.length == 0) {
                                                document.getElementById('empty').style.display = 'block';
                                            }
                                        											}
                                    } else {
                                        alert("Error deleting.");
                                    }
                                };
                                request.onerror = function() {
                                    alert("Connection error.");
                                };
                                request.send("id="+id);
                            }
                        }
                        ev.preventDefault();
                    });
                });
                // show extra content
                var menuButton = document.getElementById('menu');
                var extraContent = document.getElementById('extra');
                if (menuButton) {
                    menuButton.addEventListener('click', function(ev) {
                        if (extraContent.style.display == 'none') {
                            extraContent.style.display = 'block';
                        } else {
                            extraContent.style.display = 'none';
                        }
                        ev.preventDefault();
                    });
                }
            });
        </script>
		
		<!-- From here
		
		<style>
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
		To here-->
		
		
		
    </head>
    <body style="font-size: 12px;">
        <div id="site" class="site" style="margin-top: -30px;">
            <h1><a href="<?php echo $scriptURL;?>" style="font-family: sans-serif; font-size: 0.8em; color: #000; font-weight: bold; font-family: 'Libre Baskerville', serif;">bMarkr</a> <a href="#" id="menu"><img src="bmark.png" style="margin-left: -10px; margin-top: -15px" width="30px" hight="30px"></a></h1><div style="margin-top:-30px; padding-left: 160px; float: left; font-size: 10px; font-style: italic; font-family: 'Libre Baskerville', serif;"><p>&laquo;simplicity is genius&raquo;</p></div>
            <?php if (empty($_SERVER['HTTPS'])) { ?>
                <p style="color: #ca0000;">
                    This should run on http<b style="color: #f00;">s</b> to work.
                </p>
            <?php } ?>

            <?php if (!empty($messages)) { ?>
            <ul class="messages">
                <?php foreach ($messages as $message) { ?>
                <li class="message <?php echo $message['type'];?>">
                    <?php echo $message['text']; ?>
                </li>
                <?php }?>
            </ul>
            <?php } ?>

            <div id="extra" style="display: none;">
                <p>
                    Bookmarklet: <a class="bookmarklet" href="<?php echo bookmarklet();?>">bMarked!</a>
                </p>
                <p>
                    Bookmarks: <?php echo $itemCount;?>
                </p>
                <p>
                    Netscape Bookmark HTML Import:
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="netscape_html">
                        <input type="submit" value="Import">
                        <input type="hidden" name="import" value="1">
                    </form>
                </p>
            </div>

            <?php if ($itemCount > 0) { ?>
                <ul class="items" style="margin-top: 0px;">					
                    <?php foreach ($items as $item) { ?>
                      <li data-id="<?php echo $item['id'];?>" style="margin-bottom: 0px;">
                            <h2>
                                <a class="title" target="_blank" href="<?php echo $item['url'];?>" style="font-size: 15px; font-weight: bold;">
                                    <?php echo strlen($item['title']) > 0 ? htmlspecialchars($item['title']) : 'no title';?>
                                </a>
                            </h2>
                            <a target="_blank" class="url" href="<?php echo $item['url'];?>">
                                <?php echo htmlspecialchars($item['url']);?>
                            </a>
                            <?php if (strlen($item['description']) > 0) { ?>
                                <p class="description">
                                    <?php echo htmlspecialchars(textShorten($item['description'], 1000)); ?>
                                </p>
                            <?php } ?>
                            <div class="meta">
                                	<time>
                                   		 <?php echo htmlspecialchars(localDateTime($item['created_at'], 'd. M Y H:i:s')); ?>
                               		</time>
                                	&middot;	
								   <a class="delete" data-id="<?php echo $item['id'];?>" href="#">delete</a>

							</div>
                       </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <em id="empty" <?php echo $itemCount > 0 ? 'style="display: none;"' : '';?>>empty</em>
        </div>
    </body>
    </html>
<?php }
function bookmarklet() {
    global $scriptURL;
    $js = <<<EOD
(function() {
    var desc = '';
    var selectedText = '';
    if (window.getSelection) {
        selectedText = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        selectedText = document.selection.createRange().text;
    };
    if (selectedText != '') { desc = selectedText; } else {
        var descMeta = document.querySelectorAll('meta[name="description"]');
        if (descMeta.length) { desc = descMeta[0].getAttribute('content') };
    };
    var apiURL='{$scriptURL}?api&add&url=' + encodeURIComponent(document.URL) + '&title=' + encodeURIComponent(document.title) + '&description=' + encodeURIComponent(desc);
    var webURL='{$scriptURL}?add&goback&url=' + encodeURIComponent(document.URL) + '&title=' + encodeURIComponent(document.title) + '&description=' + encodeURIComponent(desc);
    var el=document.createElement('script');
    el.src=apiURL;
    el.onerror=function() {
        if (confirm("Add to Simple Bookmark Tool?")) {
            window.location.href = webURL;
        }
    };    
    document.body.appendChild(el); 
})();
EOD;
    return "javascript:" . rawurlencode(str_replace("  ", " ", str_replace("\n", " ", $js)));
}
/// Helpers
function textShorten($str, $textlength = 500) {
    if (strlen($str) > $textlength) {
        $str = substr($str, 0, $textlength); // might cut off the last word
        $strArr = explode(" ", $str);
        if (count($strArr) > 1) {
            array_pop($strArr); // remove last element, the cut off word
            $str = implode(" ", $strArr);
            $str .= " [...]";
        } else {
            $str .= "...";
        }
        $str = trim($str);
    }
    return $str;
}
function localDateTime($utcDateTime, $format='Y-m-d H:i:s') {
    global $config;
    $local = new DateTimeZone($config['app']['timezone']);
    $utc = new DateTimeZone("UTC");
    $date = new DateTime($utcDateTime, $utc);
    $date->setTimezone($local);
    return $date->format($format);
}
?>
