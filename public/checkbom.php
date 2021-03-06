<?php
	if (isset($_GET['dir']))  //设置文件目录
	{
		$basedir=$_GET['dir'];
	}
	else
	{
		$basedir = '.';
	}
	$auto = 1;
	checkdir($basedir);

	function checkdir($basedir)
	{
		if ($dh = opendir($basedir)) 
		{
			while (($file = readdir($dh)) !== false)
			{
			   if ($file != '.' && $file != '..')
			   {
					if (!is_dir($basedir."/".$file)) 
					{
					     $ext = getExtension($file);
						 if($ext != 'css' && $ext !='js' && $ext !='html' && $ext !='htm' && $ext!='php' && $ext!='json') continue;
						 if(strpos($basedir,'/Cache') > 0) continue;
						 if(strpos($basedir,'/ThinkPHP') > 0) continue;
						 if(strpos($basedir,'/Public/Min') > 0) continue;
						 if(strpos($basedir,'/Common/Extend') > 0) continue;
						 if(strpos($basedir,'/Public/kindeditor') > 0) continue;
						 if(strpos($basedir,'/Public/Js') == 1) continue;						
						 echo "$basedir/$file ".checkBOM("$basedir/$file")." <br>";
					}
					else
					{
						 $dirname = $basedir."/".$file;
						 checkdir($dirname);
					}
			   }
			}
			closedir($dh);
		}
	}
    
	function getExtension($file) 
	{	    
	    return strtolower(substr($file, strrpos($file, '.')+1)); 
	}

	function checkBOM ($filename)
	{
		global $auto;
		$contents = file_get_contents($filename);
		$charset[1] = substr($contents, 0, 1);
		$charset[2] = substr($contents, 1, 1);
		$charset[3] = substr($contents, 2, 1);
		if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191)
		{
			if ($auto == 1) 
			{
			   $rest = substr($contents, 3);
			   rewrite ($filename, $rest);
			   return ("　<font style='color:#f00;'>[ BOM ]</font>");
			}
			else 
			{
			   return ("　<font style='color:#00f;'>[ BOM ]");
			}
		}
		else 
			return ('');
	}

	function rewrite ($filename, $data) 
	{
		$filenum = fopen($filename, "w");
		flock($filenum, LOCK_EX);
		fwrite($filenum, $data);
		fclose($filenum);
	}
?>