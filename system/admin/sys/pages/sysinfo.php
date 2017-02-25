<?php
	//Paranoid Cody again
	if(!$runningInIndex){
		header('HTTP/1.0 403 Forbidden');
		die('403 FORBIDDEN: You are not allowed to access that file outside its normal running location.');
	}
?>

<style>
	.hoveringBox{
		box-shadow: 1px 1px 29px -5px rgba(0,0,0,0.66);
		max-width:90%;
		width:650px;
		border:2px solid<?php echo($theme['bodyBackground']) ?>;
		padding:10px;margin-top:10px;
	}
	
	.hoveringBoxTitle{
		padding:0;
		margin:0;
	}
	
	.hoveringBoxTitleImage{
		display:inline;
		height:32px;
		width:32px;
		margin-bottom:-8px;
		margin-right:5px;
	}
</style>

<!-- Server info -->
<div class="hoveringBox">
	<h3 class="hoveringBoxTitle"><img class="hoveringBoxTitleImage" src="./system/main/theme/icon/info.svg"/>Software</h3>
	<?php
		//Php version
		$phpversion = explode("-",phpversion());
		
		//Hosted
		if($hosted){
			$host = 'Yes';
		}else{
			$host = 'No';
		}
		
		//DUMP
		echo('<p>Tailbone: '.$TB['version'].'<br>Web: '.$_SERVER['SERVER_SOFTWARE'].'<br>php: '.$phpversion[0].'<br>OS: '.PHP_OS.'<br>Host: '.$serverVars['hostName'].' - '.$serverVars['hostVersion'].'</p>');
	?>
</div>

<!-- Disk stuff-->
<div class="hoveringBox">
	<h3 class="hoveringBoxTitle"><img class="hoveringBoxTitleImage" src="./system/main/theme/icon/storage.svg"/>Storage</h3>
	<?php
		//Calculating!
		$spacePercent = 100 - (round(disk_free_space('/')/disk_total_space('/'),2)*100);
		
		//And round it up if too low
		if($spacePercent < 1){
			$spacePercent = 1;
		}
		
		//DUMP
		echo('<p style="margin:5px;">Space used: '.$spacePercent.'%</p><div style="background:'.$theme['bodyBackground'].';width:600px; max-width:90%; padding:6px;"><div style="background:'.$theme['contentBackground'].'; width:'.$spacePercent.'%;text-align:center;min-width:30px;">'.$spacePercent.'%</div></div>');
		
		//Max file upload
		$maxFileSize = str_replace("M"," Megabytes",ini_get("upload_max_filesize"));
		
		echo('<p>Maximum upload file size: '.$maxFileSize.'</p>');
	?>
</div>

<!-- CPU and Memory Stats -->
<div class="hoveringBox">
	<h3 class="hoveringBoxTitle"><img class="hoveringBoxTitleImage" src="./system/main/theme/icon/mem.svg"/>Load</h3>
	<?php
	
		//CPU Load
		$load = sys_getloadavg();
		$loadPercent = $load[1] * 100;
    
    echo('<p style="margin:5px;">CPU Usage (5m avg): '.$loadPercent.'%</p><div style="background:'.$theme['bodyBackground'].';width:600px; max-width:90%; padding:6px;"><div style="background:'.$theme['contentBackground'].'; width:'.$loadPercent.'%;text-align:center;min-width:30px;">'.$loadPercent.'%</div></div>');
    
    //Get the memory stats
    $free = (string)trim(shell_exec('free'));
		$freeArr = explode("\n", $free);
		
		//Clean it
		$mem = explode(" ", $freeArr[1]);
		$mem = array_merge(array_filter($mem));
		
		//And format it
		$memoryUsage = round($mem[2]/$mem[1]*100,2);
	 
    echo('<p style="margin:5px;">Memory used: '.$memoryUsage.'%</p><div style="background:'.$theme['bodyBackground'].';width:600px; max-width:90%; padding:6px;"><div style="background:'.$theme['contentBackground'].'; width:'.$memoryUsage.'%;text-align:center;min-width:30px;">'.$memoryUsage.'%</div></div>');
	?>
</div>

<!-- Server settings (pages, adcontent, analytics, custom css -->
<div class="hoveringBox">
	<h3 class="hoveringBoxTitle"><img class="hoveringBoxTitleImage" src="./system/main/theme/icon/website.svg"/>This site</h3>
	
	<?php
		//Get the user pages
		$pageCount = 0;
		
		foreach(scandir('./data/pages/') as $page){
			if($page != '.' && $page != '..'){
				$pageCount ++;
			}
		}
		
		//Check for ad content
		if(file_get_contents('./data/adContent.php') != ''){
			$ads = 'Yes';
		}else{
			$ads = 'No';
		}
		
		//Check for analytics
		if(file_get_contents('./data/analyticsCode.php') != ''){
			$analytics = 'Yes';
		}else{
			$analytics = 'No';
		}
		
		//Count the users
		function countUsers(){
			require('./data/users.php');
			return count($users);
		}
	
	
		//Check the CSS
		$cCsS = file_get_contents('./data/custom.css');
	
		if($cCsS != '' && $cCsS != '/*Put your custom CSS here.*/'){
			$customCss = 'yes';
		}else{
			$customCss = 'No';
		}
	
		echo('<p>Using a web host: '.$host.'<br>Users: '.countUsers().'<br>Pages: '.$pageCount.'<br>Ads: '.$ads.'<br>Analytics: '.$analytics.'<br>Custom CSS: '.$customCss.'</p>');
	?>
</div>

<!-- More server info -->
<div class="hoveringBox">
	<h3 class="hoveringBoxTitle"><img class="hoveringBoxTitleImage" src="./system/main/theme/icon/server.svg"/>Web host</h3>
	<?php
		//Check to see if it's hosted
		if($hosted){
			echo('<p>Server name: '.$serverVars['serverName'].'<br>Server ID: '.$serverVars['serverID'].'<br>Admin email: '.$serverVars['serverAdminEmail'].'<br>Server Company: '.$serverVars['serverCo'].'</p>');
		}else{
			echo('<p>You are not part of a host.</p>');
		}
	?>
</div>